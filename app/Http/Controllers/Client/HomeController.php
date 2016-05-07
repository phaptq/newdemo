<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Models\Post;
use App\Models\Article;
use App\Models\Post_data;

use Session, Auth, Validator, Cache;

class HomeController extends ClientController
{
    function index(Request $request){
        $limit = env('HOME_BLOCK');
        $minutes = env('CACHE_TIME');
        if (!Cache::has('home_recent_posts')) {
            $new_post = Post::with('category')->orderBy('order', 'desc')->take($limit)->get();
            Cache::put('home_recent_posts', $new_post, $minutes);
        }
        if (!Cache::has('home_viewed_posts')) {
            $new_post = Post::with('category')->orderBy('viewed', 'desc')->take($limit)->get();
            Cache::put('home_viewed_posts', $new_post, $minutes);
        }
        if (!Cache::has('home_articles')) {
            $new_post = Article::where('status', '')->orderBy('id', 'desc')->with('thumb')->take($limit)->get();
            Cache::put('home_articles', $new_post, $minutes);
        }
        if (!Cache::has('home_static')) {
            $today = date('Ymd', time());
            $datas = Post_data::where('date', $today)->with('post')->get();
            $chunk = $datas->chunk(5);
            foreach ($chunk as $key => $split_data) {
                foreach ($split_data as $value) {
                    $data = json_decode($value->data, true);
                    if (!is_null($value->post->static)) {
                        $static[$key][$value->ticker][$value->post->static] = [$data[$value->post->static][0],$data[$value->post->static][1]];
                    }
                }
            }
            if (isset($static)) {
                Cache::put('home_static', $static, $minutes);
            }
        }
        $statics = Cache::get('home_static');
        $recent_posts = Cache::get('home_recent_posts');
        $viewed_posts = Cache::get('home_viewed_posts');
        $articles = Cache::get('home_articles');
        return view('client.home.index', compact('recent_posts', 'viewed_posts', 'articles', 'limit', 'statics'));
    }

    function real_time(){
        include(app_path().'\libraries\simple_html_dom.php');
        $html = file_get_html('http://markets.wsj.com/');
        foreach($html->find('div#majorStockIndexes_moduleId') as $e){
            echo $e->innertext . '<br>';
        }
    }

    function upload(){
        try {
            //Load library for upload, image
            require_once(app_path() . '/Libraries/fileuploader.php');

            //Create & get path uploader dir
            $upload_path = 'data/uploads/';

            if (!is_dir($upload_path)) {
                @mkdir($upload_path, 0755, true);
            }

            //Check writeable
            if (!is_writable($upload_path)){
                die(htmlspecialchars(json_encode(array('success' => false, 'msg' => 'The directory cannot be writeable. Please check this !')), ENT_NOQUOTES));
            }

            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $allowedExtensions = array('jpeg', 'jpg', 'png', 'bmp', 'gif');

            // max file size in bytes
            $sizeLimit = 5 * 1024 * 1024;

            //Create a instance uploader
            $uploader = new \qqFileUploader\qqFileUploader($allowedExtensions, $sizeLimit);

            //Upload file
            $result = $uploader->handleUpload($upload_path);
            echo json_encode([
                'status' => $result['success'],
                'filename' => $result['name'],
                'link' => asset($upload_path.$result['filename'])
                ]);
        } catch (Exception $e){
            echo json_encode(array(
                'status' => false,
                'msg'    => $e->getMessage()
            ));
        }
    }
}