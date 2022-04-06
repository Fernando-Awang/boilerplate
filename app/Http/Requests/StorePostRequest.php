<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        // validator::
        return [
            'post_category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
    public function messages()
    {
        return [
            // rule => [id, atribute-untuk-menampilakan-error , TEXT-ERROR]
            'post_category_id.required' => ['post_category_id', 'form-control is-invalid', 'pilih kategori'],
            'title.required' => ['title', 'form-control is-invalid', 'masukan judul'],
            'content.required' => ['content', 'form-control is-invalid', 'masukan content'],
            'thumbnail.image' => ['thumbnail', 'form-control is-invalid', 'format gambar berupa jpeg,png,jpg'],
            'thumbnail.required' => ['thumbnail', 'form-control is-invalid', 'masukan thumbnail'],
        ];
    }
}
