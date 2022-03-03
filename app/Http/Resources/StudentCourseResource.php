<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'courseName'=>$this->course_id,//CourseInstance['title'],
            'studentName'=>$this->student_id,      //StudentInstance->fname,
            'score'=>$this->score,
        ];
    }
}
