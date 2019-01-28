<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartyListRequest extends FormRequest
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
            'party_name' => 'required|unique:partylist,party_name|max:50'
        ];
    }

    public function messages()
    {
        return [
            'party_name.required' => 'A party list is required.',
            'party_name.unique'  => 'This party list is already in use',
            'party_name.max'  => 'Maximum of 50 characters are allowed',
        ];
    }

}
