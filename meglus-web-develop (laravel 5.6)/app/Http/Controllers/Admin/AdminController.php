<?php

namespace App\Http\Controllers\Admin;

use App\Model\SupplyUserInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Index function admin
     */
    public function index()
    {
        return view('sample_admin', ['sample' => 'this is admin page']);
    }

    /**
     * function login
     */
    public function login(Request $request)
    {
        return view('sample_admin', ['sample' => 'this is admin login page']);
    }
}
