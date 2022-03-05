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
            'studentDetails' => [
                'student_id' => $this->student_id
            ],      //StudentInstance->fname,
            'courseDetails' => $this->course_id, //CourseInstance['title'],
            'score' => $this->score,
        ];
    }
}