<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Http\Resources\UserResource as UserResource;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    
    public function index()
    {
        $user = User::all();
        return UserResource::collection($user);
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->fill(Input::get());
        if($user->save()) {
            return new UserResource($user);
        }
    }

    public function import(Request $request) 
    {
        $user=Excel::import(new UsersImport(), $request->file('file'));
        return response()->json(['message' => 'File has been uploaded. Please refresh the page.']);
    }

    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->fill(Input::get());
        $user->isVoted = '0';
        $user->isAdmin = '0';
        if($user->save())
        {
            return new UserResource($user);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'Deleted']);
    }

}
