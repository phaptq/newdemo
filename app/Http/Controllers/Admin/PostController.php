<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;

use Validator, Session, Redirect;
use Khill\Lavacharts\Lavacharts;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Post_data;

class PostController extends AdminController
{
    function index(){
        if (isset($_GET['k']) and !is_null($_GET['k']) AND ($_GET['k'] != '')) {
            $keyword = $_GET['k'];
            if (!is_null($keyword) AND ($keyword != '')) {
                $result = Post::where('title', 'like', "%$keyword%")->orderBy('id', 'desc')->with('category')->paginate(20);
            }
        }else{
            $result = Post::with('category')->orderBy('id', 'desc')->paginate(10);
        }
        return view('admin.post.index', compact('result'));
    }

    function show($id){
        $result = Post::where('id', $id)->with('data')->first();
        return view('admin.post.show', compact('result'));
    }

    function edit_chart($id){
        $chart_data = Post_data::where('post_id', $id)->first();
        $data['Date'] = json_decode($chart_data->column);
        foreach (json_decode($chart_data->data, true) as $key => $item) {
            $data[$key] = $item;
        }
        $max_key = count($data['Date']) - 1;
        $perpage = 30;
        $page = isset($_GET['page'])? $_GET['page']: 1;
        $offset = $page==1? 0: ($perpage*$page - $perpage);
        foreach ($data as $key => $chart) {
            for ($i=$offset; $i < $offset+$perpage ; $i++) {
                $result[$key][$i] = $chart[$i];
            }
        }
        $post = Post::find($id);
        return view('admin.post.chart', compact('result', 'max_key', 'post', 'perpage', 'i'));
    }

    function update_chart($id, Request $request){
        $data = $request->all();
        $charts = Post_data::where('post_id', $id)->get();
        foreach ($charts as $value) {
            $chart['Date'] = json_decode($value->column);
            foreach (json_decode($value->data, true) as $key => $item) {
                $chart[$key] = $item;
            }
        }
        if (isset($data['new'])) {
           $new = $data['new'];
           unset($data['new']);
        }
        unset($data['_token']);
        foreach ($data as $key => $value) {
            foreach ($value as $k => $item) {
                $chart[$key][$k] = $item;
            }
        }
        if (isset($new)) {
            foreach ($new as $key => $value) {
                krsort($value);
                foreach ($value as $k => $item) {
                    array_unshift($chart[$key], $item);
                }
            }
        }
        foreach ($charts as $new_value) {
            $new_value->column = json_encode($chart['Date']);
            $new_chart = NULL;
            foreach (json_decode($new_value->data, true) as $key => $item) {
                $new_chart[$key] = $chart[$key];
            }
            $new_value->data = json_encode($new_chart);
            $new_value->date = $chart['Date'][0];
            $new_value->save();
        }
        $post = Post::find($id);
        $post->order = time();
        $post->save();
        Session::flash('message', 'Cập nhật dữ liệu thành công.');
        return Redirect::route('backend_post');
    }

    function create(){
        $categories = Category::all();
        return view('admin.post.create', compact('categories'));
    }

    function store(Request $request){
        if (\Request::hasFile('file')){
            $data = $request->all();

            foreach ($data['file'] as $file) {
                if (!empty($file)) {
                    $content = file_get_contents($file);
                    $content = explode("\r\n", $content);
                    $title = explode(",", array_shift($content));
                    array_shift($title);
                    $content_arr = NULL;
                    foreach ($content as $item_arr) {
                        if ($item_arr != NULL) {
                            $item_arr = explode(",", $item_arr);
                            $ticker = array_shift($item_arr);
                            foreach ($title as $key => $value) {
                                $content_arr[$value][] = $item_arr[$key];
                            }
                        }
                    }
                    $column = $content_arr['Date'];
                    unset($content_arr['Date']);
                    $post_title = $ticker;
                    $post = Post::create([
                        'title' => $post_title,
                        'order' => time(),
                        'user_id' => Session::get('admin')->id,
                        'category_id' => $data['category_id']
                    ]);
                    $post->slug = str_slug($post_title).'-'.$post->id;
                    $post->save();
                    Post_data::create([
                            'post_id' => $post->id,
                            'type' => $data['type'],
                            'ticker' => $ticker,
                            'order' => 0,
                            'date' => $column[0],
                            'column' => json_encode($column),
                            'data' => json_encode($content_arr)
                        ]);
                }
            }
        }else{
            Session::flash('message', 'Chưa chọn file để upload');
            return Redirect::back()->withInput();
        }

        Session::flash('message', 'Thành công!');
        return Redirect::route('backend_post');
    }

    function edit($id){
        $result = Post::where('id', $id)->with('category', 'data')->first();
        $categories = Category::all();
        return view('admin.post.edit', compact('result', 'categories'));
    }

    function update($id, Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
        ]);
        $isset = Post::where('id','<>', $id)->where('title', $data['title'])->first();
        if (!is_null($isset)) {
            Session::flash('title_err', 'false! Đã tồn tại '. $data['title']);
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
        $result = Post::find($id);
        foreach ($data as $key => $value) {
            $result->$key = $value;
        }
        $result->slug = str_slug($result->title).'-'.$result->id;
        $result->save();
        Session::flash('message', 'updated!');
        return Redirect::route('backend_post');
    }

    function delete($id){
        $result = Category::find($id);
        $result->delete();
        Session::flash('message', 'deleted!');
        return Redirect::back();
    }
}
