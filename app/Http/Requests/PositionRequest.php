<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
            'position' => 'required|unique:positions,position|max:20'
        ];
    }

    public function messages()
    {
        return [
            'position.required' => 'A position is required.',
            'position.unique'  => 'This position is already in use',
            'position.max'  => 'Maximum of 20 characters are allowed',
        ];
    }


    
}
