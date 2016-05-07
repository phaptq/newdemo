<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Validator, Session, Redirect;
use App\Models\Setting;

class SettingController extends AdminController
{
    function article_image(){
        $result = Setting::where(['type' => 'image', 'location' => 'article'])->first();
        return view('admin.setting.article_image', compact('result'));
    }
    function article_update(Request $request){
        $data = $request->all();
        $result = Setting::find($data['id']);
        unset($data['_token'], $data['id']);
        foreach ($data as $key => $value) {
            $setting[$key] = $value;
        }
        $setting['data'] = json_encode($data['data']);
        if (!is_null($result)) {
            foreach ($setting as $key => $value) {
                $result->$key = $value;
            }
            $result->save();
        }else{
            $result = Setting::firstOrCreate($setting);
        }
        Session::flash('message', 'Updated!');
        return Redirect::route('article_image_setting');
    }

    function edit($id){
        $result = Server::find($id);
        return view('admin.server.edit', compact('result'));
    }

    function update($id, Request $request){
        $server = Server::find($id);
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
        ]);
        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $isset = Server::where('id','<>', $id)->where('title', $data['title'])->get();
        if ($isset->count()>0) {
            Session::flash('message', 'false! that title already exist');
            return Redirect::back()->withInput();
        }
        $server->title       = $data['title'];
        $server->title_ascii = Str::ascii($data['title']);
        $server->type        = $data['type'];
        $server->status      = !isset($data['status'])? NULL: $data['status'];
        $server->default     = !isset($data['default'])? NULL: $data['default'];
        $server->data        = json_encode($data['data']);
        $server->description = $data['description'];
        $server->save();
        Session::flash('message', 'updated!');
        return Redirect::route('backend_server');
    }

    function delete($id){
        $server = Server::find($id);
        $server->delete();
        Session::flash('message', 'deleted!');
        return Redirect::back();
    }
}
