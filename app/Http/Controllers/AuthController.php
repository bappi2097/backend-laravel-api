<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): Response
    {
        $fields = $request->all();

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong credentials!',
                'type' => 'error'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Successfully Logged In!',
            'type' => 'success'
        ];

        return response($response, 201);
    }

    /**
     * @param
     */
    public function register(RegisterRequest $request): Response
    {
        $fields = $request->all();

        $user = User::create([
            'firstName' => $fields['firstName'],
            'lastName' => $fields['lastName'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => 'Successfully Registered!'
        ];

        return response($response, 201);
    }


    public function logout() {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out!'
        ];
    }
}
