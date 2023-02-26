<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public static $model = User::class;
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    
    public function addRole(User $user) {

        $this->authorize('users.addRole');

        $data = $request->all();
        $user->role()->attach($data['role_id']);

        return response()->json(['message' => 'success']);
    }   
}
