<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new CompanyInfo();
    }
    public function index()
    {
        $data = $this->model->first();
        return view('admin.content.company-info.index', [
            'title' => 'Profil Instansi',
            'data' => $data,
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
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
        //
    }
}
