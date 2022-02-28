<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestDetails;
use Validator;
class TestDetailsController extends Controller
{
    public function index(){
        $test = TestDetails::all();
        return response()->json($test ->load('TestOfDetails'),200);
    }
    public function show($id){
        $test=TestDetails::find($id);
        if(is_null($test)){
            return response()->json(["message"=>"test not found"],404);
        }
        return response()->json ($test ->load('TestOfDetails'),200);
    }
    public function create(Request $request){
        $rules=[
            'test_id'=>'required|exists:Test|integer',
            'question'=>'required|string',
            'answer1'=>'required|string|min:0|max:50',
            'answer2'=>'required|string|min:0|max:50',
            'answer3'=>'required|string|min:0|max:50',
            'answer4'=>'required|string|min:0|max:50',
            'correct_answer'=>'required|string|min:0|max:50',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $test=TestDetails::create($request->all());
        return response()->json($test,201);
    }
    public function update(Request $request, $id){
        $test=TestDetails::find($id);
        if(is_null($test)){
            return response()->json(["message"=>"test not found"],404);
        }
        $test->update($request->all());
        return response()->json($test ->load('TestOfDetails'),200);
    }
    public function delete(Request $request, $id){
        $test=TestDetails::find($id);
        if(is_null($test)){
            return response()->json(["message"=>"test not found"],404);
        }
        $test->delete();
        return response()->json(null,204);
    } 
}
