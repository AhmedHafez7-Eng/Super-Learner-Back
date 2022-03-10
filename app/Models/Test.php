<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Test extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function CourseOfTest()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    // public function detailsOfTest()
    // {
    //     return $this->hasMany(TestDetails::class, 'test_id', 'id');
    // }
}