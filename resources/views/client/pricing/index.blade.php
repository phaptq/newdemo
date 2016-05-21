@extends('client.master')

@section('content')
<!-- Intro -->
<section class="site-section site-section-light site-section-top themed-background-dark">
    <div class="container">
        <h1 class="text-center animation-slideDown"><i class="fa fa-thumbs-up"></i> <strong>Bảng giá Dịch Vụ</strong></h1>
        <h2 class="h3 text-center animation-slideUp">Chọn loại hình thanh toán phù hợp tương ứng với từng gói</h2>
    </div>
</section>
<!-- END Intro -->

<!-- Plans -->
<section class="site-content site-section">
    <div class="container">
        <div class="site-block">
            <form action="{{route('check_out_pricing')}}" method="GET" accept-charset="utf-8">
                <div class="row block-center">
                    <table class="table table-borderless table-pricing animation-fadeIn">
                        <thead>
                            <tr>
                                <th>Hình thức</th>
                                @foreach($plans as $title)
                                <th class="table-featured">{{$title}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $price)
                            <?php $plan = json_decode($price->price); ?>
                            <tr>
                                <td><strong>{{$price->title}}</strong><br/></td>
                                @foreach($plan as $key => $vnd)
                                <td>
                                    <div class="radio">
                                        <label class="radio-lable" for="radio-{{$price->id.'-'.$key}}">
                                            <input type="radio" id="radio-{{$price->id.'-'.$key}}" name="price" value="{{json_encode([$price->id, $key])}}"> {{' '.number_format($vnd, 0, ',', '.').' đ'}}
                                        </label>
                                    </div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center action-group">
                    </div>
                </div>
            </form>
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
    var next = function(){
        $('.radio-lable').parent().parent().css('background-color', '#fff');
        $( "input:checked" ).parent().parent().parent().css('background-color', '#1BBAE1');
        if($( "input:checked" ).length > 0){
            $('.action-group').html('<button type="submit" class="btn btn-primary next-btn">Tiếp tục >></button>');
        }
    }
    $(window).on('load', next);
    $('body').on('change', '[name="price"]', next);
})
</script>
@stop