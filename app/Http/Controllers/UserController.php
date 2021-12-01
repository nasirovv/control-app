<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users', compact('users'));
    }

    public function create()
    {
        //
    }

    public function store(UserRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        $user = User::query()->create([
            'name' => $request->get('name'),
            'uniqueId' => $request->get('uniqueId')
        ]);
        if ($request->hasFile('image')){
            try{
                $imageName = time().$request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images', $imageName);
                $user['image'] = $imageName;
            }catch (\Exception $e){
                Log::error($e);
                DB::rollBack();
            }
            $user->save();
        }
        DB::commit();
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
