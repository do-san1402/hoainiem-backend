<?php

namespace Modules\UserManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordSettingRequest extends FormRequest
{

    public function rules()
    {
        return [
           'salt' => 'required',
           'min_length' => 'required',
           'max_lifetime' => 'required',
           'password_complexcity' => 'required',
           'password_history' => 'required',
           'lock_out_duration' => 'required',
           'session_idle_logout_time' => 'required'
        ];
    }


    public function authorize()
    {
        return true;
    }
}
