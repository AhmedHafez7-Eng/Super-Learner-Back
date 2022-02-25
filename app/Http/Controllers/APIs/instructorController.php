<?php

namespace App\Http\Controllers\APIs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class instructorController extends Controller
{
    //
    public function list()
    
    {  
        //$user=auth()->user();
        //if ($user->tokenCan('all:list')) {
        $instructor = User::all();
        foreach( $instructor as $ss){
            $img=$ss->profile_pic;
            $url=asset('instructorImg/'.$img);
            //array_push($urls,$url);
            $ss->img_name=$url;
        }
            
            return response()->json($instructor );  // in json format
        
   // }
        

    }
    public function register(Request $request)
    {
    $validatedData = $request->validate([
    'fname' => 'required|string|max:255',
    'lname' => 'required|string|max:255',
                       'email' => 'required|string|email|max:255|unique:users',
                       'password' => 'required|string|min:8',
    ]);
    
          $user = User::create([
                  'fname' => $validatedData['fname'],
                  'lname' => $validatedData['lname'],
                       'email' => $validatedData['email'],
                       'b_date'=>'2020-10-11',
                       'phone'=>$request->phone,
                       'address'=>$request->address,
                       'password' => Hash::make($validatedData['password']),
           ]);
    
    $token = $user->createToken('auth_token')->plainTextToken;
    
    return response()->json([
                  'access_token' => $token,
                       'token_type' => 'Bearer',
    ]);
    }

}
