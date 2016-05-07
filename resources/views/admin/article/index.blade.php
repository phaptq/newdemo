@extends('admin.master')

@section('content')
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Trang bắt đầu</a></li>
</ul>
<!-- END Table Responsive Header -->

<!-- Responsive Full Block -->
<div class="block">
    <!-- Responsive Full Title -->
    <div class="block-title">
        <h2><strong>Thông báo</strong></h2>
        <div class="block-options pull-right">
            <a href="{{route('create_article')}}" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <!-- END Responsive Full Title -->
    <div class="col-md-6 col-sm-6">
        @if(isset($_GET['k']))
        <a href="{{route('backend_article')}}" class="btn btn-primary">Về danh sách</a>
        @endif
    </div>
    <div class="col-md-6 col-sm-6 pull-right no-padding">
        <form name="search" action="{{ route('backend_article') }}" method="get" enctype="multipart/form-data" class="form-horizontal">
            <div id="example-datatable_filter" class="dataTables_filter">
                <div class="input-group">
                    <input type="search" name="k" value="<?php echo isset($_GET['k'])? $_GET['k']:''; ?>" class="form-control" placeholder="Search" aria-controls="example-datatable">
                    <span class="input-group-addon btn" id="searchSubmit"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </form>
    </div>
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
                    <td><a href="{{route('edit_article', $item->id)}}">{{$item->title}}</a></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="ON/OFF" class="btn btn-default">{{$item->status}}</a>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="ON/OFF" class="btn btn-<?php echo $item->online==1? 'success': 'default'; ?>"><?php echo $item->online==1? 'ON': 'OFF'; ?></a>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a href="{{route('edit_article', $item->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            <a href="{{route('delete_article', $item->id)}}" onclick="return confirm('Press Ok to confirm!');" data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-times"></i></a>
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
<script type="text/javascript">
    $('#searchSubmit').on('click', function(){
        $('[name="search"]').submit();
    });
</script>
@stop