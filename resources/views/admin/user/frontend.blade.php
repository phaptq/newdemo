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
            <!-- <a href="{{route('backend_user_create')}}" class="btn btn-primary">create user</a> -->
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
                    <th class="text-center" width="120"><i class="gi gi-user"></i></th>
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
                    <td><a href="{{route('frontend_user_show', $item->id)}}">{{$item->name}}</a></td>
                    <td>{{$item->email}}</td>
                    <td>{!!$item->price_date < time()? '<span class="label label-default">Free</span>': '<span class="label label-success">Premium</span>'!!}</td>
                    <td class="text-center">{!!$item->price_date > time()? date('d-m-Y', $item->price_date): 'Hết hạn'!!}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a href="{{route('frontend_user_edit', $item->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            <a onclick="return confirm('Xóa user này?');" href="{{route('frontend_user_delete', $item->id)}}" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-times"></i></a>
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