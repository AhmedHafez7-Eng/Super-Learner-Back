<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Test;
class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'max_score',
        'desc',
        
    ];

    public function InstructorOfCourse()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }
    public function TestOfCourse()
    {
        return $this->hasMany(Test::class, 'course_id', 'id');
    }
}
