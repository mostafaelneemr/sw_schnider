<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AdvfFormRequest extends FormRequest
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
            'avatar'=> 'required'
        ];
    }
    public function messages()
    {
        return [
            'avatar.required'=>'اختر الصوره من فضلك',
        ];
    }

}
