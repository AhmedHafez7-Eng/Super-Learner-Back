<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class postResource extends JsonResource
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
            'title'=>$this->title,    
            'body'=>$this->body,      
            'instructor_id'=>$this->instructor_id,//InstructorOfPost->fname,
            'course_id'=>$this->course_id,//CourseOfPost['title'],
        ];
    }
}
