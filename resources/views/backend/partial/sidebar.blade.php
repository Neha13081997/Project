<div class="leftside-menu">

<!-- Brand Logo Light -->
<a href="{{ route('admin.dashboard.index') }}" class="logo logo-light">
    <span class="logo-lg">
        <img src="{{ asset('backend/images/logo.png') }}" alt="logo">
    </span>
    <span class="logo-sm">
        <img src="{{ asset('backend/images/logo-sm.png') }}" alt="small logo">
    </span>
</a>

<!-- Brand Logo Dark -->
<a href="{{ route('admin.dashboard.index') }}" class="logo logo-dark">
    <span class="logo-lg">
        <img src="{{ asset('backend/images/logo-dark.png') }}" alt="dark logo">
    </span>
    <span class="logo-sm">
        <img src="{{ asset('backend/images/logo-sm.png') }}" alt="small logo">
    </span>
</a>

<!-- Sidebar -left -->
<div class="h-100" id="leftside-menu-container" data-simplebar>
    <!--- Sidemenu -->
    <ul class="side-nav">

        <li class="side-nav-title">Main</li>

        <li class="side-nav-item {{ request()->is('admin/dashboard') ? 'menuitem-active' : ''}}">
            <a href="{{ route('admin.dashboard.index') }}" class="side-nav-link {{ request()->is('admin/dashboard') ? 'active' : ''}}">
                <i class="ri-dashboard-3-line"></i>
                <span> Dashboard </span>
            </a>
        </li>

      
        @can('customer_access')
        <li class="side-nav-item {{ request()->is('admin/customer*') ? 'menuitem-active' : ''}}">
            <a data-bs-toggle="collapse" href="#customerLayouts" aria-expanded="false" aria-controls="customerLayouts" class="side-nav-link">
                <i class="ri-group-2-line"></i>
                <span> Coustomers </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse {{ request()->is('admin/customer*') ? 'show' : ''}}" id="customerLayouts">
                <ul class="side-nav-second-level">
                    <li class="{{ request()->is('admin/customer') && !request()->is('admin/customer/create') ? 'menuitem-active' : ''}}">
                        <a class="{{ request()->is('admin/customer') && !request()->is('admin/customer/create') ? 'active' : ''}}" href="{{ route('admin.customer.index') }}">List</a>
                    </li>
                    <li class="{{ request()->is('admin/customer/create') ? 'active' : ''  }}">
                        <a href="{{  route('admin.customer.create') }}" class="{{ request()->is('admin/customer/create') ? 'active' : '' }}">Create</a>
                    </li>
                </ul>
            </div>
        </li>
        @endcan

        @if (auth()->user()->can('post_access'))
        <li class="side-nav-item {{ request()->is('admin/post*') ? 'menuitem-active' : '' }}">
            <a data-bs-toggle="collapse" href="#masterLayout" aria-expanded="false" aria-controls="masterLayout" class="side-nav-link">
                <i class="ri-pages-line"></i>
                <span> Master </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse {{ request()->is('admin/post*') ? 'show' : '' }}" id="masterLayout">
                <ul class="side-nav-second-level">
                    <li class="{{ request()->is('admin/post*') ? 'menuitem-active' : '' }}">
                        <a class="{{ request()->is('admin/post*') ? 'active' : '' }}" href="{{ route('admin.post.index') }}">Posts</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif


        <li class="side-nav-title">Components</li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="false" aria-controls="sidebarBaseUI" class="side-nav-link">
                <i class="ri-briefcase-line"></i>
                <span> Access </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarBaseUI">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('admin.show.profile') }}">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </li>

       
    </ul>
    <!--- End Sidemenu -->

    <div class="clearfix"></div>
</div>
</div>