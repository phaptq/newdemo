<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController;

class HomeController extends AdminController
{
    function index(){
        // dd(date('Y/m/d', strtotime(20161126)));
        return view('admin.home.index');
    }
}
