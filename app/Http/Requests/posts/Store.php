<?php

namespace App\Http\Requests\posts;

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
            'title' => 'required|max:70',
            'body' => 'required',
            'instructor_id' => 'required|numeric',
            'course_id' => 'required|numeric',
        ];
    }
}
