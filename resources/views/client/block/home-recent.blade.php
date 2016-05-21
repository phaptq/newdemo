<div class="col-md-4 col-sm-6">
    <div class="table-responsive">
        <table class="table table-vcenter table-hover">
            <thead>
                <tr>
                    <th colspan="2">Thị trường thế giới</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mã</td>
                    <td>Chỉ số cuối</td>
                </tr>
                @if(!is_null($keys))
                    @foreach($keys as $key)
                        <tr class="hover-pointer">
                            <td class="key-{{$key}}">{!!$key!!}</td>
                            <td><span class="value-{{str_slug($key)}}">{{\Cache::has('live_data_value_'.$key)? \Cache::get('live_data_value_'.$key): 'n/a'}}</span></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var live = setInterval(function(){
            $.ajax({
            url: '{{route('get_real')}}',
            type: 'POST',
            dataType: 'json',
            data: {_token: '{{csrf_token()}}'},
        })
        .done(function(res) {
            $.each(res, function(index, value){
                var i = $('.value-'+index).text();
                $('.value-'+index).html(value);
            });
        });
        }, 4000);

    $('body').on('click', '.hover-pointer', function(){
        $('.hover-pointer').removeClass('visible');
        $(this).addClass('visible');
    });
})
</script>