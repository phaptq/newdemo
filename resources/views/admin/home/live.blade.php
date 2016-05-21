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
            var table = '<table border="1">';
            $.each(res.result, function(index, value){
                table += '<tr><td width="100">'+index+'</td><td>'+value+'</td></tr>';
            });
            table += '</table>';
            $('.table-body').html(table);
        });
    }, 10000);
})
</script>
@stop