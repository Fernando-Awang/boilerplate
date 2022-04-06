<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        // validator::
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required',
        ];
    }
    public function messages()
    {
        return [
            // rule => [id, atribute-untuk-menampilakan-error , TEXT-ERROR]
            'email.required' => ['email', 'form-control is-invalid', 'masukan email'],
            'email.email' => ['email', 'form-control is-invalid', 'masukan email dengan benar'],
            'email.unique' => ['email', 'form-control is-invalid', 'email sudah terdaftar'],
            'password.required' => ['password', 'form-control is-invalid', 'masukan pasword'],
            'name.required' => ['name', 'form-control is-invalid', 'masukan nama'],
        ];
    }
}
