<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('id', auth()->user()->id)->first();
            $success['token'] = $user->createToken('TokenName')->plainTextToken;
            $success['data'] = $user;
//            return $success;
//            $success['user'] = $user;
            $response = [
                'success' => "true",
//                'status' => $this->successStatus,
                'data' => $success
            ];
            return response()->json($response, 200);
        } else {
//            return "Failed";
//            $response = [
//                'success' => "false",
//                'status' => $this->errorStatus
//            ];
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }


    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }
        // Check if validation pass then create user and auth token. Return the auth token
        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'group_code' => $request->password,
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => "user Created",
                'data' => $user,
                'token' => $token

            ]);
        }
    }
}
