<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class urequest extends FormRequest
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

            'uname'     =>  'User Name should only contain Chars',

            'pwd'       =>  'required',

            'pno'       =>  'required|/^[0-9]{10}$/',

//            'con_pwd'   =>  'required|min:6',

            'email'     =>  'required|email'
        ];
    }
}
