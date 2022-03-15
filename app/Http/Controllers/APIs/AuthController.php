<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailTrap;

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
            'phone' => 'required|numeric|digits:11',
            'address' => 'required|string|max:255',
            'b_date' => 'required| date',
            'role' => 'required',
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
            //  'profile_pic' => $imageName,
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        Mail::to($validatedData['email'])->send(new mailTrap());
        $inst = User::all()->last();
        $id = $inst->id;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'id' => $id,
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

    // public function findUserData($id)
    // {
    //     $user = User::find($id);
    //     return response()->json($user);
    // }

    //=========== Update User Data
    public function edit_profile(Request $request, $id)
    {
        $user = User::find($id);

        $validatedData = $request->validate([
            'fname' => 'string|min:2|max:70',
            'lname' => 'string|min:2|max:70',
            'email' => 'string|email|max:255',
            'password' => 'string|min:8',
            'phone' => 'numeric|digits:11',
            'address' => 'string|max:255',
            // 'b_date' => ' date',
            // 'profile_pic' => 'required|mimes:jpeg,png,jpg',
        ]);


        if ($validatedData) {

            // $image = $request->usrImg;
            // if ($image) {
            //     $imageName = time() . '.' . $image->getClientoriginalExtension();
            //     $request->usrImg->move('usersImages', $imageName);
            //     $user->avatar_Img = $imageName;
            // }
            if ($request->fname) {
                $user->fname = $request->fname;
            }
            if ($request->lname) {
                $user->lname = $request->lname;
            }
            if ($request->email && $request->email !== $user->email) {
                $user->email = $request->email;
            }
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            if ($request->phone) {
                $user->phone = $request->phone;
            }
            if ($request->address) {
                $user->address = $request->address;
            }
            // if ($request->b_date) {
            //     $user->b_date = $request->b_date;
            // }

            $user->save();
            return response()->json("Profile Info has been Updated Successfully!", 201);
        }
    }
}