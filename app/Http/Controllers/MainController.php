<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function index(Request $request)
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
        return response()->json('Successfully added', 201);
    }
}
