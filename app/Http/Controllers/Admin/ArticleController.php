<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use App\Models\Article;
use App\Models\Tags;
use App\Models\Category;
use App\Models\Image;

use Validator, Session, Redirect;



class ArticleController extends AdminController
{
    public function index()
    {
        if (isset($_GET['k']) and !is_null($_GET['k']) AND ($_GET['k'] != '')) {
            $keyword = $_GET['k'];
            if (!is_null($keyword) AND ($keyword != '')) {
                $result =  $result = Article::with(['thumb'])->where('title', 'like', "%$keyword%")->orderBy('id', 'desc')->paginate(20);
            }
        }else{
            $result = Article::with(['thumb'])->orderBy('id', 'desc')->paginate(20);
        }

        return view('admin.article.index', compact('result'));
    }

    function create(){
        $categories = Category::all();
        $status['about_us'] = Article::where('status', 'about_us')->first();
        $status['terms'] = Article::where('status', 'terms')->first();
        $status['contact'] = Article::where('status', 'contact')->first();
        $status['alert'] = Article::where('status', 'alert')->first();
        $status_title = ['about_us' => 'Về chúng tôi', 'terms' => 'Điều khoản thành viên', 'contact' => 'Liên hệ', 'alert' => 'Thông báo'];
        return view('admin.article.create', compact('categories', 'status', 'status_title'));
    }

    function store(Request $request){
        $data  = $request->all();
        $validator = Validator::make($data, [
            'title'       => 'required|max:255',
            'slug'        => 'required|max:255|unique:articles,slug',
            'content'     => 'required',
        ]);
        if ($validator->fails())
        {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->withErrors($validator);
        }else{
            $data['title_ascii'] = Str::ascii($data['title']);
            $data['seo']['description'] = $data['description'];
            $article = Article::create([
                'title'       => $data['title'],
                'title_ascii' => $data['title_ascii'],
                'slug'        => $data['slug'],
                'status'      => $data['status'],
                'category_id' => isset($data['category_id'])? $data['category_id']: NULL,
                'online'      => isset($data['online'])? 1: NULL,
                'content'     => $data['content'],
                'description' => $data['description'],
                'seo'         => json_encode($data['seo'])
                ]);
            // Thumb:
            if ($data['thumb'] != '') {
                $thumb = Image::create([
                     'item_id' => $article->id,
                     'item_type' => 'article',
                     'type'       => 'thumb',
                     'link'       => $data['thumb']
                    ]);
            }

            // Tags
            $tags = \Request::input('tag');
            if(\Request::input('tag') != ''){
                $tags = explode(',', trim($tags));
                $tags = array_map('trim', $tags);
                $tags = array_map('strtolower', $tags);
                $tag_ids = [];
                if (!empty($tags)) {
                    $tag_exist = Tags::whereIn('title', $tags)->get();
                    $tag_new_ids = [];
                    foreach ($tags as $key => $value) {
                        if ($tag_exist->where('title', $value)->isEmpty()) {
                            $tag = Tags::firstOrCreate([
                                'title'       => $value,
                                'title_ascii' => Str::ascii($value),
                                'slug'        => str_slug($value)
                            ]);
                            $tag_new_ids[] = $tag->id;
                        }
                    }
                    $tag_exist_ids = $tag_exist->toArray();
                    $tag_exist_ids = array_column($tag_exist_ids, 'id');
                    $tag_ids = array_merge($tag_exist_ids, $tag_new_ids);
                }
                if (!empty($tag_ids)) {
                    $article->tags()->sync($tag_ids);
                }
            }
            Session::flash('message', 'Added!');
            if (isset($data['save'])) return Redirect::route('edit_article', $article->id);
            if (isset($data['save_exit'])) return Redirect::route('backend_article');
        }
    }

    function edit($id){
        $categories = Category::all();
        $status_title = ['new' => 'Tin tức', 'about_us' => 'Về chúng tôi', 'terms' => 'Điều khoản thành viên', 'contact' => 'Liên hệ', 'alert' => 'Thông báo'];
        $result = Article::where('id', $id)->with(['thumb', 'images', 'tags'])->first();
        return view('admin.article.edit', compact('categories', 'status_title', 'result'));
    }

