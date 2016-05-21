@extends('client.master')

@section('content')
<!-- Media Container -->
    @include('client.layouts.media-container')
<!-- END Media Container -->
<!-- Products -->
    <section class="site-content site-section">
        <div class="container">
            <div class="row">
                @include('client.block.left')
                <!-- END Sidebar -->

                <!-- Product Details -->
                <div class="col-sm-6 col-md-7 col-lg-8">
                    <div id="chart_area" class="row has-first" data-toggle="lightbox-gallery">
                        <p id="img-loading-1" style="display: none;" class="text-center"><img width="80" src="{{asset('themes/client/img/loading.svg')}}" alt="loading"></p>
                        <div id="container_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                    <div class="row has-first">
                        <p id="img-loading-2" style="display: none;" class="text-center"><img width="80" src="{{asset('themes/client/img/loading.svg')}}" alt="loading"></p>
                        <div id="live_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        <div class="btn-group btn-group-xs pull-right hide">
                            <a class="btn btn-default" href="javascript:void(0)">1D</a>
                            <a class="btn btn-default" href="javascript:void(0)">5D</a>
                            <a class="btn btn-default" href="javascript:void(0)">1M</a>
                            <a class="btn btn-default" href="javascript:void(0)">5M</a>
                            <a class="btn btn-default" href="javascript:void(0)">All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END Products -->
<script type="text/javascript">
$(document).ready(function(){
    /*Data*/
    var load_data = function(id, time){
        $('#container_chart').html('');
        $('#img-loading-1').show();
        $.ajax({
            url: '{{route('load_data')}}',
            type: 'POST',
            dataType: 'json',
            data: {_token: '{{csrf_token()}}', id: id, time: time},
        })
        .done(function(res) {
            console.log(res);
            var series = new Array();
            $.each(res.line, function(key, value){
                var data = new Array();
                $.each(value, function(index, str){
                    data.push( parseFloat(str));
                });
                series.push({
                    name: key,
                    type: 'spline',
                    yAxis: 0,
                    data: data
                });
            });
            if(res.bar != null){
                $.each(res.bar, function(key, value){
                    var data = new Array();
                    $.each(value, function(index, str){
                        data.push( parseFloat(str));
                    });
                    series.push({
                        name: key,
                        type: 'column',
                        yAxis: 1,
                        data: data
                    });
                });
            }
            var color = ['#FF9999', '#99FF99', '#90ed7d', '#f7a35c', '#8085e9',
                    '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'
            ];
            $('#container_chart').highcharts({
                chart: {
                    zoomType: 'xy',
                    events: {
                        load: function(event) {
                            $('#img-loading-1').hide();
                        }
                    },
                    backgroundColor: '#f9f9f2',
                },
                colors: color,
                title: {
                    text: res.title
                },
                subtitle: {
                    text: 'test data'
                },
                xAxis: [{
                    categories: res.labels,
                    crosshair: false
                }],
                yAxis: [{ // Primary yAxis
                    lineWidth: 1,
                    lineColor: "#C0D0E0",
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    title: {
                        text: '',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                }, { // Secondary yAxis
                    min: 0,
                    max: res.max * 2,
                    lineWidth: 1,
                    lineColor: "#C0D0E0",
                    title: {
                        text: '',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    opposite: true,
                }],
                tooltip: {
                    shared: false,
                },
                plotOptions: {
                    spline: {
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 3
                            }
                        },
                        marker: {
                            enabled: false
                        }
                    }
                },
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'top',
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
                series: series
            });

            $('[name="time"]').html(res.time);
        });
    };
    load_data($('[name="ticker"]').val(), 0);

    $('[name="ticker"]').change(function(){
        load_data($('[name="ticker"]').val(), 0);
    });

    $('[name="time"]').change(function(){
        var i = $('[name="ticker"]').val();
        load_data($('[name="ticker"]').val(), $('[name="time"]').val());
    });

    var live = setInterval(function(){
        $.ajax({
            url: '{{route('get_real')}}',
            type: 'POST',
            dataType: 'json',
            data: {_token: '{{csrf_token()}}'},
        })
        .done(function(res) {
            console.log(res);
            if(res.status){
                $.each(res.result, function(index, value){
                    var i = $('.value-'+index).text();
                    $('.value-'+index).html(value);
                });
            }
        });
        }, 4000);

    var load_live = function(slug, time){
        console.log(time);
        $('#live_chart').html('');
        $('#img-loading-2').show();
        $.ajax({
            url: '{{route('load_live')}}',
            type: 'POST',
            dataType: 'json',
            data: {_token: '{{csrf_token()}}', slug: slug, time: time},
        })
        .done(function(res) {
            console.log(res);
            var color = ['#FF9999', '#99FF99', '#90ed7d', '#f7a35c', '#8085e9',
                    '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'
            ];
            var line = new Array();
            $.each(res.line, function(index, str){
                line.push( parseFloat(str));
            });
            $('#live_chart').highcharts({
                chart: {
                    zoomType: 'xy',
                    events: {
                        load: function(event) {
                            $('#img-loading-2').hide();
                            $('.btn-group').removeClass('hide');
                        }
                    },
                    backgroundColor: '#f9f9f2',
                },
                colors: color,
                title: {
                    text: res.title
                },
                subtitle: {
                    text: 'test data'
                },
                xAxis: [{
                    categories: res.labels,
                    crosshair: false
                }],
                yAxis: [{ // Primary yAxis
                    lineWidth: 1,
                    lineColor: "#C0D0E0",
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    title: {
                        text: '',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                }],
                tooltip: {
                    shared: false,
                },
                plotOptions: {
                    spline: {
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 3
                            }
                        },
                        marker: {
                            enabled: false
                        }
                    }
                },
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'top',
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
                },
                series: [{
                    name: res.title,
                    type: 'spline',
                    yAxis: 0,
                    data: line
                }]
            });
        });
    };
    $('body').on('click', '.live-data', function(){
        var i = $(this);
        if($(this).hasClass('visible')){
            return false;
        }else{
            $('.live-data').removeClass('visible');
            $(this).addClass('visible');
            load_live(i.attr('key'), 'daily');
        }

    });
})
</script>
@stop