<div class="col-sm-4">
    <!-- Advanced Animated Gallery Widget 2 -->
    <div class="widget">
        <div class="widget-advanced">
            <!-- Widget Header -->
            <div class="widget-header text-left">
                <!-- For best results use an image with at least 150 pixels in height (with the width relative to how big your widget will be!) - Here I'm using a 1200x150 pixels image -->
                <img src="{{asset('themes/client/img/stock_6.jpg')}}" alt="background" class="widget-background animation-pulseSlow">
                <h3 class="widget-content widget-content-image widget-content-light clearfix text-right">
                    <a href="javascript:void(0)" class="themed-color-default">Thống Kê Trong Ngày</a><br>
                    <small></small>
                </h3>
            </div>
            <!-- END Widget Header -->

            <!-- Widget Main -->
            <div class="widget-main">
                <a href="javascript:void(0)" class="widget-image-container animation-bigEntrance">
                    <span class="widget-icon themed-background-night"><i class="fa fa-line-chart"></i></span>
                </a>
                <table style="height: 10px;" class="table table-hover table-borderless table-striped table-condensed table-vcenter table-responsive">
                    <tbody id="slide_up">
                        @if(count($statics) > 0)
                            @foreach($statics as $k => $datas)
                                @foreach($datas as $key => $item)
                                <tr class="slide_up_{{$k}}" <?php if($k>0){ echo 'style="display: none;"';} ?>>
                                    <td style="width: 10px;">{{$key}}</td>
                                    @foreach($item as $name => $value)
                                        <td class="text-right">
                                            <a href="javascript:void(0)"><strong>{{$name}}</strong></a>
                                            <div class="btn-group btn-group-xs">
                                                {{$value[0]}}
                                                <i class="fa fa-caret-{{$value[0]>$value[1]? 'up text-success': 'down text-danger'}}"></i>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if(count($statics) > 5)
                <div class="col-xs-6 text-left"><button type="button" class="btn btn-sm btn-success" id="prev_btn"><i class="fa fa-angle-left"></i> PREV</button></div>
                <div class="col-xs-6 text-right"><button type="button" class="btn btn-sm btn-success" id="next_btn">NEXT<i class="fa fa-angle-right"></i></button></div>
                @endif
                <script type="text/javascript">
                    $(document).ready(function(){
                        var j = {{count($statics)}} - 1;
                        if (j>0) {
                            var i = 0;
                            var interval = setInterval(function(){
                                if(i<j){
                                    $('.slide_up_'+i).hide();
                                    i++;
                                    $('.slide_up_'+i).slideDown('slow');
                                }else{
                                    setTimeout(function(){
                                        $('.slide_up_'+i).hide();
                                        $('.slide_up_0').slideDown('slow');
                                        i = 0;
                                    }, 5000);
                                }
                            }, 5000);
                            $('body').on('click', '#next_btn', function(){
                                clearInterval(interval);
                                if(i<j){
                                    $('.slide_up_'+i).hide();
                                    i++;
                                    $('.slide_up_'+i).slideDown('slow');
                                }else{
                                    $('.slide_up_'+i).hide();
                                    $('.slide_up_0').slideDown('slow');
                                    i = 0;
                                }
                                interval = setInterval(function(){
                                    if(i<j){
                                        $('.slide_up_'+i).hide();
                                        i++;
                                        $('.slide_up_'+i).slideDown('slow');
                                    }else{
                                        setTimeout(function(){
                                            $('.slide_up_'+i).hide();
                                            $('.slide_up_0').slideDown('slow');
                                            i = 0;
                                        }, 5000);
                                    }
                                }, 5000);
                            });
                            $('body').on('click', '#prev_btn', function(){
                                clearInterval(interval);
                                if(i>0){
                                    $('.slide_up_'+i).hide();
                                    i--;
                                    $('.slide_up_'+i).slideDown('slow');
                                }else{
                                    $('.slide_up_'+i).hide();
                                    $('.slide_up_'+j).slideDown('slow');
                                    i = j;
                                }
                                interval = setInterval(function(){
                                    if(i<j){
                                        $('.slide_up_'+i).hide();
                                        i++;
                                        $('.slide_up_'+i).slideDown('slow');
                                    }else{
                                        setTimeout(function(){
                                            $('.slide_up_'+i).hide();
                                            $('.slide_up_0').slideDown('slow');
                                            i = 0;
                                        }, 5000);
                                    }
                                }, 5000);
                            });
                        }
                    })
                </script>
            </div>
            <!-- END Widget Main -->
        </div>
    </div>
    <!-- END Advanced Animated Gallery Widget 2 -->
</div>