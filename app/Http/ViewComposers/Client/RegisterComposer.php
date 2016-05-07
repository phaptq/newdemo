<?php
namespace App\Http\ViewComposers\Client;
use App\Models\Article;
use Cache;

class RegisterComposer {
    public function compose($view) {
        if (!Cache::has('register_article')) {
            Cache::put('register_article', Article::where('status', 'terms')->first(), 1440);
        }
        $terms = Cache::get('register_article');
        $view->with([
            'terms'        => $terms
        ]);
    }
}