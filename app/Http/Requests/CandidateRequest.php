<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|max:50|unique:candidates,full_name' ,
            'course' => 'required|max:15',
            'position_id' => 'required',
            'party_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'A candidate name is required.',
            'full_name.max'  => 'Maximum of 50 characters are allowed',
            'full_name.unique' => 'A candidate name is already in use.',
            'course.required' => 'A course is required.',
            'course.max' => 'Maximum of 15 characters are allowed',
            'position_id.required'  => 'A position is required.',
            'party_id.required'  => 'A party list is required.',
        ];
    }
}
