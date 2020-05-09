<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <p>
                        <span class="text-none">{{ trans('global.dashboard') }}</span>
                        <span class="count-no"><span class="dashb-count">3</span></span>
                    </p>
                </a>
            </li>
            @can('user_management_access')
                <li class="nav-item has-treeview {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i>
                        <p>
                            <span class="text-none">{{ trans('global.userManagement.title') }}</span>
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    {{-- <i class="fa fa-unlock-alt"></i> --}}
                                    <p>
                                        <span>{{ trans('global.permission.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                {{-- <i class="fa fa-users" aria-hidden="true"></i> --}}
                                    <p>
                                        <span>{{ trans('global.role.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    {{-- <i class="fa fa-user"></i> --}}
                                    <p>
                                        <span>{{ trans('global.user.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('task_management_access')
                <li class="nav-item has-treeview {{ request()->is('admin/events/statuses*') ? 'menu-open' : '' }} {{ request()->is('admin/task-tags*') ? 'menu-open' : '' }} {{ request()->is('admin/events*') ? 'menu-open' : '' }} {{ request()->is('admin/event/calendar*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle">
                        <i class="fa fa-tasks"></i>
                        <p>
                        
                            <span class="text-none">{{ trans('global.taskManagement.title') }}</span>
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('task_status_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.events.statuses.index") }}" class="nav-link {{ request()->is('admin/events/statuses') || request()->is('admin/events/statuses/*') ? 'active' : '' }}">
                                    <p>
                                        <span>{{ trans('global.taskStatus.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('task_tag_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.task-tags.index") }}" class="nav-link {{ request()->is('admin/task-tags') || request()->is('admin/task-tags/*') ? 'active' : '' }}">
                                    <p>
                                        <span>{{ trans('global.taskTag.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('task_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.events.index") }}" class="nav-link {{ request()->is('admin/events') || request()->is('admin/events/*') ? 'active' : '' }}">
                                    <p>
                                        <span>{{ trans('global.task.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('tasks_calendar_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.events.calendar") }}" class="nav-link {{ request()->is('admin/event/calendar') || request()->is('admin/event/calendar/*') ? 'active' : '' }}">
                                    <p>
                                        <span>{{ trans('global.tasksCalendar.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('registration_group_access')
                <li class="nav-item">
                    <a href="{{ route("admin.registration-groups.index") }}" class="nav-link {{ request()->is('admin/registration-groups') || request()->is('admin/registration-groups/*') ? 'active' : '' }}">
                        <i class="fa fa-object-group" aria-hidden="true"></i>
                        <p>
                            <span class="text-none">{{ trans('global.registrationGroup.title') }}</span>
                        </p>
                    </a>
                </li>
            @endcan
            
            @can('participant_access')
                <li class="nav-item has-treeview {{ request()->is('admin/participants*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/participants') || request()->is('admin/participants/*') ? 'active' : '' }}">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <p>
                            <span class="text-none">{{ trans('participants.title') }}</span>
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('participant_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.participants.index") }}" class="nav-link {{ request()->is('admin/participants') || request()->is('admin/participants/index') ? 'active' : '' }}">
                                    {{-- <i class="fa fa-accessible-icon"></i> --}}
                                    <p>
                                        <span>{{ trans('participants.list_participants') }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("admin.participants.create") }}" class="nav-link {{ request()->is('admin/participants/create') ? 'active' : '' }}">
                                    {{-- <i class="fa fa-accessible-icon"></i> --}}
                                    <p>
                                        <span>{{ trans('participants.add_new') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('support_worker_access')
                <li class="nav-item">
                    <a href="{{ route("admin.support-workers.index") }}" class="nav-link {{ request()->is('admin/support-workers') || request()->is('admin/support-workers/*') ? 'active' : '' }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <p>
                            <span class="text-none">{{ trans('sw.title') }}</span>
                            <span class="count-no"><span class="dashb-count support">9</span></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('support_worker_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.support-workers.index") }}" class="nav-link {{ request()->is('admin/support-workers') || request()->is('admin/support-workers/index') ? 'active' : '' }}">
                                    <i class="fab fa-accessible-icon">
                                    </i>
                                    <p>
                                        <span>{{ trans('sw.list_support_workers') }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("admin.support-workers.create") }}" class="nav-link {{ request()->is('admin/support-workers/create') ? 'active' : '' }}">
                                    <i class="fab fa-accessible-icon">
                                    </i>
                                    <p>
                                        <span>{{ trans('sw.add_new') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('service_booking_access')
                <li class="nav-item">
                    <a href="{{ route("admin.bookings.index") }}" class="nav-link {{ request()->is('admin/bookings') || request()->is('admin/bookings/*') ? 'active' : '' }}">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <p>
                            
                            <span class="text-none">{{ trans('bookings.title') }}</span>
                            <span class="count-no"><span class="dashb-count service">9</span></span>
                        </p>
                    </a>
                </li>
            @endcan
            
            @can('message_access')
                <li class="nav-item">
                    <a href="/messages" class="nav-link ">
                        <i class="fa fa-cogs"></i>
                        <p>
                            <span>{{ trans('global.messaging.title') }}</span>
                        </p>
                    </a>
                </li>
            @endcan

            @can('accounts_access')
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="fa fa-cogs">

                        </i>
                        <p>
                        
                            <span>{{ trans('global.accounts.title') }}</span>
                        </p>
                    </a>
                </li>
            @endcan
            
            @can('external_service_access')
                <li class="nav-item has-treeview {{ request()->is('admin/service/provider*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle">
                        <i class="fa fa-cogs">

                        </i>
                        <p>
                        
                            <span>{{ trans('serviceProvider.title') }}</span>
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('external_service_provider_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.provider.index") }}" class="nav-link {{ request()->is('admin/service/provider') || request()->is('admin/service/provider/*') ? 'active' : '' }}">
                                    <i class="fa fa-cogs">

                                    </i>
                                    <p>
                                    
                                        <span>{{ trans('serviceProvider.title') }}</span>
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
        
        </ul>
    </nav>