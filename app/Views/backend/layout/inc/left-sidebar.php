<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html" class="w-100 h-100">
            <img src="/images/blog/<?= get_settings()->blog_logo ?>" alt=""
                 class="dark-logo w-100 h-100" />
            <img
                    src="/images/blog/<?= get_settings()->blog_logo ?>"
                    alt=""
                    class="light-logo w-100 h-100"
            />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                   <li>
                    <a href="<?=route_to('admin.home')?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-house"></span
                                ><span class="mtext">Home</span>
                    </a>
                    </li>
                <li>
                    <a href="<?=route_to('admin.home')?>" class="dropdown-toggle no-arrow ">
								<span class="micon dw dw-list"></span
                                ><span class="mtext">Categories</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-newspaper"></span
                                ><span class="mtext"> Posts </span>
                    </a>
                    <ul class="submenu">
                        <li><a href="">All Posts</a></li>
                        <li><a href="">Add new</a></li>
                    </ul>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>

                <li>
                    <div class="sidebar-small-cap">Settings</div>
                </li>

                <li>
                    <a href="<?= route_to('admin.profile')?>" target="" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-user"></span>
                        <span class="mtext">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="<?=route_to('settings')?>" target="" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-settings"></span>
                        <span class="mtext">Settings</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>