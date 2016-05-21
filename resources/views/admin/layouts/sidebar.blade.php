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
            <a href="{{route('admin')}}" class="sidebar-brand" target="_blank">
                <i class="gi gi-flash"></i><span class="sidebar-nav-mini-hide"><strong>FRONTEND</strong></span>
            </a>
            <!-- END Brand -->

            <!-- User Info -->
            @include('admin/layouts.sidebar.user-info')
            <!-- END User Info -->

            <!-- Theme Colors -->
            <!-- Change Color Theme functionality can be found in js/app.js - templateOptions() -->
            @include('admin/layouts.sidebar.theme-color')
            <!-- END Theme Colors -->

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
                            <a href="{{route('backend_user')}}" class="sidebar-item">Backend</a>
                        </li>
                        <li>
                            <a href="{{route('frontend_user')}}" class="sidebar-item">Frontend</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-parrent">
                    <a href="#" class="sidebar-nav-menu">
                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                        <i class="gi gi-user sidebar-nav-icon"></i>
                        <span class="sidebar-nav-mini-hide">Live data</span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('live_data', 'markets-wsj-com')}}" class="sidebar-item">markets.wsj.com</a>
                        </li>
                        <li>
                            <a href="{{route('live_data', 'reuters_com_finance_global-market-data')}}" class="sidebar-item">reuters.com</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-parrent">
                    <a href="#" class="sidebar-nav-menu">
                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                        <i class="gi gi-user sidebar-nav-icon"></i>
                        <span class="sidebar-nav-mini-hide">Thanh Toán</span>
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
                    <a href="{{route('backend_category')}}" class="sidebar-item"><i class="hi hi-folder-open sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Category</span></a>
                </li>
                <li>
                    <a href="{{route('backend_post')}}" class="sidebar-item"><i class="gi gi-leaf sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Post</span></a>
                </li>
                <li>
                    <a href="{{route('backend_article')}}" class="sidebar-item"><i class="fa fa-newspaper-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Article</span></a>
                </li>
                <li class="sidebar-parrent">
                    <a href="#" class="sidebar-nav-menu">
                        <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                        <i class="gi gi-cogwheels sidebar-nav-icon"></i>
                        <span class="sidebar-nav-mini-hide">Setting</span>
                    </a>
                    <ul>
                        <li class="sidebar-parrent">
                            <a href="#" class="sidebar-nav-submenu">
                                <i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
                                <span class="sidebar-nav-mini-hide">Image</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{route('article_image_setting')}}" class="sidebar-item">Article</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- END Sidebar Navigation -->

            <!-- Sidebar Notifications -->
            @include('admin.layouts.sidebar.notification')
            <!-- END Sidebar Notifications -->
        </div>
        <!-- END Sidebar Content -->
    </div>
    <!-- END Wrapper for scrolling functionality -->
</div>