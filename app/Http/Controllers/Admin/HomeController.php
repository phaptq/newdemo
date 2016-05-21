<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use App\Models\Post;
use App\Models\Live_data;

use Cache, Session;

class HomeController extends AdminController
{
    function index(){

        return view('admin.home.index');
    }

    function live($url){
        return view('admin.home.live', compact($url));
    }

    function live_data(){
        include(app_path().'\libraries\simple_html_dom.php');
        $html = file_get_html('http://markets.wsj.com/');
        foreach($html->find('#majorStockIndexes_moduleId table tbody tr td') as $e){
            if(strpos($e->outertext, 'class="firstCol"')){
                $keys[] = $e->find('a', 0)->plaintext;
            }
            if(strpos($e->outertext, 'class="dataCol"')){
                $values[] = $e->plaintext;
            }
        }
        $result = array_combine($keys, $values);
        Cache::forever('live_data', $result);
        foreach ($result as $key => $value) {
            $hour = date('YmdH', time());
            // Set preview time
            if(!Cache::has('time_hour_'.$key)){
                Cache::put('time_hour_'.$key, $hour, 70);
                if(Cache::has($key.'_secondly')){
                    Cache::forget($key.'_secondly');
                }
            }
            // Update DB hourly and reset Secondly cache
            if(Cache::get('time_hour_'.$key) < $hour and Cache::has($key.'_secondly')){
                $hourly = number_format(array_sum(array_values(Cache::get($key.'_secondly')))/count(Cache::get($key.'_secondly')), 2, '.', '');
                Cache::forget($key.'_secondly');
                # insert db
                $db = Live_data::where('title', $key)->first();
                if(is_null($db)){
                    #insert first hourly
                    $date = date('Ymd', strtotime(Cache::get('time_hour_'.$key).'0000'));
                    $db = Live_data::create([
                            'title' => $key,
                            'ticker' => $key,
                            'daily' => json_encode([Cache::get('time_hour_'.$key) => $hourly]),
                            'daily_date' => $date,
                            'hourly_time' => $hour,
                            'data' => json_encode([])
                        ]);
                    $db->slug = str_slug($key).'-'.$db->id;
                }else{
                    $daily = json_decode($db->daily, true);
                    if($db->daily_date < date('Ymd', time())){
                        $date = $db->daily_date;
                        $daily_value = number_format(array_sum(array_values($daily))/count($daily), 2, '.', '');
                        $data = json_decode($db->data, true);
                        $data[$date] = $daily_value;
                        $db->data = json_encode($data);
                        $db->daily_date = date('Ymd', strtotime($hour.'0000'));
                        $db->daily = json_encode([Cache::get('time_hour_'.$key) => $hourly]);
                    }else{
                        $daily[Cache::get('time_hour_'.$key)] = $hourly;
                        $db->daily = json_encode($daily);
                    }
                    $db->hourly_time = $hour;
                }
                $db->save();
                Cache::put('time_hour_'.$key, $hour, 70);
                Cache::forget($key.'_secondly');
            }
            // create or update Secondly cache
            $second = date('YmdHis', time());
            if(!Cache::has($key.'_secondly')){
                $secondly = [$second => $value];
            }else{
                $secondly = Cache::get($key.'_secondly');
                $secondly[$second] = $value;
            }
            Cache::forever($key.'_secondly', $secondly);
        }
        echo json_encode([
                'result' => $result
            ]);
    }
}
