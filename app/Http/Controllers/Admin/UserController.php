<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\AdminController;
use App\Models\Backend_user;
use App\Models\User;
use App\Models\User_group;
use Validator, Session, Redirect;

class UserController extends AdminController
{
    function backend(){
        $result = Backend_user::with('group')->paginate(20);
        return view('admin.user.backend', compact('result'));
    }
    function backend_create(){
        $groups = User_group::where('area', 'backend')->orderBy('id', 'desc')->get();
        return view('admin.user.create', compact('groups'));
    }
    function backend_store(Request $request){
        $data = $request->all();
        unset($data['_token']);
        $validator = Validator::make($data, [
            'name' => 'required|unique:backend_users,name',
            'email' => 'required|unique:backend_users,email',
            'password' => 'required'
            ]);
        if ($validator->fails())
        {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->withErrors($validator);
        }else{
            $user = Backend_user::create($data);
            if ($user) {
                Session::flash('message', 'created!');
            }
        }
        return Redirect::route('backend_user');
    }
    function backend_edit($id){
        $result = Backend_user::find($id);
        if (is_null($result)) {
            Session::flash('message', 'Not isset id '.$id.'!');
            return Redirect::route('backend_user');
        }
        $groups = User_group::where('area', 'backend')->orderBy('id', 'desc')->get();
        return view('admin.user.edit', compact('groups', 'result'));
    }
    function backend_update($id, Request $request){
        $data = $request->all();
        unset($data['_token']);
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
            ]);
        $exist['name'] = Backend_user::where('name', $data['name'])->where('id', '<>', $id)->first();
        $exist['email'] = Backend_user::where('email', $data['email'])->where('id', '<>', $id)->first();
        if (!is_null($exist['name'])) {
            Session::flash('name_exist', $data['name'].' already exist');
        }
        if (!is_null($exist['email'])) {
            Session::flash('email_exist', $data['email'].' already exist');
        }
        if ($validator->fails())
        {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->withErrors($validator);
        }
        if (!is_null($exist['email']) or !is_null($exist['name'])) {
            return redirect()->back()->withInput();
        }
        $result = Backend_user::find($id);
        $data['password'] = md5($data['password']);
        foreach ($data as $key => $value) {
            $result->$key = $value;
        }
        $result->save();
        Session::flash('message', 'updated!');
        return Redirect::route('backend_user');
    }
    function backend_delete($id){
        $user = Backend_user::find($id);
        $user->delete();
        Session::flash('message', 'deleted!');
        return Redirect::route('backend_user');
    }

    function frontend(){
        $result = User::with('avatar')->paginate(20);
        return view('admin.user.frontend', compact('result'));
    }
}
