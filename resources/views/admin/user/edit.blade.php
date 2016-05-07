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
            <form action="{{route('backend_user_update', $result->id)}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="col-md-3 control-label">User name</label>
                    <div class="col-md-9">
                        <input type="text" name="name" class="form-control" placeholder="Enter username" value="<?php echo old('name')? old('name'): $result->name; ?>">
                        <span class="help-block text-danger">{{$errors->first('name')}}<?php echo \Session::has('name_exist')? \Session::get('name_exist'): ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-hf-email">Email</label>
                    <div class="col-md-9">
                        <input type="email" id="example-hf-email" name="email" class="form-control" placeholder="Enter Email.." value="<?php echo old('email')? old('email'): $result->email; ?>">
                        <span class="help-block text-danger">{{$errors->first('email')}}<?php echo \Session::has('email_exist')? \Session::get('email_exist'): ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-hf-password">Password</label>
                    <div class="col-md-9">
                        <input type="password" id="example-hf-password" name="password" class="form-control" placeholder="Enter Password..">
                        <span class="help-block text-danger">{{$errors->first('password')}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-select">Group</label>
                    <div class="col-md-9">
                        <select id="example-select" name="group_id" class="form-control" size="1">
                            @foreach($groups as $key => $item)
                            <option value="{{$item->id}}" <?php if(old('group_id')){echo old('group_id')==$item->id? 'selected': '';}else{ echo $result->group_id==$item->id? 'selected': '';} ?>>{{$item->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Status</label>
                    <div class="col-md-9">
                        <label class="switch switch-primary" for="val_terms">
                        <input type="checkbox" id="val_terms" name="status" <?php if(old('group_id')){echo old('status')==1? 'checked': '';}else{ echo $result->status==1? 'checked': '';} ?> value="1">
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