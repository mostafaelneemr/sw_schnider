<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class WarehouseFormRequest extends FormRequest
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
            'company_id'=> 'required',
            'name'=> 'required',
            'city'=> 'required',
            'address'=> 'required',
            'latitude'=> 'required',
            'longitude'=> 'required',
            'land_coordinates'=> 'nullable',
            'license_number'=> 'required',
            'license_issue_date'=> 'required',
            'license_expiry_date'=> 'required',
            'phone'=> 'required',
            'manager_mobile'=> 'nullable',
            'email'=> 'nullable',
            'land_area_in_square_meter'=> 'nullable',





        ];


    }


}
