<?php namespace App\Http\Controllers;

class ClientController extends Controller {
    public function __construct()
    {
        // Defaults
        // if (!\Cache::has('seo')) {
        //     \Cache::forever('seo', json_decode(\App\Models\Setting::where('type', 'seo')->first()->data));
        // }
        // foreach (\Cache::get('seo') as $key => $value) {
        //     \MetaTag::set($key, $value);
        // }
    }
}