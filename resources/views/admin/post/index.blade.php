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
        <h2><strong>Biểu đồ</strong></h2>
        <div class="block-options pull-right">
            <a href="{{route('create_post')}}" class="btn btn-primary">Thêm mới</a>
        </div>
    </div>
    <!-- END Responsive Full Title -->

    <div class="col-md-6 col-sm-6">
        @if(isset($_GET['k']))
        <a href="{{route('backend_post')}}" class="btn btn-primary">Trở về danh sách</a>
        @endif
    </div>
    <div class="col-md-6 col-sm-6 pull-right no-padding">
        <form name="search" action="{{ route('backend_post') }}" method="get" enctype="multipart/form-data" class="form-horizontal">
            <div id="example-datatable_filter" class="dataTables_filter">
                <div class="input-group">
                    <input type="search" name="k" value="<?php echo isset($_GET['k'])? $_GET['k']:''; ?>" class="form-control" placeholder="Tìm kiếm" aria-controls="example-datatable">
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
                    <th>Tên</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Tùy chọn</th>
                </tr>
            </thead>
            <tbody>
                @if($result->count() > 0)
                    @foreach($result as $key => $item)
                        <tr>
                            <td class="text-center">{{$item->id}}</td>
                            <td><a href="{{route('show_post', $item->id)}}">{!!'<b>'.$item->title.'</b>'!!}</a></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="javascript:void(0)" class="btn btn-default">{{$item->status}}</a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="{{route('update_chart', $item->id)}}" class="btn btn-success">Cập nhật số liệu</a>
                                    <a href="{{route('edit_post', $item->id)}}" data-toggle="tooltip" title="Sửa" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('delete_post', $item->id)}}" onclick="return confirm('Click Ok để xóa!');" data-toggle="tooltip" title="Xóa" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="6"><h3>Chưa có dữ liệu</h3></td>
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