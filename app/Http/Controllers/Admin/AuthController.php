<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use App\Models\Backend_user;
use App\Models\User_group;

class AuthController extends AdminController
{
    public function getLogin() {
        if (\Session::has('admin')) {
            return \Redirect::route('admin');
        }
        return view('admin.auth.login');
    }

    public function postLogin() {
        $auth = Backend_user::where(['password' => md5(\Request::input('password')), 'email' => \Request::input('email')])->first();
        if (!is_null($auth)) {
            \Session::set('admin', $auth);
            if (\Session::has('current_url') and \Session::get('current_url') != route('admin_logout')) {
                $url = \Session::get('current_url');
                \Session::forget('current_url');
                return \Redirect::to($url);
            }
            return \Redirect::action('Admin\HomeController@index');
        }
        \Session::flash('message', '<p class="alert alert-warning">Not correct!</p>');
        return \Redirect::back()->withInput();
    }

    public function getLogout() {
        \Session::forget('admin');
        return \Redirect::action('Admin\AuthController@getLogin');
    }
}
