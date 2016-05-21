<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Backend
Route::group(['prefix' => env('ADMIN_URL'), 'namespace' => 'Admin', 'middleware' => 'web'], function(){
    Route::get('/login',                             ['as' => 'backend_login','uses' => 'AuthController@getLogin']);
    Route::post('/login',                            ['as' => 'backend_post_login','uses' => 'AuthController@postLogin']);

    // Live data
    Route::get('/live/{url}',                        ['as' => 'live_data','uses' => 'HomeController@live']);
    Route::post('/live/data',                        ['as' => 'get_live_data','uses' => 'HomeController@live_data']);

    Route::group(['middleware' => 'admin'], function(){
        Route::get('/logout',                            ['as' => 'admin_logout','uses' => 'AuthController@getLogout']);
        Route::get('/',                                  ['as' => 'admin','uses' => 'HomeController@index']);

        // Payment
        Route::group(['prefix' => 'payment'], function(){
            Route::get('/ngan-luong',                    ['as' => 'backend_ngan_luong','uses' => 'PricingController@nganluong']);
            Route::post('/ngan-luong',                   ['as' => 'update_nganluong','uses' => 'PricingController@update_nganluong']);
        });

        // Pricing:
        Route::group(['prefix' => 'pricing'], function(){
            Route::get('/',                             ['as' => 'backend_pricing','uses' => 'PricingController@index']);
            Route::post('/',                            ['as' => 'store_pricing','uses' => 'PricingController@store']);
            Route::get('/edit/{id}',                    ['as' => 'edit_pricing','uses' => 'PricingController@edit']);
            Route::post('/edit/{id}',                   ['as' => 'update_pricing','uses' => 'PricingController@update']);
            Route::get('/delete/{id}',                  ['as' => 'delete_pricing','uses' => 'PricingController@delete']);
        });

        // User:
        Route::group(['prefix' => 'user'], function(){
            Route::get('/backend',                       ['as' => 'backend_user','uses' => 'UserController@backend']);
            Route::get('/backend/create',                ['as' => 'backend_user_create','uses' => 'UserController@backend_create']);
            Route::post('/backend/create',               ['as' => 'backend_user_store','uses' => 'UserController@backend_store']);
            Route::get('/backend/edit/{id}',             ['as' => 'backend_user_edit','uses' => 'UserController@backend_edit']);
            Route::post('/backend/edit/{id}',            ['as' => 'backend_user_update','uses' => 'UserController@backend_update']);
            Route::get('/backend/delete/{id}',           ['as' => 'backend_user_delete','uses' => 'UserController@backend_delete']);
            Route::get('/frontend',                      ['as' => 'frontend_user','uses' => 'UserController@frontend']);
            Route::get('/frontend/show/{id}',            ['as' => 'frontend_user_show','uses' => 'UserController@frontend_show']);
            Route::get('/frontend/edit/{id}',            ['as' => 'frontend_user_edit','uses' => 'UserController@frontend_edit']);
            Route::post('/frontend/edit/{id}',           ['as' => 'frontend_user_update','uses' => 'UserController@frontend_update']);
            Route::get('/frontend/delete/{id}',          ['as' => 'frontend_user_delete','uses' => 'UserController@frontend_delete']);
        });
        // Server:
        Route::group(['prefix' => 'server'], function(){
            Route::get('/',                             ['as' => 'backend_server','uses' => 'ServerController@index']);
            Route::get('/create',                       ['as' => 'create_server','uses' => 'ServerController@create']);
            Route::post('/create',                      ['as' => 'store_server','uses' => 'ServerController@store']);
            Route::get('/edit/{id}',                    ['as' => 'edit_server','uses' => 'ServerController@edit']);
            Route::post('/edit/{id}',                   ['as' => 'update_server','uses' => 'ServerController@update']);
            Route::get('/delete/{id}',                  ['as' => 'delete_server','uses' => 'ServerController@delete']);
        });
        // Category:
        Route::group(['prefix' => 'category'], function(){
            Route::get('/',                             ['as' => 'backend_category','uses' => 'CategoryController@index']);
            Route::get('/create',                       ['as' => 'create_category','uses' => 'CategoryController@create']);
            Route::post('/create',                      ['as' => 'store_category','uses' => 'CategoryController@store']);
            Route::get('/edit/{id}',                    ['as' => 'edit_category','uses' => 'CategoryController@edit']);
            Route::post('/edit/{id}',                   ['as' => 'update_category','uses' => 'CategoryController@update']);
            Route::get('/delete/{id}',                  ['as' => 'delete_category','uses' => 'CategoryController@delete']);
        });
        // Post:
        Route::group(['prefix' => 'post'], function(){
            Route::get('/',                             ['as' => 'backend_post','uses' => 'PostController@index']);
            Route::get('/create',                       ['as' => 'create_post','uses' => 'PostController@create']);
            Route::post('/create',                      ['as' => 'store_post','uses' => 'PostController@store']);
            Route::get('/edit/{id}',                    ['as' => 'edit_post','uses' => 'PostController@edit']);
            Route::post('/edit/{id}',                   ['as' => 'update_post','uses' => 'PostController@update']);
            Route::get('/delete/{id}',                  ['as' => 'delete_post','uses' => 'PostController@delete']);
            Route::get('/update/{id}',                  ['as' => 'edit_chart','uses' => 'PostController@edit_chart']);
            Route::post('/update/{id}',                 ['as' => 'update_chart','uses' => 'PostController@update_chart']);
            Route::get('/{id}',                         ['as' => 'show_post','uses' => 'PostController@show']);
        });
        // Article:
        Route::group(['prefix' => 'article'], function(){
            Route::get('/',                             ['as' => 'backend_article','uses' => 'ArticleController@index']);
            Route::get('/create',                       ['as' => 'create_article','uses' => 'ArticleController@create']);
            Route::post('/create',                      ['as' => 'store_article','uses' => 'ArticleController@store']);
            Route::get('/edit/{id}',                    ['as' => 'edit_article','uses' => 'ArticleController@edit']);
            Route::post('/edit/{id}',                   ['as' => 'update_article','uses' => 'ArticleController@update']);
            Route::post('/upload',                      ['as' => 'article_upload','uses' => 'ArticleController@upload']);
            Route::post('/image/delete',                ['as' => 'delete_article_img','uses' => 'ArticleController@delete_image']);
            Route::get('/delete/{id}',                  ['as' => 'delete_article','uses' => 'ArticleController@delete']);
        });
        // Setting:
        Route::group(['prefix' => 'setting'], function(){
            Route::get('/image/article',                        ['as' => 'article_image_setting','uses' => 'SettingController@article_image']);
            Route::post('/image/article',                       ['as' => 'article_image_update','uses' => 'SettingController@article_update']);
        });
    });
});

