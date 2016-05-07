@extends('admin.master')

@section('content')
<link rel="stylesheet" href="{{ asset('themes/admin/css/fileuploader.css') }}">
<script src="{{asset('themes/admin/js/fileuploader.js')}}"></script>
<?php $content = 'general_form'; ?>
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Dashboard</a></li>
    <li><a href="{{route('backend_article')}}">Article</a></li>
</ul>
<div class="row">
    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title">
            <h2>Edit Article</h2>
        </div>
        <!-- END Table Styles Title -->
        <p>
            @if (Session::has('message'))
            {!! Session::get('message') !!}
            @endif
        </p>
        <div class="table-options clearfix"></div>
        <form action="{{ route('update_article', $result->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Title</label>
                    <div class="col-md-9">
                        <input type="text" id="title" name="title" class="form-control" placeholder="" value="<?php echo old('title')? old('title'): $result->title; ?>">
                        <span class="help-block">{!! $errors->first('title') !!}<?php echo Session::has('title_unique')? Session::get('title_unique'): ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Loại tin</label>
                    <div class="col-md-9">
                        <input type="text" value="{{$status_title[$result->status]}}" class="form-control" disabled />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Danh mục</label>
                    <div class="col-md-9">
                        <select style="width: 100%;" name="category_id" class="select-select2" data-placeholder="Choose one.." {{$result->status != 'new'? 'disabled': ''}}>
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$result->category_id == $category->id? 'selected': ''}}>{{$category->title}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{!! $errors->first('category_id') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-multiple-select">Online</label>
                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" <?php if(old('online')){echo (old('online')==null)? '':'checked';}else{ echo $result->online==1? 'checked': ''; } ?> name="online" value="1">
                            <span data-toggle="tooltip" title="" data-original-title="ON/OFF"></span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Tags</label>
                    <?php $tags = array_column($result->tags->toArray(), 'title'); ?>
                    <div class="col-md-9">
                        <input type="text" name="tag" class="form-control input-tags" placeholder="" value="<?php echo old('tag')? old('tag'): implode(',', $tags); ?>">
                        <span class="help-block">{!! $errors->first('tag') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Link ảnh đại diện</label>
                    <div class="col-md-9">
                        <input type="text" name="thumb" class="form-control" placeholder="" value="{{$result->thumb->link or ''}}">
                        <span class="help-block">{!! $errors->first('thumb') !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Slug</label>
                    <div class="col-md-9">
                        <input type="text" name="slug" class="form-control" placeholder="" value="<?php echo old('slug')? old('slug'): $result->slug; ?>">
                        <span class="help-block">{!! $errors->first('slug') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Seo - title</label>
                    <div class="col-md-9">
                        <input type="text" name="seo[title]" class="form-control" placeholder="" value="<?php echo old('seo')['title']? old('seo')['title']: json_decode($result->seo)->title; ?>">
                        <span class="help-block">{!! $errors->first('seo[title]') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Seo - keyword</label>
                    <div class="col-md-9">
                        <input type="text" name="seo[keyword]" class="form-control" placeholder="" value="<?php echo old('seo')['keyword']? old('seo')['keyword']: json_decode($result->seo)->keyword; ?>">
                        <span class="help-block">{!! $errors->first('seo[keyword]') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Description</label>
                    <div class="col-md-9">
                        <textarea style="height: 100px;" class="form-control" name="description"><?php echo old('description')? old('description'): $result->description; ?></textarea>
                        <span class="help-block">{!! $errors->first('description') !!}</span>
                    </div>
                </div>
            </div>
            <p class="clearfix"></p>
            <div class="form-group">
                <label class="control-label">Content</label>
                <div class="">
                    <textarea id="textarea-ckeditor" name="content" class="ckeditor"><?php echo old('content')? old('content'): $result->content; ?></textarea>
                    <span class="help-block">{!! $errors->first('content') !!}</span>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="text-center">
                    <input type="submit" name="save" class="btn btn-primary" value="Save">
                    <input type="submit" name="save_exit" class="btn btn-primary" value="Save &amp; Exit">
                    <input type="reset" class="btn btn-danger" value="Reset">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('[name="status"]').on('change', function(){
        if ($(this).val() != 'new') {
            $('[name="category_id"]').attr('disabled', 'disabled');
        }else{
            $('[name="category_id"]').removeAttr('disabled');
        }
    });
})
</script>
@stop