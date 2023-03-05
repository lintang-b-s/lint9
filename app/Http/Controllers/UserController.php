<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public static $model = User::class;
    public function __construct()
    {
        $this->middleware('api')
            ->only(['create', 'store', 'edit', 'update', 'destroy', 'viewAny', 'view']);

        $this->middleware('auth')
            ->only(['addRole']);
    }

    public function store (StoreUserRequest $request) {
        $data = $request->all();

        $data['primary_role'] = 2;
        $user = User::create($data);

        $user->role()->attach(2);


        return response()->json(['message' => 'success']);
    }
    
    public function addRole(Request $request,User $user) {

        $this->authorize('users.addRole');

        $data = $request->all();
         if ($data['role_id'] == 1) {
            return response()->json(['message' => 'this action not allowed']);
         }
         
        $data['primary_role'] =  2;
        $user->role()->attach($data['role_id']);

        return response()->json(['message' => 'success']);
    }   
}
