<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryCategoryRequest;
use App\Models\GalleryCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    private $model;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->model = new GalleryCategory();
    }
    public function index()
    {
        $data = $this->model->get();
        return view('admin.content.gallery-category.index', [
            'title' => 'Kategori Galeri',
            'data' => collect($data)->sortBy([['id', 'desc']]),
        ]);
    }
    public function store(GalleryCategoryRequest $request)
    {
        $data = $request->except('_token');
        $data['slug'] = slugify($data['name']);
        $findData = $this->model->where('slug', $data['slug'])->first();
        if (isset($findData->id)) {
            return sendResponse('error', 'Kategori sudah ada');
        }
        try {
            $this->model->create($data);
            $success = true;
            $message = 'ok';
        } catch (QueryException $e) {
            $success = false;
            $message = $e->errorInfo;
        }
        return sendResponse($success, $message);
    }
    public function update(GalleryCategoryRequest $request, $id)
    {
        $findData = $this->model->where('id', $id)->first();
        if (!isset($findData->id)) {
            return sendResponse(false, 'Data tidak ditemukan');
        }
        $data = $request->except('_token');
        $data['slug'] = slugify($data['name']);
        $findData = $this->model->whereNotIn('id', [$id])->where('slug', $data['slug'])->first();
        if (isset($findData->id)) {
            return sendResponse('error', 'Kategori sudah ada');
        }
        try {
            $this->model->where('id', $id)->update($data);
            $success = true;
            $message = 'ok';
        } catch (QueryException $e) {
            $success = false;
            $message = $e->errorInfo;
        }
        return sendResponse($success, $message);
    }
    public function destroy($id)
    {
        $findData = $this->model->where('id', $id)->first();
        if (!isset($findData->id)) {
            return sendResponse(false, 'Data tidak ditemukan');
        }
        try {
            $this->model->where('id', $id)->delete();
            $success = true;
            $message = 'ok';
        } catch (QueryException $e) {
            $success = false;
            $message = $e->errorInfo;
        }
        return sendResponse($success, $message);
    }
}
