@extends('admin.master')

@section('content')
<?php $content = 'general_form'; ?>
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Dashboard</a></li>
</ul>
<div class="row">
    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title">
            <h2>Article image setting</h2>
        </div>
        <!-- END Table Styles Title -->
        <p>
            @if (Session::has('message'))
            {!! Session::get('message') !!}
            @endif
        </p>
        <div class="table-options clearfix"></div>
        <form action="{{ route('article_image_update') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $result->id or NULL }}">
            <input type="hidden" name="title" value="{{ $result->title or 'Article image' }}">
            <input type="hidden" name="type" value="{{ $result->type or 'image' }}">
            <input type="hidden" name="location" value="{{ $result->lacation or 'article' }}">
            <input type="hidden" name="status" value="{{ $result->status or 1 }}">
            <input type="hidden" name="data_type" value="{{ $result->data_type or 'json' }}">
            <p><h4 class="text-center">To system work corect: Pixel unit. Value must be digits or empty</h4></p>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label">Thumb - width</label>
                    <div class="col-md-3">
                        <input type="text" name="data[thumb][width]" class="form-control" placeholder="default" value="<?php echo isset($result->data)? json_decode($result->data)->thumb->width: ''; ?>">
                    </div>
                    <label class="col-md-3 control-label">Thumb - height</label>
                    <div class="col-md-3">
                        <input type="text" name="data[thumb][height]" class="form-control" placeholder="default" value="<?php echo isset($result->data)? json_decode($result->data)->thumb->height: ''; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label">content - width</label>
                    <div class="col-md-3">
                        <input type="text" name="data[content][width]" class="form-control" placeholder="default" value="<?php echo isset($result->data)? json_decode($result->data)->content->width: ''; ?>">
                    </div>
                    <label class="col-md-3 control-label">content - height</label>
                    <div class="col-md-3">
                        <input type="text" name="data[content][height]" class="form-control" placeholder="default" value="<?php echo isset($result->data)? json_decode($result->data)->content->height: ''; ?>">
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-actions">
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Save">
                    <input type="reset" class="btn btn-danger" value="Reset">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
</script>
@stop