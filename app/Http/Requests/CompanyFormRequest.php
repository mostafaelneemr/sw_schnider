<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CompanyFormRequest extends FormRequest
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
            'name'=> 'required',
            'sfda'=> 'required',
            'commercial_record_number'=> 'required',
            'commercial_record_is_sue_date_hijri'=> 'required|date',
            'date_of_birth_hijri'=> 'nullable|date',
            'date_of_birth_gregorian'=> 'nullable|date',
            'phone'=> 'required',
            'extension_number'=> 'nullable',
            'email'=> 'required|email',
            'manager_name'=> 'required',
            'manager_phone'=> 'required',
            'manager_mobile'=> 'required',



        ];


    }


}
