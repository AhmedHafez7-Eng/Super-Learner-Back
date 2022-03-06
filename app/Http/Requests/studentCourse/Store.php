<?php

namespace App\Http\Requests\studentCourse;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
                'feedback' => 'required|max:70',
                'score' => 'required|numeric',
                'student_id' => 'required|not_in:-1',
                'course_id' => 'required|numeric',
            
        ];
    }
}
