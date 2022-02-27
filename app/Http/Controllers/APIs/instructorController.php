<?php

namespace App\Http\Controllers\APIs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;

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
    if($request->hasfile('profile_pic')){
    //    $file=$request->file('profile_pic');
       
    //     $newName = time() . '.' . $file->getClientoriginalExtension();
    //     $file->move('instructorImg', $newName);
       return response('kjj');
      
      }
       $user = User::create([
        'fname' => $validatedData['fname'],
        'lname' => $validatedData['lname'],
             'email' => $validatedData['email'],
             'b_date'=>$request->b_date,
             'phone'=>$request->phone,
             'address'=>$request->address,
             'role'=>$request->role,
             'password' => Hash::make($validatedData['password']),
            // 'profile_pic'=>$newName,
 ]);
 
 $token = $user->createToken('auth_token')->plainTextToken;

 return response()->json([
               'access_token' => $token,
                    'token_type' => 'Bearer',
 ]);
    
         
    
  
    }
    public function saveimg(Request $request,$id){
        $instructor= User::find($id);
        $image = $request->profile_pic;
        $imageName = time() . '.' . $image->getClientoriginalExtension();
        $request->profile_pic->move('instructorImg', $imageName);
       $instructor->profile_pic=$imageName;
       $instructor->save();
        return response()->json( 'saved changes');
       
    }
    public function getone($id){
        $instructor = User::findOrFail($id);
        
return response()->json($instructor);
    }
    public function getimageof($id){
        $instructor=User::find($id);
        
        $images=$instructor->profile_pic;
        $url=asset('instructorImg/'.$images);
       return response()->json($url);
    }
    public function delete( $id)
{
    
    $instructor = User::findOrFail($id);
    $course= $instructor->courseofinstructor;
   $link='instructorImg/'.$instructor->profile_pic;
   

     if(File::exists($link))
        File::delete($link);
        $course[0]->delete();
        return response()->json($course[0]);
       // $instructors = Category::all();
    
   
}
public function saveimgcourse(Request $request,$id){
    $instructor= User::find($id);
    
    $image = $request->course_img;
    $imageName = time() . '.' . $image->getClientoriginalExtension();
    $request->course_img->move('courseImg', $imageName);
  $course= $instructor->courseofinstructor;
 $course[0]->course_img=$imageName;
   $course[0]->save();
    return response()->json( 'saved changes');
   
}

}
