<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="{{ route("welcome") }}">
            <img src="/storage/datecar_logo.jpg" width="100%" height="auto">
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("frontend.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-home">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('service_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("app/service-stations*") ? "c-show" : "" }} {{ request()->is("app/cars*") ? "c-show" : "" }} {{ request()->is("app/repairs*") ? "c-show" : "" }} {{ request()->is("app/tasks*") ? "c-show" : "" }} {{ request()->is("app/parts*") ? "c-show" : "" }} {{ request()->is("app/upcomings*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.service.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('service_station_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("frontend.service-stations.index") }}" class="c-sidebar-nav-link {{ request()->is("app/service-stations") || request()->is("app/service-stations/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-warehouse c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.serviceStation.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('car_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("frontend.cars.index") }}" class="c-sidebar-nav-link {{ request()->is("app/cars") || request()->is("app/cars/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-car c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.car.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('repair_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("frontend.repairs.index") }}" class="c-sidebar-nav-link {{ request()->is("app/repairs") || request()->is("app/repairs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-wrench c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.repair.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('task_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("frontend.tasks.index") }}" class="c-sidebar-nav-link {{ request()->is("app/tasks") || request()->is("app/tasks/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-tasks c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.task.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('part_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("frontend.parts.index") }}" class="c-sidebar-nav-link {{ request()->is("app/parts") || request()->is("app/parts/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.part.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('upcoming_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("frontend.upcomings.index") }}" class="c-sidebar-nav-link {{ request()->is("app/upcomings") || request()->is("app/upcomings/*") ? "c-active" : "" }}">
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
                    <a class="c-sidebar-nav-link {{ request()->is('app/profile/password') || request()->is('app/profile/password/*') ? 'c-active' : '' }}" href="{{ route('frontend.profile.index') }}">
                        <i class="fa-fw fas fa-user-cog c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.my_profile') }}
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
