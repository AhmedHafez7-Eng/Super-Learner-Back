<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourseTest extends Model
{
    use HasFactory;

    public function StudentInstance()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    public function CourseInstance()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function TestInstance()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }
}