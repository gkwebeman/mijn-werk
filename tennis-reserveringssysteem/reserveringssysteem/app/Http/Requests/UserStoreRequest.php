<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            //
            'picture' => 'mimes:jpg,jpeg,png|max:2000'
        ];
    }

    public function messages()
    {
        return [
            'picture.mimes' => 'Bestand moet een JPG, JPEG of PNG zijn.',
            'picture.max' => 'Bestand is te groot om op te slaan.',
        ];
    }
}
