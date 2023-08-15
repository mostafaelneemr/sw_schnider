<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StaffFormRequest extends FormRequest
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
        if($this->segment(3) == 'change-password'){
            return [
                'password'      =>  'required|string|min:6|confirmed'
            ];
        }

        $id = $this->segment(3);
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST': {
                return [
                    'name'             => 'required|string',
                    'email'                 => 'required|string|email|unique:staff,email',
//                    'mobile'                => 'required|string|unique:staff,mobile',
                    'password'              => 'required|string|min:6|confirmed',
//                    'status'                => 'required|string|in:active,in-active',
//                    'permission_group_id'   => 'required|int|exists:permission_groups,id',
//                    'avatar'                => 'nullable|image'
                ];

            }
            case 'PUT':
            case 'PATCH':
            {

                return [
                    'name'             => 'required|string',
                    'email'                 => 'required|string|email|unique:staff,email,'.$id,
//                    'mobile'                => 'required|string|unique:staff,mobile,'.$id,
                    'password'              => 'nullable|string|min:6|confirmed',
//                    'status'                => 'required|string|in:active,in-active',
//                    'permission_group_id'   => 'required|int|exists:permission_groups,id',
//                    'avatar'                => 'nullable|image'
                ];
            }
            default:break;
        }

    }
}
