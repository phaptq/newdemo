<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use App\Models\Post;
use App\Models\Live_data;
use App\Models\Payment_cart;

use Cache, Session;

class HomeController extends AdminController
{

    function test_live(){
        include('libs_za/simple_html_dom.php');
        $html = file_get_html('http://google.com/');
        dd($html);
    }

    function index(){
        $payment = Payment_cart::with('user', 'plan')->paginate(20);
        return view('admin.home.index', compact('payment'));
    }

    function live($url){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        include(asset('libs/simple_html_dom.php'));
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
        return view('admin.home.live', compact('url'));
    }

    function live_data(){
        date_default_timezone_set('EST5EDT');
        $dt = \Carbon\Carbon::now();
        if($dt->dayOfWeek != \Carbon\Carbon::SUNDAY and $dt->dayOfWeek != \Carbon\Carbon::SATURDAY){
            if(date('H', time()) >= 5 and date('H', time()) <= 16){
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                include('libs_za/simple_html_dom.php');
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
                $time = time();
                $hour = date('YmdH', $time);
                // Set preview time
                if(!Cache::has('time_hour')){
                    Cache::forever('time_hour', $hour);
                }
                if(Cache::get('time_hour') == $hour){
                    if(Cache::has('secondly_live')){
                        $secondly_live = Cache::get('secondly_live');
                        foreach ($result as $key => $value) {
                            array_push($secondly_live[$key], $value);
                        }
                    }else{
                        foreach ($result as $key => $value) {
                            $secondly_live[$key] = [$value];
                        }
                    }
                    Cache::forever('secondly_live', $secondly_live);
                }else{
                    if(Cache::has('secondly_live')){
                        $secondly_live = Cache::get('secondly_live');
                        foreach ($secondly_live as $key => $value) {
                            $db = Live_data::where('title', $key)->first();
                            $date =  date('Ymd', strtotime(Cache::get('time_hour').'0000'));
                            $hourly = number_format(array_sum(array_values($value))/count($value), 2, '.', '');
                            if(is_null($db)){
                                #insert first hourly
                                $db = Live_data::create([
                                        'title' => $key,
                                        'ticker' => $key,
                                        'daily' => json_encode([$date => $hourly]),
                                        'daily_date' => $date,
                                        'weekly' => json_encode([]),
                                        'data' => json_encode([])
                                    ]);
                                $db->slug = str_slug($key).'-'.$db->id;
                            }else{
                                $daily_value = json_decode($db->daily, true);
                                if($db->daily_date < date('Ymd', $time)){
                                    $daily = number_format(array_sum(array_values($daily_value))/count($daily_value), 2, '.', '');
                                    $data = json_decode($db->data, true);
                                    $data[$db->daily_date] = $daily;
                                    $db->daily_date = date('Ymd', $time);
                                    $db->data = json_encode($data);
                                    $weekly = json_decode($db->weekly, true);
                                    $weekly[$db->daily_date] = $daily_value;
                                    if(count($weekly)>7){
                                        array_shift($weekly);
                                    }
                                    $db->weekly = json_encode($weekly);
                                     $daily_value = [];
                                }
                                $daily_value[Cache::get('time_hour')] = $hourly;
                                $db->daily = json_encode($daily_value);
                                $db->hourly_time = $hour;
                            }
                            $db->save();
                        }
                    }
                    Cache::forever('time_hour', $hour);
                    foreach ($result as $key => $value) {
                        $secondly_live[$key] = [$value];
                    }
                    Cache::forever('secondly_live', $secondly_live);
                }
                echo json_encode([
                        'status' => true,
                        'result' => $result
                    ]);
            }else{
                echo json_encode([
                        'status' => false
                    ]);
            }
        }else{
            echo json_encode([
                    'status' => false
                ]);
        }
    }
}
