@extends('admin.master')

@section('content')
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Dashboard</a></li>
</ul>
<!-- END Table Responsive Header -->

<!-- Responsive Full Block -->
<div class="block">
    <!-- Responsive Full Title -->
    <div class="block-title">
        <h2><strong>Manager</strong></h2>
        <div class="block-options pull-right">
            <a href="{{route('backend_user_create')}}" class="btn btn-primary">create user</a>
        </div>
    </div>
    <!-- END Responsive Full Title -->

    <!-- Responsive Full Content -->
    <p>
    @if(\Session::has('message'))
    {{\Session::get('message')}}
    @endif
    </p>
    <div class="table-responsive">
        <table class="table table-vcenter table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subscription</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($result->count() > 0)
                @foreach($result as $key => $item)
                <tr>
                    <td class="text-center">{{$item->id}}</td>
                    <td><a href="{{route('backend_user_edit', $item->id)}}">{{$item->name}}</a></td>
                    <td>{{$item->email}}</td>
                    <td><a href="javascript:void(0)" class="{{$item->group->style}}">{{$item->group->title}}</a></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="ON/OFF" class="btn btn-<?php echo $item->status==1? 'success': 'default'; ?>"><?php echo $item->status==1? 'ON': 'OFF'; ?></a>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a href="{{route('backend_user_edit', $item->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            <a href="{{route('backend_user_delete', $item->id)}}" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="return confirm('Xóa user này?');"><i class="fa fa-times"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="text-right">{!!$result->render()!!}</td>
                </tr>
                @else
                <tr>
                    <td colspan="6"><h3>Empty data</h3></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- END Responsive Full Content -->
</div>
<!-- END Responsive Full Block -->
@stop