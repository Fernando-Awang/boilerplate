<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        // validator::
        return [
            'product_category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
    public function messages()
    {
        return [
            // rule => [id, atribute-untuk-menampilakan-error , TEXT-ERROR]
            'product_category_id.required' => ['product_category_id', 'form-control is-invalid', 'pilih kategori'],
            'name.required' => ['name', 'form-control is-invalid', 'masukan nama'],
            'description.required' => ['description', 'form-control is-invalid', 'masukan deskripsi'],
            'thumbnail.image' => ['thumbnail', 'form-control is-invalid', 'format gambar berupa jpeg,png,jpg'],
            'thumbnail.required' => ['thumbnail', 'form-control is-invalid', 'masukan thumbnail'],
        ];
    }
}
