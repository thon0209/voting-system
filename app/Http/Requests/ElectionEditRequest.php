<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElectionEditRequest extends FormRequest
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
            'election_title' => 'required||max:50|unique:election,election_title,'.$this->id ,
            'start' => 'required',
            'end' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'election_title.required' => 'An election is required.',
            'election_title.max'  => 'Maximum of 50 characters are allowed',
            'election_title.unique'  => 'This election is already in use',
            'start.required' => 'A start date is required.',
            'end.required'  => 'An end date is required.',
        ];
    }

}
