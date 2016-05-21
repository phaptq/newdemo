<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Models\Post;
use App\Models\Category;
use App\Models\Post_data;

use Session, Auth, Validator, Cache;

class PostController extends ClientController
{
    function detail($cat, $slug = false){
        if(!Cache::has('categories_with_posts')){
            $categories = Category::with('posts')->get();
            Cache::put('categories_with_posts', $categories, env('CACHE_TIME'));
        }
        $categories = Cache::get('categories_with_posts');
        $result = Post::where('slug', $slug)->with('data', 'category')->first();
        $result->viewed++;
        $result->save();
        return view('client.post.detail', compact('result', 'categories'));
    }
    function update(){
        $data = Post_data::where('post_id', \Request::input('id'))->first();
        // echo $data->column;die;
        $key = \Request::input('key');
        $column = json_decode($data->column, true);
        foreach ($column as $k => $value) {
            if ($value >= $key) {
                $res_key = $k;
            }
        }
        $labels = array_splice($column, $res_key);
        $cate = [];
        foreach ($column as $key => $value) {
            array_unshift($cate, $value);
        }
        $label_data = json_decode($data->data);
        foreach($label_data as $label => $item){
            $arr = array_splice($item, $res_key);
            krsort($item);
            $datasets[$label] = array_values($item);
        }
        $datasets['_labels'] = $cate;
        echo json_encode($datasets);
    }
}