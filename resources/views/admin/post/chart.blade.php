@extends('admin.master')

@section('content')
<?php $content = 'general_form'; ?>
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Trang bắt đầu</a></li>
    <li><a href="{{route('backend_post')}}">Biểu đồ</a></li>
</ul>
<div class="row">
    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title">
            <h2>Cập nhật biểu đồ <strong>{{$post->title}}</strong></h2>
        </div>
        <!-- END Table Styles Title -->
        <p>
            @if (Session::has('message'))
            {!! Session::get('message') !!}
            @endif
        </p>
        <div class="table-options clearfix"></div>
        <form action="{{ route('update_chart', $post->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="table-responsive">
                <?php $page = $i/$perpage;
                            $prev = $page-1; ?>
                <table class="table table-vcenter table-striped table-hover">
                    <thead>
                        <tr>
                            @foreach($result as $key => $item)
                            <th class="text-center">{{$key}}</th>
                            @endforeach
                        </tr>
                        @if($page == 1)
                        <tr>
                            <td colspan="{{count($result)}}"><button id="add_row" type="button" class="btn btn-success">Thêm hàng mới</button> Lưu ý: thêm mới theo thứ tự như trong danh sách bên dưới( Thứ tự tăng dần từ dưới lên).</td>
                        </tr>
                        @endif
                    </thead>
                    <tbody id="data_row">
                        <tr>
                            @foreach($result as $key => $item)
                            <?php $remove_btn = $item; ?>
                            <td class="text-center" style="min-width: 120px;">
                                @foreach($item as $k => $value)
                                    <input type="text" name="{{$key.'['.$k.']'}}" value="{{$value}}" class="form-control key-{{$k}}">
                                @endforeach
                            </td>
                            @endforeach
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="{{count($result)/2}}" class="text-left"><?php if($page > 1){ ?><a class="btn btn-success" href="{{route('edit_chart', $post->id)}}<?php echo $page>2? '?page='.$prev: ''; ?>"><i class="gi gi-chevron-left"></i> Mới hơn</a><?php } ?></td>
                            <td colspan="{{count($result)/2 +1}}" class="text-right"><?php if($i < $max_key-$perpage){ ?><a class="btn btn-success" href="{{route('edit_chart', $post->id)}}?page={{$page+1}}">Cũ hơn <i class="gi gi-chevron-right"></i></a><?php } ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-actions">
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <input type="reset" class="btn btn-danger" value="Làm lại">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('body').on('click', '#add_row', function(){
        var i = $('input').length;
        var row = '<tr class="new-'+i+'">';
        <?php foreach($result as $key => $item){ ?>
            row += '<td class="text-center" style="min-width: 120px;">'
            row += '<input name="{{'new['.$key.'][]'}}" class="form-control">'
            row += '</td>';
        <?php } ?>
        row += '<td width="10"><label class="form-control"><button key="new-'+i+'" class="delete-row" type="button"><i class="fa fa-times text-danger"></i></button></label></td>';
        row += '</tr>';
        $('#data_row').prepend(row);
    });

    $('body').on('click', '.delete-row', function(){
        var i = $(this).attr('key');
        $(this).remove();
        $('.'+i).remove();
    });
</script>
@stop