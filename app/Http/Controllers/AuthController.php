<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // ==========1===========
        // Validate incoming registration data
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // =========2===========
        // Create new user and generate API token, set expiration time to 1 hour
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->plainTextToken;

        // =========3===========
        // Return success response with user data and token
        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user,
            'token'   => $token,
            'expires_at' => Carbon::now()->addHour()->toDateTimeString()
        ], 201);
    }

    public function login(Request $request)
    {
        // =========4===========
        // Validate incoming login data
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        // =========5===========
        // Generate API token for authenticated user (expire in 1 hour)
        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->plainTextToken;

        // =========6===========
        // Return success response with user data and token
        return response()->json([
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token,
            'expires_at' => Carbon::now()->addHour()->toDateTimeString()
        ], 200);
    }

    public function logout(Request $request)
    {
        // =========7===========
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        // =========8===========
        // Return success response
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
