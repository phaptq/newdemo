<?php
namespace App\Http\ViewComposers\Client;

use App\Models\Category;
use App\Models\Article;

use Cache;

class HeaderComposer {
    public function compose($view) {
        $minutes = env('CACHE_TIME');
        if (!Cache::has('categories')) {
            $categories = Category::whereNull('parent_id')->orderBy('order', 'asc')->get();
            Cache::put('categories', $categories, $minutes);
        }

        $view->with([
            'categories' => Cache::get('categories')
        ]);
    }
}