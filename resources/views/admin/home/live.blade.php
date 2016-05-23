@extends('admin.master')

@section('content')
<div class="row table-body">
</div>

<script type="text/javascript">
$(document).ready(function(){
    var live = setInterval(function(){
        $.ajax({
            url: '{{route('get_live_data')}}',
            type: 'POST',
            dataType: 'json',
            data: {_token: '{{csrf_token()}}'},
        })
        .done(function(res) {
            if(res.status){
                var table = '<table border="1">';
                $.each(res.result, function(index, value){
                    table += '<tr><td width="100">'+index+'</td><td>'+value+'</td></tr>';
                });
                table += '</table>';
                $('.table-body').html(table);
            }else{
                $('.table-body').html("<h3>Hết phiên giao dịch!</h3><br/>Giao dịch bắt đầu từ 20h đến 03h các ngày từ thứ 2 đến thứ 6 theo giờ Việt nam");
            }
        });
    }, 10000);
})
</script>
@stop