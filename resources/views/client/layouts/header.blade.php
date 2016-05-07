<header>
    <div class="container">
        <!-- Site Logo -->
        <a href="{{route('home')}}" class="site-logo">
            <i class="fa fa-line-chart fa-2"></i> <strong>GD</strong>viet
        </a>
        <!-- Site Logo -->

        <!-- Site Navigation -->
        <nav>
            <!-- Menu Toggle -->
            <!-- Toggles menu on small screens -->
            <a href="javascript:void(0)" class="btn btn-default site-menu-toggle visible-xs visible-sm">
                <i class="fa fa-bars"></i>
            </a>
            <!-- END Menu Toggle -->

            <!-- Main Menu -->
            <ul class="site-nav">
                <!-- Toggles menu on small screens -->
                <li class="visible-xs visible-sm">
                    <a href="javascript:void(0)" class="site-menu-toggle text-center">
                        <i class="fa fa-times"></i>
                    </a>
                </li>
                <!-- END Menu Toggle -->
                <li>
                    <a href="javascript:void(0)" class="site-nav-sub"><i class="fa fa-angle-down site-nav-arrow"></i>Lĩnh vực</a>
                    <ul>
                    <?php
                        // $minutes = 1;
                        // if (!\Cache::has('categories')) {
                        //     $categories = \App\Models\Category::whereNull('parent_id')->orderBy('order', 'asc')->get();
                        //     \Cache::put('categories', $categories, $minutes);
                        // }
                        // $categories = \Cache::get('categories');
                     ?>
                    @if(count($categories) > 0)
                        @foreach($categories as $key => $item)
                        <li>
                            <a href="{{route('category', $item->slug)}}">{{$item->title}}</a>
                        </li>
                        @endforeach
                    @endif
                    </ul>
                </li>
                <li>
                    <a href="{{route('article')}}">Tin Tức</a>
                </li>
                <li>
                    <a href="contact.html">Liên hệ</a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="site-nav-sub"><i class="fa fa-angle-down site-nav-arrow"></i>Trợ giúp</a>
                    <ul>
                        <li>
                            <a href="ecom_home.html">Đăng câu hỏi</a>
                        </li>
                        <li>
                            <a href="ecom_checkout.html">Về chúng tôi</a>
                        </li>
                    </ul>
                </li>
                @if(\Auth::check())
                    <li>
                        <a href="javascript:void(0)" class="site-nav-sub"><i class="fa fa-angle-down site-nav-arrow"></i><i class="gi gi-user"></i> {{\Auth::user()->name}}</a>
                        <ul>
                            <li>
                                <a href="{{ url('/logout') }}" title="Đăng xuất"><i class="gi gi-exit text-warning"></i> Đăng xuất</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ url('/login') }}" class="btn btn-primary">Đăng nhập</a>
                    </li>
                    <li>
                        <a href="{{ url('/register') }}" class="btn btn-success">Đăng ký</a>
                    </li>
                @endif
                @if(\Session::has('has_registed'))
                    <script type="text/javascript">
                        $(document).ready(function(){
                            alert('Bạn đã đăng ký thành công, vui lòng thực hiện đăng nhập để sử dụng chức năng cá nhân.');
                        });
                    </script>
                @endif
            </ul>
            <!-- END Main Menu -->
        </nav>
        <!-- END Site Navigation -->
    </div>
</header>