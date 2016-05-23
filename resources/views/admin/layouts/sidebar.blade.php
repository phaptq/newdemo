<script type="text/javascript">
    $(document).ready(function () {
        $('.sidebar-item').each(function(){
            var str = $(location).attr('href');
            var n = str.indexOf($(this).attr('href'));
            if (n==0) {
                $(this).addClass('active');
                $(this).on('click', function(){
                    return false;
                });
            }
        });
        $('.sidebar-parrent').each(function(){
            if ($(this).find('.active').length>0) {
                $(this).addClass('active')
            }
        });
    });
</script>
<div id="sidebar">
    <!-- Wrapper for scrolling functionality -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Brand -->
            <a href="{{route('home')}}" class="sidebar-brand" target="_blank">
                <i class="gi gi-flash"></i><span class="sidebar-nav-mini-hide"><strong>TRANG CHỦ</strong></span>
            </a>
            <!-- END Brand -->

            <!-- User Info -->
            @include('admin/layouts.sidebar.user-info')
            <!-- END User Info -->

            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav">
                <li>
                    <a href="{{route('admin')}}" class="<?php echo \URL::current()==route('admin')? 'active':''; ?>"><i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                </li>
                <li class="sidebar-header">
                    <span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Quick Settings"><i class="gi gi-settings"></i></a></span>
                    <span class="sidebar-header-title">Pages</span>
                </li>
                <li class="sidebar-parrent">
                    <a href="#" class="sidebar-nav-menu">
                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                        <i class="gi gi-user sidebar-nav-icon"></i>
                        <span class="sidebar-nav-mini-hide">User</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('backend_user')}}" class="sidebar-item">Admin</a>
                        </li>
                        <li>
                            <a href="{{route('frontend_user')}}" class="sidebar-item">Khách hàng</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-parrent">
                    <a href="#" class="sidebar-nav-menu">
                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                        <i class="gi gi-cloud sidebar-nav-icon"></i>
                        <span class="sidebar-nav-mini-hide">Data tự động</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('live_data', 'markets-wsj-com')}}" class="sidebar-item">markets.wsj.com</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-parrent">
                    <a href="#" class="sidebar-nav-menu">
                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                        <i class="fa fa-cc-visa sidebar-nav-icon"></i>
                        <span class="sidebar-nav-mini-hide">Tích hợp TT</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('backend_ngan_luong')}}" class="sidebar-item">Ngân lượng</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('backend_pricing')}}" class="sidebar-item"><i class="fa fa-dollar sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Bảng giá</span></a>
                </li>
                <li>
                    <a href="{{route('backend_category')}}" class="sidebar-item"><i class="hi hi-folder-open sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Danh mục</span></a>
                </li>
                <li>
                    <a href="{{route('backend_post')}}" class="sidebar-item"><i class="fa fa-line-chart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Biểu đồ</span></a>
                </li>
                <li>
                    <a href="{{route('backend_article')}}" class="sidebar-item"><i class="fa fa-newspaper-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tin tức & thông báo</span></a>
                </li>
                <li class="sidebar-parrent">
                    <a href="#" class="sidebar-nav-menu">
                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                        <i class="gi gi-cogwheels sidebar-nav-icon"></i>
                        <span class="sidebar-nav-mini-hide">Setting</span>
                    </a>
                    <ul>
                        <li class="sidebar-parrent">
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- END Sidebar Navigation -->

            <!-- Sidebar Notifications -->
            <!-- END Sidebar Notifications -->
        </div>
        <!-- END Sidebar Content -->
    </div>
    <!-- END Wrapper for scrolling functionality -->
</div>