<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private $model;
    private $path;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->model = new Gallery();
        $this->path = '/upload/images/gallery';
    }
    public function index()
    {
        $category = GalleryCategory::get();
        $data = $this->model->with('category')->get();
        return view('admin.content.gallery.index', [
            'title' => 'Galeri',
            'data' => $data,
            'category' => $category,
        ]);
    }
    public function store(StoreGalleryRequest $request)
    {
        $data = $request->except('_token', 'source');
        try {
            if ($request->hasFile('source')) {
                $source = $request->file('source');
                $extension = $source->getClientOriginalExtension();
                $filename = date('ymd') . "-" . generateRandomString(10) . "." . $extension;
                // save source
                $source->move(public_path($this->path), $filename);
                $data['source'] = $this->path .'/'. $filename;
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
    public function update(UpdateGalleryRequest $request, $id)
    {
        $oldData = $this->model->where('id', $id)->first();
        $data = $request->except('_token', 'source');
        try {
            if ($request->hasFile('source')) {
                $source = $request->file('source');
                $extension = $source->getClientOriginalExtension();
                $filename = date('ymd') . "-" . generateRandomString(10) . "." . $extension;
                // deleteold image
                if (isset($oldData->source)) {
                    unlink(public_path($oldData->source));
                }
                // save source
                $source->move(public_path($this->path), $filename);
                $data['source'] = $this->path .'/'. $filename;
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
        if (isset($findData->source)) {
            unlink(public_path($findData->source));
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
