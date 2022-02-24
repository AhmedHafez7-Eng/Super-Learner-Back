<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;

class TestDetails extends Model
{
    use HasFactory;

    public function TestOfDetails()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }
}