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
        $instructor = User::all()->where('role', 'instructor');
        foreach ($instructor as $ss) {
            $img = $ss->profile_pic;
            $url = asset('userImg/' . $img);
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
   //////////////////
   ////////////////////////////////////////////////
        public function saveimg(Request $request, $id)
    {
        $instructor = User::find($id);
        $image = $request->profile_pic;
        $imageName = time() . '.' . $image->getClientoriginalExtension();
        $request->profile_pic->move('instructorImg', $imageName);
        $instructor->profile_pic = $imageName;
        $instructor->save();
        return response()->json('saved changes');
    }
    ///////////////////////////////////////////////////
   public function  getone($id){
        $instructor=User::find($id);
        $courses=$instructor->courseofinstructor;
        return response($courses);
    }
  

}
