<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\StudentCourse;

class coursesController extends Controller
{
    //
    public function listCourse()
    {
        $courses = Course::all();
        foreach ($courses as $ss) {
            $img = $ss->course_img;
            $url = asset('courseImg/' . $img);
            //array_push($urls,$url);
            $ss->course_img = $url;
        }
        return response()->json($courses);
    }
    /////////////////////////////////////////////////
    public function saveimgcourse(Request $request, $id)
    {
        $course = Course::find($id);
        $image = $request->course_img;
        $imageName = time() . '.' . $image->getClientoriginalExtension();
        $request->course_img->move('courseImg', $imageName);
        $course->course_img = $imageName;
        $course->save();
        return response()->json('saved changes');
    }
    ////////////////////////////////////////////////////////
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if ($request['title']) {
            $course->title =  $request['title'];
        }

        if ($request['desc']) {
            $course->desc =  $request['desc'];
        }

        if ($request['max_score']) {
            $course->max_score =  $request['max_score'];
        }
        $course->save();
        return response()->json('your item has updated');
    }
    /////////////////////////////////////////////////
    public function getCourse($id)
    {
        $course = Course::find($id);

        return response($course);
    }
    public function delete($id)
    {
        $course = Course::find($id);
        $itstitle = $course->title;
        $hasstu = StudentCourse::where('course_id', $course->id)->get();

        if ($hasstu->isEmpty()) {
            $course->delete();
            return response()->json($itstitle . 'Has Been Deleted!');
        } else  return response()->json('Sorry, This Course can not be deleted for now because it has enrolling students!');
    }
    public function addcourse(Request $request)
    {
        // $image = $request['course_img'];
        // $imageName = time() . '.' . $image->getClientoriginalExtension();
        // $request['course_img']->move('courseImg', $imageName);

        $course = Course::create([
            'instructor_id' => $request['instructor_id'],
            'title' => $request['title'],
            'desc' => $request['desc'],
            'max_score' => $request['max_score'],
            //'course_img'=>  $imageName,
        ]);
        return response()->json('course has been added');
    }
}