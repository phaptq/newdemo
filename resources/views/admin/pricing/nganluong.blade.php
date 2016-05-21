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
        <?php $data = json_decode($result->data); ?>
        <form action="{{ route('update_nganluong') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-8 col-md-offset-2">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">ID kết nối</label>
                    <div class="col-md-9">
                        <input type="text" name="MERCHANT_ID" class="form-control" placeholder="" value="{{$data->MERCHANT_ID}}">
                        <span class="help-block">{!! $errors->first('MERCHANT_ID') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Mật khẩu kết nối</label>
                    <div class="col-md-9">
                        <input type="text" name="MERCHANT_PASS" class="form-control" value="{{$data->MERCHANT_PASS}}">
                        <span class="help-block">{!! $errors->first('MERCHANT_PASS') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Email tài khoản ngân lượng</label>
                    <div class="col-md-9">
                        <input type="text" name="RECEIVER" class="form-control" value="{{$data->RECEIVER}}">
                        <span class="help-block">{!! $errors->first('RECEIVER') !!}</span>
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