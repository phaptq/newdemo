<div class="col-md-4 col-lg-3">
    <aside class="sidebar site-block">
        <!-- Store Menu -->
        <!-- Store Menu functionality is initialized in js/app.js -->
        <div class="sidebar-block">
            <ul class="store-menu">
                @foreach($categories as $category)
                    @if($result->category_id != $category->id)
                        <li><a href="javascript:void(0)">{{$category->title}}</a></li>
                    @else
                        <li class="open">
                            <a href="javascript:void(0)" class="submenu"><i class="fa fa-angle-right"></i> {{$category->title}}</a>
                            <ul>
                                <li><a href="{{route('category', $category->slug)}}">Các biểu đồ khác</a></li>
                                <li class="open">
                                    <a href="javascript:void(0)" class="submenu"><i class="fa fa-angle-right"></i> {{$result->title}}</a>
                                    <ul>
                                        <li>
                                            <span>
                                                Chọn số liệu:
                                                <select name="time">
                                                    @foreach($time as $key => $value)
                                                    <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        <!-- END Store Menu -->

        <!-- Shopping Cart -->
        <div class="sidebar-block">
            <div class="row">
                <div class="col-xs-6 push-bit">
                    <span class="h3"><small>Cập nhật<em> {{date('Y.m.d H:i:s', $result->order)}}</em></small></span>
                </div>
                @if(\Auth::check())
                <div class="col-xs-6">
                    <a href="ecom_shopping_cart.php" class="btn btn-sm btn-block btn-success">VIEW CART</a>
                    <a href="ecom_checkout.php" class="btn btn-sm btn-block btn-danger">CHECKOUT</a>
                </div>
                @endif
            </div>
        </div>
        <!-- END Shopping Cart -->
    </aside>
</div>