@extends('client.master')

@section('content')
<!-- Intro -->
<section class="site-section site-section-light site-section-top themed-background-dark">
    <div class="container text-center">
        <h1 class="animation-slideDown"><strong>{{$result['title'] or ''}}</strong></h1>
    </div>
</section>
<!-- END Intro -->
<!-- Product View -->
<section class="site-content site-section">
    <div class="container">
        <div class="row">
            <div class="table-responsive">
                <table id="example-datatable" class="table table-vcenter table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Mã GD</th>
                            <th>Phiên GD</th>
                            <th>Chỉ số</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result['result'] as $key => $item)
                        <?php
                            $data = json_decode($item->data->data, true);
                            foreach ($data as $name => $value) {
                                $line[$key][$name] = [$value[0], $value[1]];
                            }
                        ?>
                        <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td><a href="{{route('detail', ['cat'=>$item->category->slug, 'slug'=>$item->slug])}}" class="label label-success">{{$item->data->ticker}}</a></td>
                            <td>{{date('d m Y', $item->order)}}</td>
                            <td>
                                @foreach($line[$key] as $name => $sline)
                                @if(in_array($name, ['Price', 'Volume']))
                                    {{$name.': '}}
                                    <div class="btn-group btn-group-xs">
                                        {{$line[$key][$name][0]}}
                                        <i class="fa fa-caret-{{$line[$key][$name][0]>$line[$key][$name][1]? 'up text-success': 'down text-danger'}}"></i>
                                    </div>
                                    <?php echo ($name == 'Price' and isset($line[$key]['Volume']))? ' | ': ''; ?>
                                @endif
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12 clearfix">
                <div class="dataTables_paginate paging_bootstrap pull-right">
                    {!!$result['result']->render()!!}
                </div>
            </div>
        </div>
    </div>
</section>
@stop