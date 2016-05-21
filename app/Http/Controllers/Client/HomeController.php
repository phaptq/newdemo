<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Models\Post;
use App\Models\Article;
use App\Models\Post_data;
use App\Models\Category;
use App\Models\Live_data;

use Session, Auth, Validator, Cache;

class HomeController extends ClientController
{
    function index(Request $request){
        if(!Cache::has('categories_with_posts')){
            $categories = Category::with('posts')->get();
            Cache::put('categories_with_posts', $categories, env('CACHE_TIME'));
        }
        $categories = Cache::get('categories_with_posts');
        $live = Live_data::select(['title', 'slug'])->get();
        $keys = $live->toArray();
        $live_key = $live->pluck('title')->toArray();
        return view('client.home.index', compact('keys', 'categories', 'live_key'));
    }
    function live(){
        if(Cache::has('live_data')){
            $live_data = Cache::get('live_data');
            foreach ($live_data as $key => $value) {
                $result[str_slug($key)] = $value;
            }
            $status = true;
        }else{
            $status = false;
            $result = null;
        }
        echo json_encode([
                'status' => $status,
                'result' => $result
            ]);
    }

    function load_data(Request $request){
        $ajax = $request->all();
        $data = Post_data::where('post_id', $ajax['id'])->first();
        $date = json_decode($data->column, true);
        if(!Cache::has('time_step_'.$data->id)){
            $start_time = end($date);
            $dt = \Carbon\Carbon::parse($date[0]);
            $time_key[] = date('Ymd', strtotime($dt->subMonths(6))); $dt->addMonths(6);
            $time_key[] = date('Ymd', strtotime($dt->subDays(10))); $dt->addDays(10);
            $time_key[] = date('Ymd', strtotime($dt->subMonths(1))); $dt->addMonths(1);
            $time_key[] = date('Ymd', strtotime($dt->subMonths(2))); $dt->addMonths(2);
            $time_key[] = date('Ymd', strtotime($dt->subMonths(3))); $dt->addMonths(3);
            $time_key[] = date('Ymd', strtotime($dt->subYears(1))); $dt->addYears(1);
            $time_key[] = date('Ymd', strtotime($dt->subYears(2))); $dt->addYears(2);
            $time_key[] = date('Ymd', strtotime($dt->subYears(3))); $dt->addYears(3);
            $time_key[] = date('Ymd', strtotime($dt->subYears(5))); $dt->addYears(5);
            $time_value = [
                '6 tháng',
                '10 ngày',
                '1 tháng',
                '2 tháng',
                '3 tháng',
                '1 năm',
                '2 năm',
                '3 năm',
                '5 năm',
            ];
            $time = array_combine($time_key, $time_value);
            $time[$start_time] = 'Từ đầu';
            $html_time = '';
            foreach ($time as $key_time => $value_time) {
                if ($key_time > $start_time or $key_time == $start_time) {
                    $html_time .= '<option value="'.$key_time.'">'.$value_time.'</option>';
                }else{
                    unset($time[$key_time]);
                }
            }
            Cache::put('time_arr_'.$data->id, $time, env('CACHE_TIME'));
            Cache::put('time_step_'.$data->id, $html_time, env('CACHE_TIME'));
        }

        if($ajax['time'] == '0'){
            if(array_search('6 tháng', Cache::get('time_arr_'.$data->id)) == NULL){
                $key = 0;
            }else{
                $key = array_search('6 tháng', Cache::get('time_arr_'.$data->id));
            }
        }else{
            $key = $ajax['time'];
        }

        $column = json_decode($data->column, true);
        $label_data = json_decode($data->data);
        if($key == 0){
            $labels = $column;
            foreach($label_data as $label => $item){
                krsort($item);
                $datasets[$label] = array_values($item);
            }
        }else{
            foreach ($column as $k => $value) {
                if ($value >= $key) {
                    $res_key = $k;
                }
            }
            array_splice($column, $res_key);
            $labels = $column;
            foreach($label_data as $label => $item){
                $arr = array_splice($item, $res_key);
                krsort($item);
                $datasets[$label] = array_values($item);
            }
        }
        sort($labels);
        $select_time = Cache::get('time_step_'.$data->id);
        $select_time = str_replace('value="'.$key.'"', 'value="'.$key.'" selected', $select_time);
        if(count($datasets)>1){
            foreach ($datasets as $key => $value) {
                if(max($value) > 0){
                    $max[$key] = max($value);
                    $min[$key] = min($value);
                }
            }
            $max_value = max(array_values($max));
            $min_value = min(array_values($max));
            foreach ($datasets as $key => $value) {
                if(isset($max[$key]) and $max[$key] > ($min_value*10)){
                    $col_data[$key] = $datasets[$key];
                }else{
                    $line_data[$key] = $datasets[$key];
                }
            }
            echo json_encode([
                    'bar' => $col_data,
                    'line' => $line_data,
                    'labels' => $labels,
                    'title' => $data->ticker,
                    'max' => $max_value,
                    'time' => $select_time
                ]);
        }else{
            echo json_encode([
                'bar' => null,
                'line' => $datasets,
                'labels' => $labels,
                'title' => $data->ticker,
                'time' => $select_time
            ]);
        }
    }

    function load_live(Request $request){
        $data = $request->all();

        if($data['time'] == 'all'){
            $live = Live_data::where('slug', $data['slug'])->first();
            $all = json_decode($live->data, true);
            $labels = array_keys($all);
            $line = array_values($all);
        }elseif($data['time'] = 'daily'){
            $live = Live_data::where('slug', $data['slug'])->first();
            $all = json_decode($live->daily, true);
            $labels = array_keys($all);
            $line = array_values($all);
        }
        echo json_encode([
                'status' => true,
                'labels' => $labels,
                'line' => $line,
                'title' => $live->title,
                'time' => $data['time']
            ]);
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