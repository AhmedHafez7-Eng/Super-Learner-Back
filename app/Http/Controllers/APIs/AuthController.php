<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'fname' => 'required|string|min:2|max:70',
            'lname' => 'required|string|min:2|max:70',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // 'phone' => 'required|numeric|digits:11',
            // 'address' => 'required|string|max:255',
            // 'b_date' => 'required| date',
            // 'role' => 'required',
            // 'profile_pic' => 'required|mimes:jpeg,png,jpg',
        ]);

        // $image = $request->profile_pic;
        // $imageName = time() . '.' . $image->getClientoriginalExtension();
        // $request->profile_pic->move('userImg', $imageName);

        $user = User::create([
            'fname' => $validatedData['fname'],
            'lname' => $validatedData['lname'],
            'email' => $validatedData['email'],
            'b_date' => $request['b_date'],
            'phone' => $request['phone'],
            'address' => $request['address'],
            'password' => Hash::make($validatedData['password']),
            'role' => $request['role'],
            // 'profile_pic' => $imageName,
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check For Email

        $user = User::where('email', $fields['email'])->first();

        // Check Password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Email or Password are Invalid!'
            ], 401);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);

        // $resposne = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        // return response($resposne, 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}