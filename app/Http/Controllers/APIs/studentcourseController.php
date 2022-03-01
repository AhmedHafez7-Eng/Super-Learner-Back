<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentCourseResource;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use App\Models\User;

class studentcourseController extends Controller
{

    public function index()
    {
        $studentcourses = StudentCourse::with('StudentInstance','CourseInstance')->get();
        if ($studentcourses)
            return response()->json(StudentCourseResource::collection($studentcourses), 200);
        return response()->json('message -> error not found', 404);
    }
    public function show($id)
    {
        $studentcourse = StudentCourse::with('StudentInstance','CourseInstance')->where('student_id', $id)->first();
        if ($studentcourse)
            return response()->json(new StudentCourseResource($studentcourse), 200);
        return response()->json('error not found', 404);
    }
    public function update(Request $request,$id)
    {
        $studentcourse = StudentCourse::with('StudentInstance','CourseInstance')->find($id);
        if ($studentcourse){
            $studentcourse->feedback = $request->feedback;
            $studentcourse->save();
            return response()->json('record updated', 200);
        }
        return response()->json('error not found', 404);

    }
}
