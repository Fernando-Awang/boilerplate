<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $model;
    public function __construct(User $model)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->model = new User();
    }
    public function index()
    {
        $data = $this->model->whereNotIn('id', [auth()->user()->id])->get();
        return view('admin.content.user.index', [
            'title' => 'Data Admin',
            'data' => $data,
        ]);
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->except('_token', 'password');
        $data['password'] = Hash::make($request->password);
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
    public function update(UpdateUserRequest $request, $id)
    {
        $findData = $this->model->where('id', $id)->first();
        if (!isset($findData->id)) {
            return sendResponse(false, 'Data tidak ditemukan');
        }
        $data = $request->except('_token', 'password');
        if($request->password != '') {
            $data['password'] = Hash::make($request->password);
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
