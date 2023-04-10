<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    // protected function guard()
    // {
    //     return Auth::guard('admin');
    // }
    public function index()
    {
        return view('admin.home');
    }
}
