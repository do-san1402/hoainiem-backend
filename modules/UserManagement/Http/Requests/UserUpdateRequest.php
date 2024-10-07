<?php

namespace Modules\UserManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{

    public function rules()
    {
        return [
           'full_name' => 'required',
           'contact_no' => 'required',
        ];
    }


    public function authorize()
    {
        return true;
    }
}
