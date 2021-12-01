<?php

namespace App\Http\Controllers;

use App\Events\ControlEvent;
use App\Exports\HistoryExport;
use App\Http\Requests\UserRequest;
use App\Http\Resources\HistoryResource;
use App\Mail\ControlMail;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MainController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $user = User::query()
            ->where('uniqueId', $request->get('uniqueId'))
            ->select('id')
            ->firstOrFail();
        DB::beginTransaction();
        $history = History::query()->updateOrCreate([
            'user_id' => $user->id,
            'day' => Carbon::now()->format('Y-m-d'),
        ]);
        if ($request->get('status') && !$history['arrival_time']) {
            $history['arrival_time'] = Carbon::now('Asia/Tashkent')->format('H:i:s');
        } else if (!$request->get('status') && $history['arrival_time'] && !$history['departure_time']) {
            $history['departure_time'] = Carbon::now('Asia/Tashkent')->format('H:i:s');
        } else {
            DB::rollBack();
            return response()->json('Something went wrong', 400);
        }
        $history->save();
        $data = [
            'day' => $history['day'],
            'arrival_time' => $history['arrival_time'],
            'departure_time' => $history['departure_time'],
            'user_id' => $history['user_id'],
            'user' => [
                'name' => User::query()->find($history['user_id'])->name,
                'uniqueId' => User::query()->find($history['user_id'])->uniqueId,
            ]
        ];
        event(new ControlEvent($data));
        DB::commit();
        return response()->json('Successfully added', 201);
    }

    public function home()
    {
        return view('home');
    }

    public function create()
    {
        return view('create');
    }

    public function store(UserRequest $request): JsonResponse
    {
        User::query()->create($request->all());
        return response()->json('Successfully added', 201);
    }

    public function getHistoriesApi(): JsonResponse
    {
        $histories = History::with('user')->latest()->get();
        return response()->json($histories, 200);
    }

    public function search($searchedUser): JsonResponse
    {
        $search = strtolower($searchedUser);
        $histories = History::query()
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->with('user')
            ->latest()
            ->get();
        return response()->json($histories, 200);
    }

    public function excel(): BinaryFileResponse
    {
        return Excel::download(new HistoryExport, 'histories.xlsx');
    }

    public function mailSend(): JsonResponse
    {
        Mail::to('newControl@example.com')->send(new ControlMail());

        return response()->json('Successfully send', 200);
    }

    public function users()
    {
        return view('users');
    }
}
