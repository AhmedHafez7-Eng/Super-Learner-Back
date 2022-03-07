<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Course;

class StudentCourse extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'course_id',
        
        
    ];

    public function StudentInstance()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function CourseInstance()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}