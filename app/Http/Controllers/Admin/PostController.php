<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $model;
    private $path;
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->model = new Post();
        $this->path = '/upload/images/post';
    }
    public function index()
    {
        $category = PostCategory::get();
        $data = $this->model->with('category')->with('get_author')->get();
        return view('admin.content.post.index', [
            'title' => 'Artikel',
            'data' => $data,
            'category' => $category,
        ]);
    }
    public function store(StorePostRequest $request)
    {
        $data = $request->except('_token', 'thumbnail');
        $data['slug'] = slugify($data['title']);
        $data['author'] = auth()->user()->id;
        $findData = $this->model->where('slug', $data['slug'])->first();
        if (isset($findData->id)) {
            return sendResponse('error', 'Slug sudah ada');
        }
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $extension = $thumbnail->getClientOriginalExtension();
            $filename = date('ymd') . "-" . generateRandomString(10) . "." . $extension;
            // save thumbnail
            $thumbnail->move(public_path($this->path), $filename);
            $data['thumbnail'] = $this->path .'/'. $filename;
        }
        // return sendResponse(false, $data);
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
    public function show($id)
    {
        $data = $this->model->where('id', $id)->first();
        return response()->json($data);
    }
    public function update(UpdatePostRequest $request, $id)
    {
        $oldData = $this->model->where('id', $id)->first();
        if (!isset($oldData->id)) {
            return sendResponse(false, 'Data tidak ditemukan');
        }
        $data = $request->except('_token', 'thumbnail');
        $data['slug'] = slugify($data['title']);
        $findData = $this->model->whereNotIn('id', [$id])->where('slug', $data['slug'])->first();
        if (isset($findData->id)) {
            return sendResponse('error', 'Slug sudah ada');
        }
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
        if (isset($findData->thumbnail)) {
            unlink(public_path($findData->thumbnail));
        }
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
