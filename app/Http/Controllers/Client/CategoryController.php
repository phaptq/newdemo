<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Models\Post;
use App\Models\Category;
use App\Models\Post_data;

use Session, Auth, Validator, Cache;

class CategoryController extends ClientController
{
    function index($slug){
        $page = isset($_GET['page'])? '_page'.$_GET['page']: '_page1';
        if (!Cache::has($slug.$page)) {

            $minutes = env('CACHE_TIME');
            $perpage = env('CATEGORY_PERPAGE');
            switch ($slug) {
                case 'moi-cap-nhat':
                    $title = 'Mới cập nhật';
                    $result = Post::orderBy('order', 'desc')->with('category', 'data')->paginate($perpage);
                    break;
                case 'xem-nhieu-nhat':
                    $title = 'Được quan tâm nhiều';
                    $result = Post::orderBy('viewed', 'desc')->with('category', 'data')->paginate($perpage);
                    break;
                default:
                    $category = Category::where('slug', $slug)->first();
                    $title = $category->title;
                    $result = Post::where('category_id', $category->id)->with('category', 'data')->orderBy('order', 'desc')->paginate($perpage);
                    break;
            }
            Cache::put($slug.$page, ['result' => $result, 'title' => $title], $minutes);
        }
        $result = Cache::get($slug.$page);
        return view('client.category.index', compact('result'));
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