// Frontend
Route::group(['middleware' => 'web'], function(){
    Route::auth();
    Route::post('/ca-nhan/dang-ky',                 ['as' => 'register','uses' => 'Auth\ManualController@register_manual']);
});
Route::group(['prefix' => '', 'namespace' => 'Client', 'middleware' => 'web'], function(){
    Route::get('/',                                 ['as' => 'home','uses' => 'HomeController@index']);
    Route::post('/real-time',                       ['as' => 'get_real','uses' => 'HomeController@live']);
    Route::post('/load-data',                       ['as' => 'load_data','uses' => 'HomeController@load_data']);
    Route::post('/load-live',                       ['as' => 'load_live','uses' => 'HomeController@load_live']);
    Route::get('tin-tuc',                           ['as' => 'article','uses' => 'ArticleController@index']);
    Route::get('bang-gia',                          ['as' => 'pricing','uses' => 'PricingController@index']);
    Route::get('ve-chung-toi',                      ['as' => 'about_us','uses' => 'ArticleController@about_us']);
    Route::group(['middleware' => 'auth'], function(){
        Route::get('thanh-toan',                        ['as' => 'check_out_pricing','uses' => 'PricingController@check_out']);
        Route::post('thanh-toan',                       ['as' => 'check_out_nganluong','uses' => 'PricingController@nganluong_check_out']);
        Route::get('thanh-toan-thanh-cong',             ['as' => 'nganluong_success','uses' => 'PricingController@nganluong_success']);
        Route::post('comment/{able}/{id}',              ['as' => 'post_comment','uses' => 'ArticleController@post_comment']);
    });
    Route::get('tin-tuc/{slug}',                    ['as' => 'article_category','uses' => 'ArticleController@category']);
    Route::get('tin-tuc/{cat}/{slug}',              ['as' => 'article_detail','uses' => 'ArticleController@detail']);
    Route::get('/{cat}/{slug}',                     ['as' => 'detail','uses' => 'PostController@detail']);
    Route::get('/{slug}',                           ['as' => 'category','uses' => 'CategoryController@index']);
});


View::composer(['client.layouts.header'], 'App\Http\ViewComposers\Client\HeaderComposer');
