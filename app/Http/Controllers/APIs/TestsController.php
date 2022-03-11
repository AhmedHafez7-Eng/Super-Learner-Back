<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;

use App\Models\Course;

class TestsController extends Controller
{

    public function index()
    {
        $test = Test::all();
        return response()->json($test->load('CourseOfTest'), 200);
    }
    public function show($id)
    {
        $test = Test::find($id);
        if (is_null($test)) {
            return response()->json(["message" => "test not found"], 404);
        }
        return response()->json($test, 200);
        // return response()->json($test->load('CourseOfTest'), 200);
    }
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3|max:10',
            'max_score' => 'required|numeric',
            'course_id' => 'required|exists:courses,id',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $test = Test::create($request->all());
        return response()->json($test, 201);
    }
    public function update(Request $request, $id)
    {
        $test = Test::find($id);
        if (is_null($test)) {
            return response()->json(["message" => "test not found"], 404);
        }
        $test->update($request->all());
        return response()->json($test->load('CourseOfTest'), 200);
    }
    public function delete(Request $request, $id)
    {
        $test = Test::find($id);
        if (is_null($test)) {
            return response()->json(["message" => "test not found"], 404);
        }
        $test->delete();
        return response()->json(null, 204);
    }

    public function gettest($course_id)
    {
        $test = Course::find($course_id)->TestOfCourse;
        return response($test);
    }
    public function getdetails($test_id)
    {
        $testdetails = Test::find($test_id)->detailsOfTest;
        return response($testdetails);
    }
}