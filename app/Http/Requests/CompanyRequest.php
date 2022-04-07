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
        // 'vision' => 'required',
        // 'mision' => 'required',
        ];
    }
    public function messages()
    {
        return [
            // rule => [id, atribute-untuk-menampilakan-error , TEXT-ERROR]
            'name.required' => ['name', 'form-control is-invalid', 'masukan nama'],
            'office_address.required' => ['office_address', 'form-control is-invalid', 'masukan alamat'],
            'phone.required' => ['phone', 'form-control is-invalid', 'masukan telepon'],
            'email.required' => ['email', 'form-control is-invalid', 'masukan email'],
            'about.required' => ['about', 'form-control is-invalid', 'masukan about'],
            // 'vision.required' => ['vision', 'form-control is-invalid', 'masukan visi'],
            // 'mision.required' => ['mision', 'form-control is-invalid', 'masukan misi'],
        ];
    }
}
