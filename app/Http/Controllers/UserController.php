<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
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
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::query()->findOrFail($id);
        return view('users.edit', ['id' => $id, 'oldName' => $user->name, 'oldUniqueId' => $user->uniqueId, 'image' => $user->image]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        DB::beginTransaction();
        $user->update($request->all());
        if ($request->hasFile('image')){
            try{
                $file_path = storage_path().'/public/images/'.$user->image;
                if(Storage::exists($file_path)) {
                    unlink($file_path);
                }
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
        return redirect()->route('users.index');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
        return redirect()->back();
    }
}
