<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
            'amountOfReservations' => 'required|integer',
            'timeslot' => 'required|integer',
            'startdate' => ['exclude_if:timeslot,60', 'required'],
            'enddate' => ['exclude_if:timeslot,60', 'required'],
        ];
    }

    public function messages()
    {
        return [
            'amountOfReservations.required' => 'Dit veld is verplicht.',
            'amountOfReservations.integer' => 'Dit veld moet een getal zijn.',
            'timeslot.required' => 'Dit veld is verplicht.',
            'timeslot.integer' => 'Dit veld moet een getal zijn.',
            'startdate.required' => 'Dit veld is verplicht.',
            'enddate.required' => 'Dit veld is verplicht',
        ];
    }
}
