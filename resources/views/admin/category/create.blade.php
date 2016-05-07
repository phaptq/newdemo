@extends('admin.master')

@section('content')
<?php $content = 'general_form'; ?>
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Dashboard</a></li>
    <li><a href="{{route('backend_category')}}">Category</a></li>
</ul>
<div class="row">
    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title">
            <h2>Create Category</h2>
        </div>
        <!-- END Table Styles Title -->
        <p>
            @if (Session::has('message'))
            {!! Session::get('message') !!}
            @endif
        </p>
        <div class="table-options clearfix"></div>
        <form action="{{ route('store_category') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Title</label>
                    <div class="col-md-9">
                        <input type="text" id="title" name="title" class="form-control" placeholder="" value="{{ old('title') }}">
                        <span class="help-block">{!! $errors->first('title') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Parent</label>
                    <div class="col-md-9">
                        <select style="width: 100%;" name="parent_id" class="select-select2" data-placeholder="None">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach($parents as $parent)
                            <option value="{{$parent->id}}">{{$parent->title}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{!! $errors->first('status') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Status</label>
                    <div class="col-md-9">
                        <select style="width: 100%;" name="status" class="select-select2" data-placeholder="Choose one..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            <option value="hidden">Hidden</option>
                            <option value="highlight">Highlight</option>
                        </select>
                        <span class="help-block">{!! $errors->first('status') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-multiple-select">Online</label>
                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" checked name="online" value="1">
                            <span data-toggle="tooltip" title="" data-original-title="ON/OFF"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Order</label>
                    <div class="col-md-9">
                        <input type="text" name="order" class="form-control" placeholder="Digits value" value="{{ old('order') }}">
                        <span class="help-block">{!! $errors->first('order') !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Slug</label>
                    <div class="col-md-9">
                        <input type="text" name="slug" class="form-control" placeholder="" value="{{ old('slug') }}">
                        <span class="help-block">{!! $errors->first('slug') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Seo - title</label>
                    <div class="col-md-9">
                        <input type="text" name="seo[title]" class="form-control" placeholder="" value="{{ old('seo')['title'] }}">
                        <span class="help-block">{!! $errors->first('seo[title]') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Seo - keyword</label>
                    <div class="col-md-9">
                        <input type="text" name="seo[keyword]" class="form-control" placeholder="" value="{{ old('seo')['keyword'] }}">
                        <span class="help-block">{!! $errors->first('seo[keyword]') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Description</label>
                    <div class="col-md-9">
                        <textarea style="height: 100px;" class="form-control" name="description">{{ old('description') }}</textarea>
                        <span class="help-block">{!! $errors->first('description') !!}</span>
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