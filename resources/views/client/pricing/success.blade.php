@extends('client.master')

@section('content')
<!-- Intro -->
<section class="site-section site-section-light site-section-top themed-background-dark">
    <div class="container">
        <h1 class="text-center animation-slideDown"><i class="fa fa-thumbs-up"></i> <strong>Trạng thái thanh toán</strong></h1>
        <h2 class="h3 text-center animation-slideUp"></h2>
    </div>
</section>
<!-- END Intro -->

<!-- Plans -->
<section class="site-content site-section">
    <div class="container">
        <div class="site-block">
            <div class="col-md-8 col-md-offset-3">
                <div class="clearfix has-error">
                    <span class="help-block">{{\Session::has('message')? \Session::get('message'): ''}}</span>
                </div>
                <div class="clearfix has-success">
                    <span class="help-block">{{\Session::has('message_success')? \Session::get('message_success'): ''}}</span>
                </div>
                <?php $buyer = json_decode($payment_cart->buyer); ?>
                <pre>
                    <H3 class="text-center">Thông tin thanh toán</H3>
                    <span><i>Tên: </i>{{$buyer->fullname}}</span><br/>
                    <span><i>Điện thoại: </i>{{$buyer->mobile}}</span><br/>
                    <span><i>Email: </i>{{$buyer->email}}</span><br/>
                    <span><i>Địa chỉ: </i>{{$buyer->address}}</span><br/>
                    <span><i>Số tiền: </i>{{number_format($payment_cart->total_amount, 2, ',', '.').' vnd'}}</span><br/>
                    <span><i>Nội dung: </i>{{'Gia hạn tài khoản gói '.$payment_cart->plan.' ngày.'}}</span><br/>
                    <span><i>Tài khoản của bạn được gia hạn đến: </i>{{date('H:i:s d/m/Y', $user->price_date)}}.</span><br/>
                    <span><i>Xin vui lòng đăng nhập lại để gia hạn có hiệu lực. Trân trọng cảm ơn!</i></span>
                </pre>
            </div>
        </div>
        <hr>
    </div>
</section>
<!-- END Plans -->

<!-- Testimonials -->
<section class="site-content site-section">
    <div class="container">
        <div id="testimonials-carousel" class="carousel slide carousel-html" data-ride="carousel" data-interval="4000">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#testimonials-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#testimonials-carousel" data-slide-to="1"></li>
                <li data-target="#testimonials-carousel" data-slide-to="2"></li>
            </ol>
            <!-- END Indicators -->

            <!-- Wrapper for slides -->
            <div class="carousel-inner text-center">
                <div class="active item">
                    <p>
                        Tiện lợi
                    </p>
                    <blockquote class="no-symbol">
                        <p>Hình thức Thanh toán phong phú và đa dạng!</p>
                    </blockquote>
                </div>
                <div class="item">
                    <p>
                        An toàn
                    </p>
                    <blockquote class="no-symbol">
                        <p>Giao dịch được đảm bảo, tài khoản bảo mật!</p>
                    </blockquote>
                </div>
                <div class="item">
                    <p>
                        Dịch vụ chất lượng cao
                    </p>
                    <blockquote class="no-symbol">
                        <p>Nội dung luôn cập nhật sớm nhất, đáp ứng được yêu cầu!</p>
                    </blockquote>
                </div>
            </div>
            <!-- END Wrapper for slides -->
        </div>
        <hr>
    </div>
</section>
<!-- END Testimonials -->
<script type="text/javascript">
$(document).ready(function(){
    $('input[name="option_payment"]').bind('click', function() {
        $('.list-content li').removeClass('active');
        $(this).parent().parent('li').addClass('active');
    });
})
</script>
@stop