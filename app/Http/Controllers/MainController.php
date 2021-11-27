<?php

namespace App\Http\Controllers;

use App\Events\ControlEvent;
use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $user = User::query()
            ->where('uniqueId', $request->get('uniqueId'))
            ->select('id')
            ->firstOrFail();
        DB::beginTransaction();
        $history  = History::query()->updateOrCreate([
           'user_id' => $user->id,
            'day' => Carbon::now()->format('Y-m-d'),
        ]);
        if($request->get('status') && !$history['arrival_time']){
            $history['arrival_time'] = Carbon::now('Asia/Tashkent')->format('H:i:s');
        }else if(!$request->get('status') && $history['arrival_time'] && !$history['departure_time']){
            $history['departure_time'] = Carbon::now('Asia/Tashkent')->format('H:i:s');
        }else{
            DB::rollBack();
            return response()->json('Something went wrong', 400);
        }
        $history->save();
        DB::commit();
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
        return response()->json('Successfully added', 201);
    }

    public function getHistories(){
        $histories = History::with('user')->get();
        return view('welcome', compact('histories'));
    }
}
