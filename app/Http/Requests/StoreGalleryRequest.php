<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        // validator::
        return [
            'gallery_category_id' => 'required',
            'caption' => 'required',
            'source' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }
    public function messages()
    {
        return [
            // rule => [id, atribute-untuk-menampilakan-error , TEXT-ERROR]
            'gallery_category_id.required' => ['gallery_category_id', 'form-control is-invalid', 'pilih kategori'],
            'caption.required' => ['caption', 'form-control is-invalid', 'masukan caption'],
            'source.image' => ['source', 'form-control is-invalid', 'format gambar berupa jpeg,png,jpg'],
            'source.required' => ['source', 'form-control is-invalid', 'masukan gambar'],
        ];
    }
}
