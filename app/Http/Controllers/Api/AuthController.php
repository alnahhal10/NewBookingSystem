<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Validator;
class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        // Validate the request data

        $validator = Validator::make($request->all(), [
            'name'         => 'sometimes|required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        // // Create a new user
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()],
                 422
                 );
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'client'
        ]);
        
        $response = [];
        $response['token'] = $user->createToken('auth_token')->plainTextToken;
        $response['name'] = $user->name;
        $response['email'] = $user->email;

        
        // Return the user and token in the response
        return response()->json([
            'status' => 1,
            'message' => 'User registered successfully',
            'data' => $response,
            // 'status' => 1,
        ]);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()],
                 422
                 );
        }

        // Attempt to authenticate the user
        if (!Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        
        $response = [];
        $response['token'] = $user->createToken('auth_token')->plainTextToken;
        $response['name'] = $user->name;
        $response['email'] = $user->email;

        // Return the user and token in the response
        return response()->json([
            'status' => 1,
            'message' => 'User logged in successfully',
            'data' => $response,
            // 'status' => 1,
        ]);
    }
}
