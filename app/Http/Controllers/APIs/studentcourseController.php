<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\studentCourse\Store;
use App\Http\Resources\StudentCourseResource;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class studentcourseController extends Controller
{

    public function index()
    {
        $studentcourses = StudentCourse::with('StudentInstance', 'CourseInstance')->get();
        if ($studentcourses)
            return response()->json($studentcourses, 200);
        // return response()->json(StudentCourseResource::collection($studentcourses), 200);
        return response()->json('message -> error not found', 404);
    }
    public function show($id)
    {
        $student = StudentCourse::with('StudentInstance')->where('student_id', $id)->first();
        $studentcourse = StudentCourse::with('CourseInstance')->where('student_id', $id)->get();
        if ($student && $studentcourse)
            // return response()->json(new StudentCourseResource($studentcourse), 200);
            return response()->json([$student, $studentcourse], 200);
        return response()->json('error not found', 404);
    }
    public function update(Request $request, $id)
    {
        $studentcourse = StudentCourse::with('StudentInstance', 'CourseInstance')->where('student_id', $id)->first();
        if ($studentcourse) {
            if (isset($request->feedback))
                $studentcourse->feedback = $request->feedback;
            if (isset($request->student_id))
                $studentcourse->student_id = $request->student_id;
            if (isset($request->score))
                $studentcourse->score = $request->score;
            if (isset($request->course_id))
                $studentcourse->course_id = $request->course_id;
            $studentcourse->save();
            return response()->json('Record Updated', 200);
        }
        return response()->json('Error Record Not Found', 404);
    }
    public function store(Request $request)
    {
        $studentcourse = new StudentCourse();
        $studentcourse->feedback = $request->feedback;
        $studentcourse->student_id = $request->student_id;
        $studentcourse->score = $request->score;
        $studentcourse->course_id = $request->course_id;
        $studentcourse->save();
        return response()->json(['Record Created Successfully', 200]);
    }
    public function delete($id)
    {
        $studentcourse = StudentCourse::with('StudentInstance', 'CourseInstance')->where('student_id', $id)->first();
        if ($studentcourse)
            $studentcourse->delete();
        return response()->json('Error Record Not Found', 404);
    }
    public function feedback($id, Request $request)
    {
        $student = StudentCourse::where([["student_id", "=", $id], ["course_id", "=", $request->course_id]])->first();

        if ($student) {
            $rules = [
                'feedback' => 'string|min:3|max:150',

            ];
            $validator = Validator::make($request->all(), $rules);
            $student->feedback = $request->feedback;
            $student->save();
            return response()->json("Your Feedback Sent Successfully!", 201);
        } else {
            return response()->json("you are not enrolled in this course");
        }
    }
}