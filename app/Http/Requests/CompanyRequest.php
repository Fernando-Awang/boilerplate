<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        // validator::
        return [
        'name' => 'required',
        'office_address' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'about' => 'required',
        'vision' => 'required',
        'mision' => 'required',
        ];
    }
    public function messages()
    {
        return [
            // rule => [id, atribute-untuk-menampilakan-error , TEXT-ERROR]
            'name.required' => ['name', 'form-control is-invalid', 'masukan nama'],
            'office_address.required' => ['office_address', 'form-control is-invalid', 'masukan nama'],
            'phone.required' => ['phone', 'form-control is-invalid', 'masukan nama'],
            'email.required' => ['email', 'form-control is-invalid', 'masukan nama'],
            'about.required' => ['name', 'form-control is-invalid', 'masukan nama'],
            'vision.required' => ['name', 'form-control is-invalid', 'masukan nama'],
            'mision.required' => ['name', 'form-control is-invalid', 'masukan nama'],
        ];
    }
}
