<?php

namespace App\Http\Controllers\APIs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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
            $ss->profile_pic=$url;
            $ss->courseofinstructor;
        }
            
            return response()->json(
              ['instructors'=>  $instructor,
              ] 
            );  // in json format
        
   // }
        

    }
    /////////////////////////////////////////////
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
                       'b_date'=>$request->b_date,
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
    ////////////////////////////////////////////////
    public function login(Request $request)
{
if (!Auth::attempt($request->only('email', 'password'))) {
return response()->json([
'message' => 'Invalid login details'
           ], 401);
       }

$user = User::where('email', $request['email'])->firstOrFail();

$token = $user->createToken('auth_token',['all:list'])->plainTextToken;

return response()->json([
           'access_token' => $token,
           'token_type' => 'Bearer',
]);
}
////////////////////////////////////////////////////////
    public function saveimg(Request $request,$id){
        $instructor= User::find($id);
        $image = $request->profile_pic;
        $imageName = time() . '.' . $image->getClientoriginalExtension();
        $request->profile_pic->move('instructorImg', $imageName);
       $instructor->profile_pic=$imageName;
       $instructor->save();
        return response()->json( 'saved changes');
       
    }
   public function  getone($id){
        $instructor=User::find($id);
        $courses=$instructor->courseofinstructor;
        return response($courses);
    }

}
