<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentCourse;
use Auth;

class instructorController extends Controller
{
    //
    public function list()

    {
        //$user=auth()->user();
        //if ($user->tokenCan('all:list')) {
        $instructor = User::where('role', 'instructor')->get();
        // foreach ($instructor as $ss) {
        //     $img = $ss->profile_pic;
        //     $url = asset('userImg/' . $img);
        //     //array_push($urls,$url);
        //     $ss->profile_pic = $url;
        //     $ss->courseofinstructor;
        // }

        return response()->json(
            [
                'instructors' =>  $instructor,
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
        // $image = $request->profile_pic;
        // $imageName = time() . '.' . $image->getClientoriginalExtension();
        // $request->profile_pic->move('instructorImg', $imageName);
        $image = $request->file('course_img')->storeOnCloudinary()->getSecurePath();

        $instructor->profile_pic = $image;
        $instructor->save();
        return response()->json('saved changes');
    }
   
    ///////////////////////////////////////////////////
    public function  getone($id)
    {
        $instructor = User::find($id);
        // $img = $instructor->profile_pic;
        // $url = asset('userImg/' . $img);
        // $instructor->profile_pic = $url;

        $courses = $instructor->courseofinstructor;
        return response($courses);
    }
    public function destroy($id)
    {
        $instructor = User::find($id);
        $hiscourses = $instructor->courseofinstructor;
        $hisname = $instructor->fname;
        foreach ($hiscourses as $course) {
            $hasstu = StudentCourse::where('course_id', $course->id)->get();
            if ($hasstu->isEmpty())
                $course->delete();
            else  return response()->json('Sorry, This Instructor can not be deleted for now because it has active courses!');
        }
        $instructor->delete();
        return response()->json($hisname . 'Has Been Deleted');
    }
}

// public function index()
//     {
//         $studentcourses = StudentCourse::with('StudentInstance', 'CourseInstance')->get();
//         if ($studentcourses)
//             return response()->json($studentcourses, 200);
//         // return response()->json(StudentCourseResource::collection($studentcourses), 200);
//         return response()->json('message -> error not found', 404);
//     }
//     public function show($id)
//     {
//         $student = StudentCourse::with('StudentInstance')->where('student_id', $id)->first();
//         $studentcourse = StudentCourse::with('CourseInstance')->where('student_id', $id)->get();
//         if ($student && $studentcourse)
//             // return response()->json(new StudentCourseResource($studentcourse), 200);
//             return response()->json([$student, $studentcourse], 200);
//         return response()->json('error not found', 404);
//     }
