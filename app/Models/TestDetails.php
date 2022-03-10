<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;

class TestDetails extends Model
{
    use HasFactory;
   // protected $primaryKey = 'test_id';
   // protected $guarded = [];
   protected $fillable = ['test_id',
                           'question',
                           'answer1',
                           'answer2',
                           'answer3',
                           'answer4',
                           'correct_answer',


];
    public function TestOfDetails()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }
}