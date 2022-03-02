<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class coursesController extends Controller
{
    //
    public function listCourse(){
        $courses=Course::all();
        foreach( $courses as $ss){
            $img=$ss->course_img;
            $url=asset('courseImg/'.$img);
            //array_push($urls,$url);
            $ss->course_img=$url;
       }
        return response()->json($courses);
    }
    /////////////////////////////////////////////////
    public function saveimgcourse(Request $request,$id){
        $course= Course::find($id);
        $image = $request->course_img;
        $imageName = time() . '.' . $image->getClientoriginalExtension();
        $request->course_img->move('courseImg', $imageName);
       $course->course_img=$imageName;
       $course->save();
        return response()->json( 'saved changes');
       
    }
    ////////////////////////////////////////////////////////
    public function update(Request $request,$id){
        $course = Course::findOrFail($id);
        if($course)
            {
                
                $course-> title=  $request->title;
                $course->save(); 
                return response()->json( 'your item has updated');
    
            }}
            /////////////////////////////////////////////////
            public function getCourse($id){
                $course=Course::find($id);
               
                return response($course);
            }
}
