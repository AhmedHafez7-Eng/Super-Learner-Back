<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class coursesController extends Controller
{
    //
    public function listCourse(){
        $courses=Course::all();
        //$instructors=$courses[0]->InstructorOfCourse;
        return response()->json($courses);
    }
}
