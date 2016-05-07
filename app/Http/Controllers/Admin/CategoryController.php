<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Validator, Session, Redirect;
use App\Models\Category;

class CategoryController extends AdminController
{
    function index(){
        $result = Category::whereNull('parent_id')->with('items')->get();
        return view('admin.category.index', compact('result'));
    }

    function create(){
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.category.create', compact('parents'));
    }

    function store(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|max:255|unique:categories,title',
            'slug'  => 'required|max:255|unique:categories,slug',
        ]);
        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
            return Redirect::back()->withInput()->withErrors($validator);
        }
        unset($data['_token']);
        $data['seo']['description'] = $data['description'];
        $data['seo'] = json_encode($data['seo']);
        foreach ($data as $key => $value) {
            if($value==''){
                unset($data[$key]);
            }
        }
        $category = Category::create($data);
        Session::flash('message', 'Created!');
        return Redirect::route('backend_category');
    }

    function edit($id){
        $result = Category::find($id);
        $parents = Category::whereNull('parent_id')->where('id', '<>', $id)->get();
        return view('admin.category.edit', compact('result', 'parents'));
    }

    function update($id, Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);
        $isset = Category::where('id','<>', $id)->where('title', $data['title'])->first();
        if (!is_null($isset)) {
            Session::flash('title_err', 'false! that title already exist');
        }
        $isset_slug = Category::where('id','<>', $id)->where('slug', $data['slug'])->first();
        if (!is_null($isset_slug)) {
            Session::flash('slug_err', 'false! that slug already exist');
            $isset = $isset_slug;
        }
        if ($validator->fails() or !is_null($isset))
        {
            $this->throwValidationException(
                $request, $validator
            );
            return Redirect::back()->withInput()->withErrors($validator);
        }
        unset($data['_token']);
        $data['seo']['description'] = $data['description'];
        $data['seo'] = json_encode($data['seo']);
        $result = Category::find($id);
        foreach ($data as $key => $value) {
            if($value!=''){
                $result->$key = $value;
            }
        }
        $result->save();
        Session::flash('message', 'updated!');
        return Redirect::route('backend_category');
    }

    function delete($id){
        $result = Category::find($id);
        $result->delete();
        Session::flash('message', 'deleted!');
        return Redirect::back();
    }
}
