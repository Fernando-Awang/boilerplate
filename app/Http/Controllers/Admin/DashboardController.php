<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $dataPost = \App\Models\Post::count();
        $dataGallery = \App\Models\Gallery::count();
        $dataProduct = \App\Models\Product::count();
        $dataUser = \App\Models\User::count();
        $latesPost = \App\Models\Post::orderBy('created_at', 'desc')->limit(5)->with('category')->get();
        return view('admin.content.dashboard.index', [
            'title' => 'Dashboard',
            'dataPost' => $dataPost,
            'dataGallery' => $dataGallery,
            'dataProduct' => $dataProduct,
            'dataUser' => $dataUser,
            'latesPost' => $latesPost,
        ]);
    }
}
