<div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
    <div class="sidebar-user-avatar">
        <a href="javascript:void(0)">
            <img src="{{asset('themes/admin/img/admin-avatar.png')}}" alt="avatar">
        </a>
    </div>
    <div class="sidebar-user-name">{{\Session::get('admin')->name}}</div>
    <div class="sidebar-user-links">
        <a href="{{route('admin_logout')}}" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="gi gi-exit"></i></a>
    </div>
</div>