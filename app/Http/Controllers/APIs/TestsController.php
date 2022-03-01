<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;
use Validator;
class TestsController extends Controller
{
    
    public function index(){
        $test = Test::all();
        return response()->json($test ->load('CourseOfTest'),200);
    }
    public function show($id){
        $test=Test::find($id);
        if(is_null($test)){
            return response()->json(["message"=>"test not found"],404);
        }
        return response()->json ($test ->load('CourseOfTest'),200);
    }
    public function create(Request $request){
        $rules=[
            'id'=>'required',
            'title'=>'required|min:3|max:10',
            'max_score'=>'required',
            'course_id'=>'required|exists:Course',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $test=Test::create($request->all());
        return response()->json($test,201);
    }
    public function update(Request $request, $id){
        $test=Test::find($id);
        if(is_null($test)){
            return response()->json(["message"=>"test not found"],404);
        }
        $test->update($request->all());
        return response()->json($test ->load('CourseOfTest'),200);
    }
    public function delete(Request $request, $id){
        $test=Test::find($id);
        if(is_null($test)){
            return response()->json(["message"=>"test not found"],404);
        }
        $test->delete();
        return response()->json(null,204);
    } 
}
