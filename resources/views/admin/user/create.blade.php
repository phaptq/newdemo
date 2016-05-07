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
                <h2><strong>Create</strong> User</h2>
            </div>
            <!-- END Horizontal Form Title -->

            <!-- Horizontal Form Content -->
            <form action="{{route('backend_user_store')}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="col-md-3 control-label">User name</label>
                    <div class="col-md-9">
                        <input type="text" name="name" class="form-control" placeholder="Enter username" value="{{old('name')}}">
                        <span class="help-block">{{$errors->first('name')}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-hf-email">Email</label>
                    <div class="col-md-9">
                        <input type="email" id="example-hf-email" name="email" class="form-control" placeholder="Enter Email.." value="{{old('email')}}">
                        <span class="help-block">{{$errors->first('email')}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-hf-password">Password</label>
                    <div class="col-md-9">
                        <input type="password" id="example-hf-password" name="password" class="form-control" placeholder="Enter Password..">
                        <span class="help-block">{{$errors->first('password')}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-select">Group</label>
                    <div class="col-md-9">
                        <select id="example-select" name="group_id" class="form-control" size="1">
                            @foreach($groups as $key => $item)
                            <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Status</label>
                    <div class="col-md-9">
                        <label class="switch switch-primary" for="val_terms">
                        <input type="checkbox" id="val_terms" name="status" <?php echo (old('status') !=1)? '': 'checked'; ?> value="1">
                        <span data-toggle="tooltip" title="" data-original-title="ON/OFF"></span>
                        </label>
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