<div class="col-sm-4">
    <!-- Advanced Animated Gallery Widget -->
    <div class="widget">
        <div class="widget-advanced">
            <!-- Widget Header -->
            <div class="widget-header text-left">
                <!-- For best results use an image with at least 150 pixels in height (with the width relative to how big your widget will be!) - Here I'm using a 1200x150 pixels image -->
                <img src="{{asset('themes/client/img/stock_19.jpg')}}" alt="background" class="widget-background animation-pulseSlow">
                <h3 class="widget-content widget-content-image widget-content-light clearfix text-center">
                    <a href="{{route('category', 'xem-nhieu-nhat')}}" class="themed-color-default">Xu Hướng</a><br>
                    <small>Top {{$limit}}</small>
                </h3>
            </div>
            <!-- END Widget Header -->

            <!-- Widget Main -->
            <div class="widget-main">
                <a href="javascript:void(0)" class="widget-image-container animation-bigEntrance">
                    <span class="widget-icon themed-background-fancy"><i class="hi hi-heart-empty"></i></span>
                </a>
                <table class="table table-hover table-borderless table-striped table-condensed table-vcenter">
                    <tbody>
                        @if(count($viewed_posts) > 0)
                            @foreach($viewed_posts as $key => $item)
                            <tr>
                                <td style="width: 10px;">{{$key+1}}</td>
                                <td><a href="{{route('detail', ['cat' => $item->category->slug, 'slug'=> $item->slug])}}"><strong>{{$item->title}}</strong></a></td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-xs">
                                        <i class="gi gi-play"></i>
                                    </div>
                                    {{is_null($item->viewed)? 0: $item->viewed}}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="text-center"><a href="{{route('category', 'xem-nhieu-nhat')}}">Xem thêm..</a></div>
            </div>
            <!-- END Widget Main -->
        </div>
    </div>
    <!-- END Advanced Animated Gallery Widget -->
</div>