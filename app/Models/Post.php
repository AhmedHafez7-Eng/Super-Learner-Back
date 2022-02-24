<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class Post extends Model
{
    use HasFactory;

    public function InstructorOfPost()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }

    public function CourseOfPost()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}