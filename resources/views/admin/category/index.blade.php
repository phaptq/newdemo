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
        <h2><strong>Category</strong></h2>
        <div class="block-options pull-right">
            <a href="{{route('create_category')}}" class="btn btn-primary">add new</a>
        </div>
    </div>
    <!-- END Responsive Full Title -->
    <div class="clearfix"></div>
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
                    <th>Title</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Online</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($result->count() > 0)
                    @foreach($result as $key => $item)
                        <tr>
                            <td class="text-center">{{$item->id}}</td>
                            <td><a href="{{route('edit_category', $item->id)}}">{!!'<b>'.$item->title.'</b>'!!}</a></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="javascript:void(0)" class="btn btn-default">{{$item->status}}</a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="ON/OFF" class="btn btn-<?php echo $item->online==1? 'success': 'default'; ?>"><?php echo $item->online==1? 'ON': 'OFF'; ?></a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="{{route('edit_category', $item->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('delete_category', $item->id)}}" onclick="return confirm('Press Ok to confirm!');" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        @if($item->items->count()>0)
                            @foreach($item->items as $value)
                            <tr>
                                <td class="text-center">{{$value->id}}</td>
                                <td>&nbsp;-&nbsp;</i>{{' '}}<a href="{{route('edit_category', $value->id)}}">{!!$value->title!!}</a></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        <a href="javascript:void(0)" class="btn btn-default">{{$value->status}}</a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        <a href="javascript:void(0)" data-toggle="tooltip" title="ON/OFF" class="btn btn-<?php echo $value->online==1? 'success': 'default'; ?>"><?php echo $item->online==1? 'ON': 'OFF'; ?></a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        <a href="{{route('edit_category', $value->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                        <a href="{{route('delete_category', $value->id)}}" onclick="return confirm('Press Ok to confirm!');" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    @endforeach
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
<script type="text/javascript">
    $('#searchSubmit').on('click', function(){
        $('[name="search"]').submit();
    });
</script>
@stop