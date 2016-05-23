@extends('admin.master')

@section('content')
<?php $content = 'general_form'; ?>
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Dashboard</a></li>
    <li><a href="{{route('backend_user')}}">Backend user</a></li>
</ul>
<!-- END Table Responsive Header -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <!-- Horizontal Form Block -->
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <div class="block-options pull-right">
                    <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">No Borders</a>
                </div>
                <h2><strong>Edit</strong> User</h2>
            </div>
            <!-- END Horizontal Form Title -->

            <!-- Horizontal Form Content -->
            <form action="{{route('frontend_user_update', $result->id)}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="col-md-3 control-label">User name</label>
                    <div class="col-md-9">
                        <span class="help-block">{{$result->name}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-hf-email">Email</label>
                    <div class="col-md-9">
                        <span class="help-block">{{$result->email}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Gia hạn</label>
                    <div class="col-md-9">
                        <input type="text" name="price_date" class="form-control" value="" placeholder="nhập số ngày hoặc để trống nếu không gia hạn" />
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="gi gi-up_arrow"></i> Submit</button>
                        <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                    </div>
                </div>
            </form>
            <!-- END Horizontal Form Content -->
        </div>
        <!-- END Horizontal Form Block -->
    </div>
</div>
@stop