<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestDetails;
use Illuminate\Support\Facades\Validator;

class TestDetailsController extends Controller
{
    public function index()
    {
        $test = TestDetails::all();
        return response()->json($test->load('TestOfDetails'), 200);
    }
    public function show($id)
    {
        $test = TestDetails::find($id);
        if (is_null($test)) {
            return response()->json(["message" => "test not found"], 404);
        }
        return response()->json($test->load('TestOfDetails'), 200);
    }
    public function store(Request $request)
    {
        $rules = [
            'test_id' => 'required|exists:tests,id|integer',
            'question' => 'required|string|min:1',
            'answer1' => 'required|string|min:1',
            'answer2' => 'required|string|min:1',
            'answer3' => 'required|string|min:1',
            'answer4' => 'required|string|min:1',
            'correct_answer' => 'required|string|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $test = TestDetails::create($request->all());
        return response()->json($test, 201);
    }
    public function update(Request $request, $id)
    {
        $test = TestDetails::find($id);
        if (is_null($test)) {
            return response()->json(["message" => "test not found"], 404);
        }
        $test->update($request->all());
        return response()->json($test->load('TestOfDetails'), 200);
    }
    public function delete(Request $request, $id)
    {
        $test = TestDetails::find($id);
        if (is_null($test)) {
            return response()->json(["message" => "test not found"], 404);
        }
        $test->delete();
        return response()->json(null, 204);
    }
    public function addquiz(Request $request)
    {
        $user = TestDetails::create([
            'test_id' => $request['test_id'],
            'question' => $request['question'],
            'answer1' => $request['answer1'],
            'answer2' => $request['answer2'],
            'answer3' => $request['answer3'],
            'answer4' => $request['answer4'],
            'correct_answer' => $request['correct_answer']
        ]);

        return response()->json('quiz has been added');
    }
}