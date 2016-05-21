<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;

use Session, Auth, Cache, Redirect;

class ArticleController extends ClientController
{
    function index(){
        $page = isset($_GET['page'])? '_page'.$_GET['page']: '_page1';
        if (!Cache::has('article_all_'.$page)) {
            $minutes = env('CACHE_TIME');
            $perpage = env('ARTICLE_PERPAGE');
            $articles = Article::where('status', 'new')->with('category', 'thumb', 'comments')->paginate($perpage);
            Cache::put('article_all_'.$page, $articles, $minutes);
        }
        if (!Cache::has('categories')) {
            $categories = Category::orderBy('title', 'asc')->get();
            $minutes = env('CACHE_TIME');
            Cache::put('categories', $categories, $minutes);
        }
        $categories = Cache::get('categories');
        $result = Cache::get('article_all_'.$page);
        return view('client.article.index', compact('result', 'categories'));
    }

    function category($slug){
        $page = isset($_GET['page'])? '_page'.$_GET['page']: '_page1';
        if (!Cache::has('article_'.$slug.'_'.$page)) {
            $minutes = env('CACHE_TIME');
            $perpage = env('ARTICLE_PERPAGE');
            $articles = Article::where('status', 'new')->with('category', 'thumb', 'comments')->paginate($perpage);
            Cache::put('article_'.$slug.'_'.$page, $articles, $minutes);
        }
        if (!Cache::has('categories')) {
            $categories = Category::orderBy('title', 'asc')->get();
            $minutes = env('CACHE_TIME');
            Cache::put('categories', $categories, $minutes);
        }
        $categories = Cache::get('categories');
        $result = Cache::get('article_'.$slug.'_'.$page);
        $title = $categories->where('slug', $slug)->first();
        return view('client.article.index', compact('result', 'categories', 'title'));
    }

    function detail ($cat, $slug){
        if (!Cache::has('article_'.$cat.'_'.$slug)) {
            $minutes = env('CACHE_TIME');
            $article = Article::where('slug', $slug)->with('tags', 'category')->first();
            Cache::put('article_'.$cat.'_'.$slug, $article, $minutes);
        }
        $result = Cache::get('article_'.$cat.'_'.$slug);
        $page = isset($_GET['page'])? '_page'.$_GET['page']: '_page1';
        $perpage = env('ARTICLE_PERPAGE');
        $comments = Comment::where(['able' => 'article', 'able_id' => $result->id])->with('user')->paginate($perpage);
        if (!Cache::has('categories')) {
            $categories = Category::orderBy('title', 'asc')->get();
            $minutes = env('CACHE_TIME');
            Cache::put('categories', $categories, $minutes);
        }
        $categories = Cache::get('categories');

        return view('client.article.detail', compact('result', 'comments', 'categories'));
    }

    function post_comment($able, $id, Request $request){
        $data = $request->all();
        $data['content'] = trim($data['content']);
        if($data['content'] == '' ){
            return Redirect::back();
        }else{
            $comment = Comment::create([
                    'able' => $able,
                    'able_id' => $id,
                    'content' => $data['content'],
                    'user_id' => Auth::user()->id,
                    'order' => time()
                ]);
            Session::flash('has_comment', $comment->id);
            return Redirect::back();
        }
    }

    function about_us(){
        if(!Cache::has('about_us')){
            $minutes = env('CACHE_TIME');
            $about = Article::where('status', 'about_us')->first();
            Cache::put('about_us', $about, $minutes);
        }
        $result = Cache::get('about_us');
        if (!Cache::has('categories')) {
            $categories = Category::orderBy('title', 'asc')->get();
            $minutes = env('CACHE_TIME');
            Cache::put('categories', $categories, $minutes);
        }
        $categories = Cache::get('categories');
        $comments = NULL;
        return view('client.article.detail', compact('result', 'comments', 'categories'));
    }
}