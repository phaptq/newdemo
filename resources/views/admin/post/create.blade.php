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
            <h2>Thêm mới biểu đồ</h2>
        </div>
        <!-- END Table Styles Title -->
        <p>
            @if (Session::has('message'))
            {!! Session::get('message') !!}
            @endif
        </p>
        <div class="table-options clearfix"></div>
        <form action="{{ route('store_post') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label class="col-md-3 control-label" for="example-email-input">Danh mục</label>
                <div class="col-md-9">
                    <select style="width: 200px;" name="category_id" class="select-select2" data-placeholder="None">
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="example-email-input">Chọn file</label>
                <div class="col-md-9">
                    <input type="file" name="file[]" multiple accept=".csv, .xls, .doc, .docx">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="example-email-input">Chọn loại biểu đồ</label>
                <div class="col-md-9">
                    <select style="width: 100px;" name="type" class="select-select2" data-placeholder="Choose one..">
                        <option value="line">Đường</option>
                        <option value="bar"> Cột</option>
                        <option value="pie">Tròn</option>
                        <option value="area">Vùng</option>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-actions">
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Upload">
                    <input type="reset" class="btn btn-danger" value="Làm lại">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
</script>
@stop