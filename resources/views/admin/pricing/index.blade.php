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
        <h2><strong>Bản giá</strong></h2>
        <div class="block-options pull-right">
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
    <form action="{{ route('store_pricing') }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="table-responsive">
        <table class="table table-vcenter table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center"><small>Gói</small></th>
                    @foreach($plans as $key => $title)
                    <th class="">{{$key.' ngày'}}</th>
                    @endforeach
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($result->count() > 0)
                    @foreach($result as $key => $item)
                        <input type="hidden" name="id[{{$key+1}}]" value="{{$item->id}}" />
                        <tr class="row-data">
                            <td class="text-center"><input type="text" name="title[{{$key+1}}]" value="{{$item->title}}" class="form-control" /></td>
                            @foreach(json_decode($item->price) as $k => $price)
                            <td><input type="text" name="price[{{$key+1}}][{{$k}}]" value="{{$price}}" class="form-control" /></td>
                            @endforeach
                            <td class="text-center">
                                <input type="checkbox" {{$item->status == 1? 'checked': ''}} name="status[{{$key+1}}]" value="1" data-toggle="tooltip" title="" data-original-title="ON/OFF">
                                <a href="{{route('delete_pricing', $item->id)}}" onclick="return confirm('Press Ok to confirm!');" data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                <tr class="no-data-alert">
                    <td colspan="{{count($plans) + 2}}" align="center"><h3>Chưa có dữ liệu</h3></td>
                </tr>
                @endif
                <tr>
                    <td colspan="{{count($plans) + 2}}" align="right"><a href="javascript:void(0)" class="btn btn-primary add-row"><i class="fa fa-plus"></i></a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="form-group form-actions">
        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Save">
            <input type="reset" class="btn btn-danger" value="Reset">
        </div>
    </div>
    </form>
    <!-- END Responsive Full Content -->
</div>
<!-- END Responsive Full Block -->
<script type="text/javascript">
    $('body').on('click', '.add-row', function(){
        $('.no-data-alert').remove();
        var i = $('.row-data').length + 1;
        var html = '<tr class="row-data">';
            html += '<td><input type="text" name="title['+i+']" value="" class="form-control" /></td>'
        <?php foreach($plans as $key => $value){ ?>
            html += '<td><input type="text" name="price['+i+'][{{$key}}]" value="" class="form-control" /></td>';
        <?php } ?>
        html += '<td><a class="text-danger remove-new-row" href="javascript:void(0)"><i class="fa fa-times"></i></a></td>';
        html += '</tr>';
        $(this).parent().parent().before(html);
    });

    $('body').on('click', '.remove-new-row', function(){
        $(this).parent().parent().remove();
    });
</script>
@stop