<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategoryRequest;
use App\Models\PostCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    private $model;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->model = new PostCategory();
    }
    public function index()
    {
        $data = $this->model->get();
        return view('admin.content.post-category.index', [
            'title' => 'Kategori Artikel',
            'data' => collect($data)->sortBy([['id', 'desc']]),
        ]);
    }
    public function store(PostCategoryRequest $request)
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
    public function update(PostCategoryRequest $request, $id)
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
