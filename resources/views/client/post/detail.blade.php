@extends('client.master')

@section('content')
<!-- Intro -->
<section class="site-section site-section-light site-section-top themed-background-dark">
    <div class="container text-center">
        <h1 class="animation-slideDown"><strong>{{$result->title or ''}}</strong></h1>
    </div>
</section>
<!-- END Intro -->
<script src="{{asset('themes/client/js/highcharts.js')}}"></script>
<script src="{{asset('themes/client/js/exporting.js')}}"></script>
<!-- Product View -->
<section class="site-content site-section">
    <div class="container">
        <div class="row">
        @if(!is_null($result))
            <!-- Sidebar -->
            <?php
                $cate = json_decode($result->data->column, true);
                $cate_backup = $cate;
                $dt = \Carbon\Carbon::parse($cate[0]);
                    $time_key[] = $end_colume = end($cate_backup);
                    $time_key[] = date('Ymd', strtotime($dt->subDays(10))); $dt->addDays(10);
                    $time_key[] = date('Ymd', strtotime($dt->subMonths(1))); $dt->addMonths(1);
                    $time_key[] = date('Ymd', strtotime($dt->subMonths(2))); $dt->addMonths(2);
                    $time_key[] = date('Ymd', strtotime($dt->subMonths(3))); $dt->addMonths(3);
                    $time_key[] = date('Ymd', strtotime($dt->subMonths(6))); $dt->addMonths(6);
                    $time_key[] = date('Ymd', strtotime($dt->subYears(1))); $dt->addYears(1);
                    $time_key[] = date('Ymd', strtotime($dt->subYears(2))); $dt->addYears(2);
                    $time_key[] = date('Ymd', strtotime($dt->subYears(3))); $dt->addYears(3);
                    $time_key[] = date('Ymd', strtotime($dt->subYears(5))); $dt->addYears(5);
                $time_value = [
                    'từ đầu',
                    '10 ngày',
                    '1 tháng',
                    '2 tháng',
                    '3 tháng',
                    '6 tháng',
                    '1 năm',
                    '2 năm',
                    '3 năm',
                    '5 năm'
                    ];
                $time = array_combine($time_key, $time_value);
                foreach ($time as $key_time => $value_time) {
                    if ($key_time < $end_colume) {
                        unset($time[$key_time]);
                    }
                }
             ?>
            @include('client.post.block.left')
            <!-- END Sidebar -->

            <!-- Product Details -->
            <div class="col-md-8 col-lg-9">
                <div id="chart_area" class="row has-first" data-toggle="lightbox-gallery">
                    <div id="container_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            <!-- END Product Details -->
            @endif
        </div>
    </div>
</section>
<?php
    krsort($cate);
    foreach (json_decode($result->data->data) as $key => $value) {
        $max[$key] = max($value);
        $min[$key] = min($value);
        $group[$key] = ($min[$key]+$max[$key])/2;
        krsort($value);
        $data[$key] = $value;
    }
    $average  = array_sum($group) / count($group);
 ?>
<script type="text/javascript">
$(document).ready(function(){
    var color = ['#FF9999', '#99FF99', '#90ed7d', '#f7a35c', '#8085e9',
                    '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'
            ];
    $(function () {
        var chart = $('#container_chart').highcharts({
            chart: {
                zoomType: 'xy'
            },
            colors: color,
            title: {
                text: '{{$result->title}}'
            },
            subtitle: {
                text: 'test data'
            },
            xAxis: [{
                categories: [{!!implode(',', array_values($cate))!!}],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                min: 0,
                max: {{max($max)*2}},
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
                }
            }, { // Secondary yAxis
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
                opposite: true
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
            series: [
                <?php foreach ($data as $key => $item) { if ($group[$key] > $average) {?>
                    {
                        name: '{{$key}}',
                        type: 'column',
                        data: [{!!implode(',', array_values($item))!!}]
                    },
                <?php }else{ ?>
                     {
                        name: '{{$key}}',
                        type: 'spline',
                        yAxis: 1,
                        data: [{!!implode(',', array_values($item))!!}]
                    },
                <?php } } ?>
                ]
        });
    });
    $('[name="time"]').on('change', function(){
        var start_time = $('[name="time"]').val();
        $('#container_chart').remove();
        $('#chart_area').append('<div id="container_chart_second" style="min-width: 310px; height: 400px; margin: 0 auto"></div>');
        $.ajax({
            url: '{{ route('ajax_update_chart') }}',
            type: 'POST',
            data: {key: start_time, id: {{$result->id}}, _token: '{{ csrf_token() }}' },
            dataType: 'json',
            success: function(result){
                <?php foreach ($data as $key => $item) {?>
                    var {{$key}} = new Array();
                    $.each(result.{{$key}}, function(index, el) {
                        {{$key}}.push( parseFloat(el));
                    });
                    Array.max = function( array ){
                            return Math.max.apply( Math, array );
                        };
                    var max_column_array = [];
                    <?php if($group[$key] > $average){ ?>
                        max_column_array.push( parseFloat(Array.max({{$key}})));
                    <?php } ?>
                <?php } ?>
                var max_column = Array.max(max_column_array)*2;
                $(function () {
                    $('#container_chart_second').highcharts({
                        chart: {
                            zoomType: 'xy'
                        },
                        colors: color,
                        title: {
                            text: '{{$result->title}}'
                        },
                        subtitle: {
                            text: 'test data'
                        },
                        xAxis: [{
                            categories: result._labels,
                            crosshair: true
                        }],
                        yAxis: [{ // Primary yAxis
                            min: 0,
                            max: max_column,
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
                        series: [
                            <?php foreach ($data as $key => $item) {?>
                                {
                                    name: '{{$key}}',
                                    type: '{{$group[$key] > $average? 'column': 'spline'}}',
                                    yAxis: {{$group[$key] > $average? 0: 1}},
                                    data: {{$key}}
                                },
                            <?php } ?>
                            ]
                    });
                });
            }
        });
    });
});
</script>
<!-- END Product View -->
@stop