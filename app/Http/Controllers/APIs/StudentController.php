<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
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
            $img = $student->profile_pic;
            $url = asset('userImg/' . $img);
            $student->profile_pic = $url;
        }

        return response()->json($students, 200);
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
            return response()->json(['message' => 'No Student Found With This ID To Show'], 404);
        }
        $img = $student->profile_pic;
        $url = asset('userImg/' . $img);
        $student->profile_pic = $url;

        return response()->json($student, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $student = User::find($id);

        if (is_null($student)) {
            return response()->json(['message' => 'No Student Found With This ID To Update'], 404);
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

            $img = $student->profile_pic;
            $url = asset('userImg/' . $img);
            $student->profile_pic = $url;
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
            return response()->json(['message' => 'No Student Found With This ID To Delete'], 404);
        }
        $student->delete();
        return response()->json(null, 204);
    }
    public function courses_stu($id){
        $student=User::find($id)->StudentInstance;
        return response($student);

    }
}