    function update($id, Request $request){
        $data  = $request->all();
        $article = Article::where('id', $id)->first();
        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'slug' => 'required|max:255'
        ]);
        $article_unique = Article::where('id', '<>', $id)->where('title', $data['title'])->first();
        if (!is_null($article_unique)) {
            Session::flash('title_unique', '<span style="color:red;"> Title is already exist</span>');
        }
        if ($validator->fails() or !is_null($article_unique))
        {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->withErrors($validator);
        }else{
            $data['title_ascii'] = Str::ascii($data['title']);
            $data['online'] = $data['online'] != 1? NULL: $data['online'];
            $slug_unique = Article::where('id','<>',$id)->where('slug', $data['slug'])->get();
            if (count($slug_unique) > 0) {
                $data['slug'] .= '-'.strtolower(str_random(5));
            }
            $data['seo']['description'] = $data['description'];
            $article->title       = $data['title'];
            $article->title_ascii = $data['title_ascii'];
            $article->slug        = $data['slug'];
            $article->category_id = $article->status=='new'? $data['category_id']: NULL;
            $article->online      = $data['online'];
            $article->seo         = json_encode($data['seo']);
            $article->description = $data['description'];
            $article->content     = $data['content'];
            $article->save();
            // Thumb:
            if ($data['thumb'] != '') {
                $thumb = Image::where(['item_id' => $article->id, 'item_type' => 'article', 'type' => 'thumb'])->first();
                if (is_null($thumb)) {
                    $thumb = Image::create([
                         'item_id' => $article->id,
                         'item_type' => 'article',
                         'type'       => 'thumb',
                         'link'       => $data['thumb']
                    ]);
                }else{
                    $thumb->link = $data['thumb'];
                    $thumb->save();
                }
            }
            // if (\Request::hasFile('thumb')) {
            //     if (!is_dir('data/uploads')) {
            //         mkdir('data/uploads', 0777);
            //     }
            //     $uploadDir = 'data/uploads/';
            //     $fileName = $data['thumb']->getClientOriginalName();
            //     $extension = $data['thumb']->getClientOriginalExtension();
            //     $allowedExtensions = array('jpeg', 'jpg', 'png', 'bmp', 'gif');
            //     $file_rename   = $data['slug'] . '-thumb-' . strtolower(str_random(5)) . '.' . $extension;
            //     if(in_array($extension, $allowedExtensions)){
            //         $data['thumb']->move($uploadDir, $fileName);
            //         @rename($uploadDir.$fileName, $uploadDir.$file_rename);
            //     }
            //     $thumb = $uploadDir.$file_rename;
            //     // Image crop thumb
            //     $setting = Setting::where(['type' => 'image', 'location' => 'article'])->first();
            //     $max_width = json_decode($setting->data)->thumb->width;
            //     $max_height = json_decode($setting->data)->thumb->height;
            //     if($max_width != '' and $max_height != ''){
            //         $width = img::make($thumb)->width();
            //         $height = img::make($thumb)->height();
            //         if ($width > $max_width or $height > $max_height) {
            //             if ($width/$height < $max_width/$max_height) {
            //                 $image = img::make($thumb)->resize($max_width, NULL, function ($constraint) {
            //                                                                 $constraint->aspectRatio();
            //                                                             })->save($thumb);
            //                 $image->crop($max_width, $max_height)->save($thumb);
            //                 $image_thumb = Server::uploadFtp($thumb, null, $data['server_id']);
            //             }else{
            //                 $image = img::make($thumb)->resize(NULL, $max_height, function ($constraint) {
            //                                                                 $constraint->aspectRatio();
            //                                                             })->save($thumb);
            //                 $image->crop($max_width, $max_height)->save($thumb);
            //                 $image_thumb = Server::uploadFtp($thumb, null, $data['server_id']);
            //             }
            //         }else{
            //             if ($width/$height < $max_width/$max_height) {
            //                 $image = img::make($thumb)->resize($max_width, NULL, function ($constraint) {
            //                                                                 $constraint->aspectRatio();
            //                                                             })->save($thumb);
            //                 $image->crop($width, $width)->save($thumb);
            //                 $image_thumb = Server::uploadFtp($thumb, null, $data['server_id']);
            //             }else{
            //                 $image = img::make($thumb)->resize(NULL, $max_height, function ($constraint) {
            //                                                                 $constraint->aspectRatio();
            //                                                             })->save($thumb);
            //                 $image->crop($height, $height)->save($thumb);
            //                 $image_thumb = Server::uploadFtp($thumb, null, $data['server_id']);
            //             }
            //         }
            //         @unlink($thumb);
            //         $thumb = Image::create([
            //          'item_id' => $article->id,
            //          'item_type' => 'article',
            //          'type'       => 'thumb',
            //          'server_id'  => $data['server_id'],
            //          'file_name'   => $file_rename,
            //          'link'       => $image_thumb
            //         ]);
            //     }
            // }
            // Tags
            $tags = \Request::input('tag');
            $tags = explode(',', trim($tags));
            $tags = array_map('trim', $tags);
            $tags = array_map('strtolower', $tags);
            $tag_ids = [];
            if (!empty($tags)) {
                $tag_exist = Tags::whereIn('title', $tags)->get();
                $tag_new_ids = [];
                foreach ($tags as $key => $value) {
                    if ($tag_exist->where('title', $value)->isEmpty()) {
                        $tag = Tags::firstOrCreate([
                            'title'       => $value,
                            'title_ascii' => Str::ascii($value),
                            'slug'        => str_slug($value)
                        ]);
                        $tag_new_ids[] = $tag->id;
                    }
                }
                $tag_exist_ids = $tag_exist->toArray();
                $tag_exist_ids = array_column($tag_exist_ids, 'id');
                $tag_ids = array_merge($tag_exist_ids, $tag_new_ids);
            }
            if (!empty($tag_ids)) {
                $article->tags()->sync($tag_ids);
            }
            Session::flash('message', 'Updated!');
            if (isset($data['save'])){
                return Redirect::back();
            }else{
                return Redirect::route('backend_article');
            }
        }
    }

    function upload(){
        try {
            $server   = \Request::input('server');
            $id_item   = \Request::input('id');
            $alias   = \Request::input('alias');
            $type   = \Request::input('type');

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
            if (isset($result['error'])) {
                die(htmlspecialchars(json_encode(array('success' => false, 'msg' => $result['error'])), ENT_NOQUOTES));
            }else{
                $result['status'] = true;
            }
            //File uploaded name
            $file_uploaded = $result['filename'];
            $file_rename   = $alias . '-content-' . uniqid() . '.' . $result['ext'];
            //Rename file after upload
            if (file_exists($file_rename)){
                @fclose($file_rename);
                @unlink($file_rename);
            }
            @rename($upload_path.$file_uploaded, $upload_path.$file_rename);

            $path = $upload_path.$file_rename;
            $image_link = Server::uploadFtp($path, null, $server);
            if ($image_link !== false) {
                @unlink($path);
                // Insert to image tables
                $image = Image::create([
                    'item_id'   => intval($id_item),
                    'item_type' =>'article',
                    'type'      => $type,
                    'server_id' => $server,
                    'file_name'  => $file_rename,
                    'link'      => $image_link,
                ]);

                $result['status'] = true;
                $result['link']   = $image_link;
                $result['id']     = $image->id;
            } else {
                $result['status'] = false;
            }
            echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        } catch (Exception $e){
            echo json_encode(array(
                'status' => false,
                'msg'    => $e->getMessage()
            ));
        }
    }

    function delete_image(){
        $id = \Request::input('id');
        $image = Image::find($id);
        if (is_null($image)) {
            return ['status' => false, 'msg' => 'image not found'];
        } else {
            $result = $image->delete();
            return ['status' => true];
        }
    }

    function change_status(){
       try {
            $id = \Request::input('id');
            $article = Article::where('id', $id)->first();
            if($article->status == 1){
                $article->status = 0;
            }else{
                $article->status = 1;
            }
            $article->save();
            echo htmlspecialchars(json_encode(['status' => true, 'value' => $article->status]), ENT_NOQUOTES);
        } catch (Exception $e){
            echo json_encode(array(
                'status' => false,
                'msg'    => $e->getMessage()
            ));
        }
    }

    function delete($id){
        $article = Article::find($id);
        $article->delete();
        Session::flash('message', 'Deleted!');
        return Redirect::back();
    }

}
