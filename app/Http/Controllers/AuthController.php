<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // if (isset($credentials['username'])) {
        //     $credentials['username'] = strtolower($credentials['username']);

        //     if (!Auth::attempt($credentials)) {
        //         return response([
        //             'message' => 'Provided credentials are incorrect'
        //         ], 422);
        //     }
        // }
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided credentials are incorrect'
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();
        $userRole = Role::find($user['role_id']);
        $role = $userRole->name;
        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'role', 'token'));
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }
}
