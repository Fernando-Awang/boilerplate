<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $model;
    private $path;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->model = new Product();
        $this->path = '/upload/images/product';
    }
    public function index()
    {
        $category = ProductCategory::get();
        $data = $this->model->with('category')->get();
        return view('admin.content.product.index', [
            'title' => 'Produk',
            'data' => $data,
            'category' => $category,
        ]);
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->except('_token', 'thumbnail');
        $data['slug'] = slugify($data['name']);
        $findData = $this->model->where('slug', $data['slug'])->first();
        if (isset($findData->id)) {
            return sendResponse('error', 'Slug sudah ada');
        }
        // return sendResponse(false, $data);
        try {
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $extension = $thumbnail->getClientOriginalExtension();
                $filename = date('ymd') . "-" . generateRandomString(10) . "." . $extension;
                // save thumbnail
                $thumbnail->move(public_path($this->path), $filename);
                $data['thumbnail'] = $this->path .'/'. $filename;
            }
            $this->model->create($data);
            $success = true;
            $message = 'ok';
        } catch (QueryException $e) {
            $success = false;
            $message = $e->errorInfo;
        }
        return sendResponse($success, $message);
    }
    public function show($id)
    {
        $data = $this->model->where('id', $id)->first();
        return response()->json($data);
    }
    public function update(UpdateProductRequest $request, $id)
    {
        $oldData = $this->model->where('id', $id)->first();
        if (!isset($oldData->id)) {
            return sendResponse(false, 'Data tidak ditemukan');
        }
        $data = $request->except('_token', 'thumbnail');
        $data['slug'] = slugify($data['name']);
        $findData = $this->model->whereNotIn('id', [$id])->where('slug', $data['slug'])->first();
        if (isset($findData->id)) {
            return sendResponse('error', 'Slug sudah ada');
        }
        try {
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $extension = $thumbnail->getClientOriginalExtension();
                $filename = date('ymd') . "-" . generateRandomString(10) . "." . $extension;
                // deleteold image
                if (isset($oldData->thumbnail)) {
                    unlink(public_path($oldData->thumbnail));
                }
                // save thumbnail
                $thumbnail->move(public_path($this->path), $filename);
                $data['thumbnail'] = $this->path .'/'. $filename;
            }
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
        if (isset($findData->thumbnail)) {
            unlink(public_path($findData->thumbnail));
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
