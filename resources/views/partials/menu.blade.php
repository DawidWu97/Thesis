<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="{{ route("welcome") }}">
            <img src="/storage/datecar_logo.jpg" width="100%" height="auto">
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li>

        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-home">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/permissions*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('user_alert_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-alerts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userAlert.title') }}
                </a>
            </li>
        @endcan
        @can('user_request_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.user-requests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-requests") || request()->is("admin/user-requests/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-file-text c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userRequest.title') }}
                </a>
            </li>
        @endcan
        @can('service_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/service-stations*") ? "c-show" : "" }} {{ request()->is("admin/cars*") ? "c-show" : "" }} {{ request()->is("admin/repairs*") ? "c-show" : "" }} {{ request()->is("admin/tasks*") ? "c-show" : "" }} {{ request()->is("admin/parts*") ? "c-show" : "" }} {{ request()->is("admin/upcomings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.service.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('service_station_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.service-stations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/service-stations") || request()->is("admin/service-stations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-warehouse c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.serviceStation.admin_title') }}
                            </a>
                        </li>
                    @endcan
                        @can('category_access')
                            <li class="c-sidebar-nav-item">
                                <a href="{{ route("admin.categories.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/categories") || request()->is("admin/categories/*") ? "c-active" : "" }}">
                                    <i class="fa-fw fas fa-tag c-sidebar-nav-icon">

                                    </i>
                                    {{ trans('cruds.category.title') }}
                                </a>
                            </li>
                        @endcan
                    @can('car_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cars.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cars") || request()->is("admin/cars/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.car.admin_title') }}
                            </a>
                        </li>
                    @endcan
                    @can('repair_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.repairs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/repairs") || request()->is("admin/repairs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-wrench c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.repair.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('task_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.tasks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tasks") || request()->is("admin/tasks/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-tasks c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.task.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('part_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.parts.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/parts") || request()->is("admin/parts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.part.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('upcoming_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.upcomings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/upcomings") || request()->is("admin/upcomings/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-calendar c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.upcoming.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
