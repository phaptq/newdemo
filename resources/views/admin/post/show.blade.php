@extends('admin.master')

@section('content')
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Dashboard</a></li>
    <li><a href="{{route('backend_post')}}">Biểu đồ</a></li>
</ul>
<!-- END Table Responsive Header -->

<!-- Responsive Full Block -->
<div class="row">
    <div class="">
        <!-- Classic Chart Block -->
        <div class="block full" id="chart_area">
            <!-- Classic Chart Title -->
            <div class="block-title">
                <h2><strong>{{$result->title}}</strong> Chart</h2>
            </div>
            <!-- END Classic Chart Title -->
            <div id="container_chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

            <!-- END Classic Chart Content -->
        </div>
        <!-- END Classic Chart Block -->
    </div>
</div>
<?php
    $categories = json_decode($result->data->column, true);
    krsort($categories);
    foreach (json_decode($result->data->data) as $key => $value) {
        $group[$key] = (min($value)+max($value))/2;
        krsort($value);
        $data[$key] = $value;
    }
    $average  = array_sum($group) / count($group);
 ?>
<script type="text/javascript">
$(function () {
    $('#container_chart').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: '{{$result->title}}'
        },
        subtitle: {
            text: 'test data'
        },
        xAxis: [{
            categories: [{!!implode(',', array_values($categories))!!}],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
                min: 0,
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
            title: {
                text: '',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
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
                        lineWidth: 5
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
                    yAxis: 1,
                    data: [{!!implode(',', array_values($item))!!}]
                },
            <?php }else{ ?>
                 {
                    name: '{{$key}}',
                    type: 'spline',
                    data: [{!!implode(',', array_values($item))!!}]
                },
            <?php } } ?>
            ]
    });
});
</script>
@stop