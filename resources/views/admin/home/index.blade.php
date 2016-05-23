@extends('admin.master')

@section('content')
<?php $content = 'dashboard'; ?>
<div class="content-header content-header-media">
    <div class="header-section">
        <div class="row">
            <!-- Main Title (hidden on small devices for the statistics to fit) -->
            <div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
                <h1>Xin chào <strong>{{Session::get('admin')->name}}</strong><br><small></small></h1>
            </div>
            <!-- END Main Title -->

            <!-- Top Stats -->
            <div class="col-md-8 col-lg-6">
                <div class="row text-center">
                    <div class="col-xs-4 col-sm-4">
                        <h2 class="animation-hatch">
                            <strong>{{\App\Models\User::count()}}</strong><br>
                            <small><i class="fa fa-user"></i> Thành viên</small>
                        </h2>
                    </div>
                    <div class="col-xs-4 col-sm-4">
                        <h2 class="animation-hatch">
                            <strong>{{\App\Models\Payment_cart::count()}}</strong><br>
                            <small><i class="fa fa-heart-o"></i> Hóa đơn</small>
                        </h2>
                    </div>
                    <div class="col-xs-4 col-sm-4">
                        <h2 class="animation-hatch">
                            <strong>{{\App\Models\Post::count() + \App\Models\Live_data::count()}}</strong><br>
                            <small><i class="fa fa-calendar-o"></i> Dữ liệu</small>
                        </h2>
                    </div>
                    <!-- We hide the last stat to fit the other 3 on small devices -->
                </div>
            </div>
            <!-- END Top Stats -->
        </div>
    </div>
    <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
</div>
<div class="row">
    <!-- Web Server Block -->
    <div class="block full">
        <!-- Web Server Title -->
        <div class="block-title">
            <h2><strong>Lịch sử giao dịch</strong></h2>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>User</th>
                        <th>Hình thức</th>
                        <th>Số ngày</th>
                        <th>Số tiền</th>
                        <th>Thời điểm</th>
                    </tr>
                </thead>
                <tbody>
                    @if($payment->count() > 0)
                    @foreach($payment as $key => $item)
                    <tr>
                        <td class="text-center">{{$item->id}}</td>
                        <td><a href="javascript:void(0)">{{$item->user->email}}</a></td>
                        <td>{{$item->plan->title or 'Admin set'}}</td>
                        <td>{{$item->plan}}</td>
                        <td>{{number_format($item->total_amount, 0, ',', '.').' đ'}}</td>
                        <td>{{$item->created_at}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" class="text-right">{!!$payment->render()!!}</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="6"><h3>Empty data</h3></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Web Server Block -->
</div>
@stop