<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailTrap;
use App\Mail\enroll;

use App\Models\User;
use App\Models\Course;
use App\Models\StudentCourse;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            //$img = $student->profile_pic;
            //$url = asset('userImg/' . $img);
            //$student->profile_pic = $url;
        }
        return response()->json([
            'students' => $students,
        ]); // in json format
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = User::find($id);

        if (is_null($student)) {
            return response()->json(
                ['message' => 'No Student Found With This ID To Show'],
                404
            );
        }
        //$img = $student->profile_pic;
        //$url = asset('userImg/' . $img);
        //$student->profile_pic = $url;

        return response()->json($student, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $student = User::find($id);
    //     return response()->json($student);
    // }
    public function update(Request $request, $id)
    {
        $student = User::find($id);

        if (is_null($student)) {
            return response()->json(
                ['message' => 'No Student Found With This ID To Update'],
                404
            );
        }

        //======= Handling Inputs Errors
        $rules = [
            'fname' => 'string|min:2|max:70',
            'lname' => 'string|min:2|max:70',
            'email' => 'string|email|max:255',
            'password' => 'string|min:8',
            'phone' => 'numeric|digits:11',
            'address' => 'string|max:255',
            'profile_pic' => 'mimes:jpg,png,jpeg',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $student->update($request->all());

            //$img = $student->profile_pic;
            //$url = asset('userImg/' . $img);
            //$student->profile_pic = $url;
            return response()->json($student, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            //======= Handling Duplicate Entry Error
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return response()->json(['message' => 'Duplicate Entry'], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = User::find($id);
        if (is_null($student)) {
            return response()->json(
                ['message' => 'No Student Found With This ID To Delete'],
                404
            );
        }
        $student->delete();
        return response()->json(null, 204);
    }

    public function coursestu($id)
    {
        $student = StudentCourse::with('StudentInstance')
            ->where('student_id', $id)
            ->first();
        $studentcourse = StudentCourse::with('CourseInstance')
            ->where('student_id', $id)
            ->get();
        if ($student && $studentcourse) {
            return response()->json($studentcourse, 200);
        }
        return response()->json('error not found', 404);
    }
    ////////////////////////////////////////////////////////////////////
    public function ifenroll(Request $request)
    {
        $user = User::find($request['user_id']);
        if ($user->role == 'instructor') {
            return response()->json('please, sign in as student');
        } else {
            foreach ($user->studcourse as $course) {
                if ($course->course_id == $request['course_id']) {
                    return response(1);
                }
            }
        }
        return response(0);
    }
    ///////////////////////////////////////////
    public function enrolle(Request $request)
    {
        $student = User::find($request['student_id']);

        $studentHasCourses = User::find($request['student_id'])->studcourse;
        foreach ($studentHasCourses as $check) {
            if ($check->course_id == $request['course_id']) {
                return response()->json(
                    'already enrolled in this course, check your courses'
                );
            }
        }
        $course = Course::find($request['course_id']);
        $stu_course = StudentCourse::create([
            'student_id' => $request['student_id'],
            'course_id' => $request['course_id'],
        ]);

        return response()->json(
            'you have enrolled in ' .
                $course->title .
                ' course, check your courses'
        );
        Mail::to($student->email)->send(new enroll());
    }
    public function delete($id)
    {
        $stu = User::find($id);
        $hisname = $stu->fname;
        $hascourse = StudentCourse::where('student_id', $stu->id)->get();
        if ($hascourse->isEmpty()) {
            $stu->delete();
            return response()->json($hisname . ' Has Been Deleted');
        } else {
            return response()->json(
                'Sorry, This Student can not be deleted for now because he is enrolling in courses!'
            );
        }
    }
    // public function unrolled($id){
    //     $stu=User::find($id);
    //     $hisname=$stu->fname;
    //     $hascourse=StudentCourse::where('student_id',$stu->id)->get();
    //     if($hascourse->isEmpty())
    //     {$stu->delete();
    //     return  response()->json($hisname .' has deleted');
    //   }
    //     else{ $hascourse->delete();
    //         return  response()->json($hisname .' has unsubscribe ' );
    //     }

    //   }
}
