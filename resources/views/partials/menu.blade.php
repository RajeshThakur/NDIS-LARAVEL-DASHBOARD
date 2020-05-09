<aside class="main-sidebar sidebar-dark-primary elevation-4 hide-on-mobile-view col-sm-3 pr-0">
    {{-- <div class="top-burger-menu">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item toggle-bar">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                    </li>
                </ul>
        </div>
    </div> --}}
    <!-- Brand Logo -->
    {{-- <a href="{{url('admin')}}" class="brand-link">
        <img src="{{url('img/logo.png')}}" alt="NDIS" />
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">

         <li class="nav-item replaceon-text fa fa-bars">
             <p><a href="#"><img src="{{url('img/round-arrow.png')}}" alt="NDIS" /></p>
            <a class="rotate-text" href="#">Expand</a>
            </a>
        </li>
        <!-- Sidebar Menu -->
        <nav class="mt-4 custom-mt">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        {{-- <i class="fa fa-home" aria-hidden="true"></i> --}}
                         <img class="default-img" src="{{url('img/home.png')}}" alt="NDIS" />
                        <img class="active-show-img" src="{{url('img/home-blue.png')}}" alt="NDIS" />
                        <p>
                            
                            <span class="text-none">{{ trans('global.dashboard') }}</span>
                            {{-- <span class="count-no"><span class="dashb-count">3</span></span> --}}
                        </p>
                    </a>
                </li>

             
                @can('user_management_access')
                    <li onclick="usermanagementaccessredirect()" class="nav-item has-treeview {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'active' : '' }}">
                            <i class="fa fa-users"></i>
                            <p>
                                <span class="text-none">{{ trans('global.userManagement.title') }}</span>
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <span>{{ trans('global.permission.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                           
                           
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <span>{{ trans('global.role.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                          
                            @can('user_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                            <span>{{ trans('global.user.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('task_management_access')
                    <li onclick="taskmanagementaccessredirect()" class="nav-item has-treeview {{ request()->is('admin/tasks/statuses*') ? 'menu-open' : '' }} {{ request()->is('admin/task-tags*') ? 'menu-open' : '' }} {{ request()->is('admin/events*') ? 'menu-open' : '' }} {{ request()->is('admin/event/calendar*') ? 'menu-open' : '' }}">
                        <a class="nav-link  nav-dropdown-toggle">
                            <i class="fa fa-tasks"></i>
                            <p>
                                
                                <span class="text-none">{{ trans('global.taskManagement.title') }}</span>
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('task_tag_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.task-tags.index") }}" class="nav-link {{ request()->is('admin/task-tags') || request()->is('admin/task-tags/*') ? 'active' : '' }}">
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <span>{{ trans('global.taskTag.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @endcan
                            @can('task_status_access')
                            <li class="nav-item">
                                <p>
                                    <a href="{{ route("admin.tasks.statuses.index") }}" class="nav-link {{ request()->is('admin/tasks/statuses') || request()->is('admin/tasks.statuses') ? 'active' : '' }}">
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                        <span>{{ trans('global.taskStatus.title') }}</span>
                                    </a>
                                </p>
                            </li>
                        @endcan
                            @can('task_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.events.index") }}" class="nav-link {{ request()->is('admin/events') || request()->is('admin/events/*') ? 'active' : '' }}">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <span>{{ trans('global.task.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @endcan
                            @can('tasks_calendar_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.events.calendar") }}" class="nav-link {{ request()->is('admin/event/calendar') || request()->is('admin/event/calendar/*') ? 'active' : '' }}">
                                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                            <span>{{ trans('global.tasksCalendar.title') }}</span>
                                        </a>
                                    </p>
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
                    <li onclick="participantpageredirect()" class="nav-item has-treeview {{ request()->is('admin/participants*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/participants') || request()->is('admin/participants/*') ? 'active' : '' }}">
                           {{-- <i class="fa fa-users" aria-hidden="true"></i> --}}
                            <img class="default-img" src="{{url('img/user-dobble-group.png')}}" alt="NDIS" />
                            <img class="active-show-img" src="{{url('img/user-group.png')}}" alt="NDIS" />
                            <p>
                                <span class="text-none">{{ trans('participants.title') }}</span>
                                <span class="count-no"><span class="dashb-count support">{{ \App\Participant::where('is_onboarding_complete','=',0)->count() }}</span></span>
                                {{-- <i class="right fa fa-angle-left"></i> --}}
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('participant_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.participants.index") }}" class="nav-link {{ request()->is('admin/participants') || request()->is('admin/participants/index') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <span>{{ trans('participants.list_participants') }}</span>
                                        </a>
                                    </p>
                                </li>
                                @php if( !checkUserRole('1') ): @endphp
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.participants.create") }}" class="nav-link {{ request()->is('admin/participants/create') ? 'active' : '' }}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <span>{{ trans('participants.add_new') }}</span>
                                        </a>
                                    </p>
                                </li>
                                @php endif; @endphp
                            @endcan
                        </ul>
                    </li>
                @endcan
                
                @can('support_worker_access')
                    <li onclick="supportworkerpageredirect()" class="nav-item {{ request()->is('admin/support-workers*') ? 'menu-open' : '' }}">
                        <a href="{{ route("admin.support-workers.index") }}" class="nav-link {{ request()->is('admin/support-workers') || request()->is('admin/support-workers/*') ? 'active' : '' }}">
                            <!-- <img class="default-img" src="{{url('img/user.png')}}" alt="NDIS" />
                            <img class="active-show-img" src="{{url('img/user-blue.png')}}" alt="NDIS" /> -->
                            <i class="fa fa-id-card-o" aria-hidden="true"></i>
                            <p>
                                <span class="text-none">{{ trans('sw.title') }}</span>
                                <span class="count-no"><span class="dashb-count support">{{ \App\SupportWorker::where('is_onboarding_complete','=',0)->count() }}</span></span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('support_worker_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.support-workers.index") }}" class="nav-link {{ request()->is('admin/support-workers') || request()->is('admin/support-workers/index') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <span>{{ trans('sw.list_support_workers') }}</span>
                                        </a>
                                    </p>
                                </li>
                                @php if( !checkUserRole('1') ): @endphp
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.support-workers.create") }}" class="nav-link {{ request()->is('admin/support-workers/create') ? 'active' : '' }}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <span>{{ trans('sw.add_new') }}</span>
                                        </a>
                                    </p>
                                </li>
                                @php endif; @endphp
                            @endcan
                        </ul>
                    </li>
                @endcan
                
                @can('service_booking_access')
                    <li onclick="servicebookingpageredirect()" class="nav-item {{ request()->is('admin/bookings*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/bookings') || request()->is('admin/bookings/*') ? 'active' : '' }}">
                            {{-- <i class="fa fa-file" aria-hidden="true"></i> --}}
                            <img class="default-img" src="{{url('img/copy.png')}}" alt="NDIS" />
                            <img class="active-show-img" src="{{url('img/copy-blue.png')}}" alt="NDIS" />
                            <p>
                                
                                <span class="text-none">{{ trans('bookings.menu.title') }}</span>
                                <span class="count-no"><span class="dashb-count service">{{ \App\Bookings::where('booking_orders.status','=',config('ndis.booking.statuses.NotSatisfied'))->count() }}</span></span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('service_booking_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.bookings.index") }}" class="nav-link {{ request()->is('admin/bookings') || request()->is('admin/bookings/index') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <span>{{ trans('bookings.menu.list_bookings') }}</span>
                                        </a>
                                    </p>
                                </li>                                
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.bookings.manually-complete.list") }}" class="nav-link {{ request()->is('admin/bookings/manually/complete/*') ? 'active' : '' }}">
                                            <i class="fa fa-clone" aria-hidden="true"></i>
                                            <span>{{ trans('bookings.menu.manually_complete_list') }}</span>
                                        </a>
                                    </p>
                                </li>
                                @php if( !checkUserRole('1') ): @endphp
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.bookings.create") }}" class="nav-link {{ request()->is('admin/bookings/create') ? 'active' : '' }}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <span>{{ trans('bookings.create_new') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @php endif; @endphp
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('content_page_delete')
                    <li onclick="contentmanagementdedirect()" class="nav-item has-treeview {{ request()->is('admin/cms*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle ">
                            <i class="fa-fw fa fa-book nav-icon"></i>
                            <p><span>{{ trans('cruds.contentManagement.title') }}</span><i class="right fa fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('content_category_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.cms.categories.index") }}" class="nav-link {{ request()->is('admin/cms/categories') || request()->is('admin/cms/categories/*') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <span>{{ trans('cruds.contentCategory.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @endcan
                            @can('content_tag_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.cms.tags.index") }}" class="nav-link {{ request()->is('admin/cms/tags') || request()->is('admin/cms/tags/*') ? 'active' : '' }}">
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <span>{{ trans('cruds.contentTag.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @endcan
                            @can('content_page_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.cms.pages.index") }}" class="nav-link {{ request()->is('admin/cms/pages') || request()->is('admin/cms/pages/*') ? 'active' : '' }}">
                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                            <span>{{ trans('cruds.contentPage.title') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('external_service_provider_access')
                    <li onclick="servicepageredirect()" class="nav-item has-treeview {{ request()->is('admin/service/provider*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle">
                            {{-- <i class="fa fa-building-o"></i> --}}
                            <!-- <img class="default-img" src="{{url('img/copy.png')}}" alt="NDIS" />
                            <img class="active-show-img" src="{{url('img/copy-blue.png')}}" alt="NDIS" /> -->
                            <i class="fa fa-id-card" aria-hidden="true"></i>
                            <p>
                                <span>{{ trans('serviceProvider.title') }}</span>
                                {{-- <i class="right fa fa-angle-left"></i> --}}
                                <span class="count-no"><span class="dashb-count support">{{ \App\ServiceProvider::where('agreement_signed','=',0)->count() }}</span></span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('external_service_provider_access')
                                <li class="nav-item">
                                    <p>
                                        <a href="{{ route("admin.provider.index") }}" class="nav-link {{ request()->is('admin/service/provider') || request()->is('admin/service/provider/*') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <span>{{ trans('serviceProvider.menu.list') }}</span>
                                        </a>
                                    </p>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('message_access')
                    <li class="nav-item">
                        <a href="{{url('admin/messages')}}" class="nav-link {{ request()->is('admin/messages') || request()->is('admin/messages/*') ? 'active' : '' }} ">
                            <img class="default-img" src="{{url('img/mail.png')}}" alt="NDIS" />
                            <img class="active-show-img" src="{{url('img/mail-blue.png')}}" alt="NDIS" />
                            <p><span>{{ trans('global.messaging.title') }}</span></p>
                        </a>
                    </li>
                @endcan

                @can('accounts_access')
                    <li onclick="accountaccessredirect()" class="nav-item has-treeview {{ request()->is('admin/accounts*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle">
                            <img class="default-img" src="{{url('img/toggles.png')}}" alt="NDIS" />
                            <img class="active-show-img" src="{{url('img/toggles-blue.png')}}" alt="NDIS" />
                            <p><span>{{ trans('accounts.title') }}</span></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item {{ request()->is('admin/accounts/support/*') ? 'menu-open' : '' }}">
                                <a  href="{{ route("admin.accounts.timesheet", 'support') }}" class="nav-link {{ request()->is('admin/accounts/support/*') ? 'active' : '' }}">
                                    <!-- <img class="default-account" src="http://localhost:8000/img/user.png" alt="NDIS">
                                    <img class="active-account-img" src="http://localhost:8000/img/user-blue.png" alt="NDIS"> -->
                                    <i class="fa fa-id-card-o" aria-hidden="true"></i>
                                    <p>
                                        <span>{{ trans('supportWorkers.title') }}</span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.timesheet", 'support') }}" class="nav-link {{ request()->is('admin/accounts/support/timesheet') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <p><span>{{ trans('accounts.menus.timesheet') }}</span></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.submission", 'support') }}" class="nav-link {{ request()->is('admin/accounts/support/submission') ? 'active' : '' }}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <p><span>{{ trans('accounts.menus.submissions') }}</span></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.payments", 'support') }}" class="nav-link {{ request()->is('admin/accounts/support/payments') ? 'active' : '' }}">
                                        <i class="fa fa-usd" aria-hidden="true"></i>
                                            <p><span>{{ trans('accounts.menus.payment_history') }}</span></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.proda", 'support') }}" class="nav-link {{ request()->is('admin/accounts/support/proda') ? 'active' : '' }}">
                                            <i class="fa fa-product-hunt" aria-hidden="true"></i>
                                            <p><span>{{ trans('accounts.menus.proda_output') }}</span></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ request()->is('admin/accounts/external/*') ? 'menu-open' : '' }}">
                                <a href="{{ route("admin.accounts.timesheet", 'external') }}" class="nav-link {{ request()->is('admin/accounts/external/*') ? 'active' : '' }}">
                                    <!-- <img class="default-account" src="http://localhost:8000/img/copy.png" alt="NDIS">
                                    <img class="active-account-img" src="http://localhost:8000/img/copy-blue.png" alt="NDIS"> -->
                                    <i class="fa fa-id-card" aria-hidden="true"></i>
                                    <p><span>{{ trans('serviceProvider.title') }}</span></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.timesheet", 'external') }}" class="nav-link {{ request()->is('admin/accounts/external/timesheet') ? 'active' : '' }}">
                                            <i class="fa fa-list"></i>
                                            <p><span>{{ trans('accounts.menus.timesheet') }}</span></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.submission", 'external') }}" class="nav-link {{ request()->is('admin/accounts/external/submission') ? 'active' : '' }}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            <p><span>{{ trans('accounts.menus.submissions') }}</span></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.payments", 'external') }}" class="nav-link {{ request()->is('admin/accounts/external/payments') ? 'active' : '' }}">
                                        <i class="fa fa-usd" aria-hidden="true"></i>
                                            <p><span>{{ trans('accounts.menus.payment_history') }}</span></p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route("admin.accounts.proda", 'external') }}" class="nav-link {{ request()->is('admin/accounts/external/proda') ? 'active' : '' }}">
                                            <i class="fa fa-product-hunt" aria-hidden="true"></i>
                                            <p><span>{{ trans('accounts.menus.proda_output') }}</span></p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endcan
                
                
               
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


 @section('scripts')
@parent
<script type="text/javascript">

    function participantpageredirect() {
        window.location.href = "{{ route("admin.participants.index") }}";
    }
    function supportworkerpageredirect() {
        window.location.href = "{{ route("admin.support-workers.index") }}";
    }
    function servicebookingpageredirect() {
        window.location.href = "{{ route("admin.bookings.index") }}";
    }
    function servicepageredirect(){
        window.location.href ="{{ route("admin.provider.index") }}";
    }
    function accountaccessredirect(){
        window.location.href ="{{ route("admin.accounts.timesheet", "support") }}";
    }
    function usermanagementaccessredirect(){
        window.location.href ="{{ route("admin.permissions.index") }}";
    }
    function taskmanagementaccessredirect(){
        window.location.href ="{{ route("admin.task-tags.index") }}";
    }
    function contentmanagementdedirect(){
        window.location.href ="{{ route("admin.cms.categories.index") }}";
    }

    jQuery("document").ready(function(event) {
        $('a.nav-link').on('click', function(){
            if ( $(this).hasClass('menu-open') ) {
                $(this).removeClass('menu-open');
            } else {
                $('.nav-sidebar li.menu-open').removeClass('menu-open');
                $(this).addClass('menu-open');
            }
        });
        //    if($(this).find('body').hasClass('sidebar')){
        //        $(this).find('body').removeClass('sidebar').addClass('sidebar');
        //    }
    });
       
</script>
@endsection 