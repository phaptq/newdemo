@extends('admin.master')

@section('content')
<?php $content = 'general_form'; ?>
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Trang bắt đầu</a></li>
    <li><a href="{{route('backend_post')}}">Biểu đồ</a></li>
</ul>
<div class="row">
    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title">
            <h2>Sửa biểu đồ <strong>{{$result->title}}</strong></h2>
        </div>
        <!-- END Table Styles Title -->
        <p>
            @if (Session::has('message'))
            {!! Session::get('message') !!}
            @endif
        </p>
        <?php $data = json_decode($result->data->data); ?>
        <div class="table-options clearfix"></div>
        <form action="{{ route('update_post', $result->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6">
                <div class="block" style="border: none;">
                    <div class="form-group">
                        <label class="control-label" for="example-email-input">Tên</label>
                        <div class="">
                            <input id="title" type="text" name="title" class="form-control" value="{{$result->title}}">
                            <span class="help-block">{!! $errors->first('title') !!}<?php echo Session::has('title_err')? Session::get('title_err'): ''; ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="example-email-input">Slug</label>
                        <div class="">
                            <input type="text" name="slug" class="form-control" value="{{$result->slug}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="example-email-input">Danh mục</label>
                        <div class="">
                            <select name="category_id" class="select-select2 form-control" data-placeholder="None">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$result->category_id == $category->id? 'selected': ''}}>{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="example-email-input">Cột thống kê tăng trưởng</label>
                        <div class="">
                            <select name="static" class="select-select2 form-control" data-placeholder="None">
                                <option></option>
                                @foreach($data as $key => $item)
                                    <option value="{{$key}}" {{$result->static == $key? 'selected': ''}}>{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block" style="border: none;">
                    <div class="form-group">
                        <label class="control-label" for="example-email-input">Seo title</label>
                        <div class="">
                            <input type="text" name="seo[title]" class="form-control" value="{{$result->title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="example-email-input">Seo keyword</label>
                        <div class="">
                            <input type="text" name="seo[keyword]" class="form-control" value="{{'bieu do '.$result->title}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="example-email-input">Mô tả, giới thiệu ngắn</label>
                        <div class="">
                            <textarea name="description" class="form-control" style="height: 100px;">{{$result->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-actions">
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <input type="reset" class="btn btn-danger" value="Làm lại">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
</script>
@stop