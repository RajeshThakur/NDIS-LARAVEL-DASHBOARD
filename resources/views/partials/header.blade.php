<nav class="main-header navbar navbar-expand-lg navbar-light bg-light border-bottom mrl-left-none">
    <a href="{{url('admin')}}" class="brand-link mobile-view">
        <img src="{{url('img/logo_2.png')}}" alt="NDIS" />
    </a>
    {{-- <a href="{{url('admin')}}" class="brand-link navbar-brand">
            <img src="{{url('img/logo.png')}}" alt="NDIS" />
    </a> --}}
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse  row" id="navbarSupportedContent">
        <div class="top-header">
            <div class="logo-section col-sm-3">
                
                    <ul class="navbar-nav mr-auto">
                        <li class="logo-img"> <a href="{{url('admin')}}" class="brand-link desltop-view">
                                <img src="{{url('img/logo_2.png')}}" alt="NDIS" />
                            </a>
                        </li>
                    </ul>
               
            </div>
            <div class="nav-section col-sm-9">
               <ul class="navbar-nav mr-auto">
            {{-- <li class="logo-img"> <a href="{{url('admin')}}" class="brand-link desltop-view">
                    <img src="{{url('img/logo.png')}}" alt="NDIS" />
                </a>
            </li> --}}
            <li class="nav-item search-user">
                <form action="{{ route("admin.search.name") }}" method="GET" role="search">
                    {{-- {{ csrf_field() }} --}}
                    <div class="input-group">
                        
                        {{-- <div style="position:relative"> --}}
                            <select name="provider_agreement" id="inp-provider_agreement" class="form-control" required="required" style="
                                position: absolute;
                                left: 0;
                                width: 35%;
                                top: 3px;
                                bottom: 3px;
                                height: auto !important;
                                border-left: 0;
                                background: transparent;
                                border-top: 0;
                                border-bottom: 0;
                                padding:5px 25px;
                                z-index: 9;
                            ">
                                <option value="participant" selected="">{{ trans('global.header.header_dropdown_Participant') }}</option>
                                <option value="supportworker">{{ trans('global.header.header_dropdown_Support_Worker') }}</option>
                                <option value="documentation">{{ trans('global.header.header_dropdown_Documentation') }}</option>
                            </select>
                            <i class="inputicon fa fa-caret-down" aria-hidden="true"></i>
                        {{-- </div> --}}

                        <input type="text" class="form-control" name="keyword" placeholder="Search" style="padding:0px 22px 0 38%"> 
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                            </button>
                        </span>
                        {{-- <span class="header-search-dropdown"><i class="fa fa-sort-desc" aria-hidden="true"></i></span> --}}
                    </div>
               
                </form>
            </li>

            <li class="nav-item massage custom-item ml-3">
                @include('partials.notifications')
            </li>
            
            <li class="nav-item massage envelope custom-item">
                @include('partials.inbox')
            </li>

            

            <li class="nav-item dropdown custom-item userprofile">
                <div class="media">
                    {!! getUserAvatar() !!}
                    <div class="media-body">
                        <a class="nav-link dropdown-toggle" href="{{route('admin.users.profile', \Auth::user()->id)}}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <strong>{!! getUserFullName() !!}</strong><br><small>{!! getUserRoleTitle() !!}</small>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @include('partials.usermenu')
                        </div>
                    </div>
                </div>
            
            </li>
            </ul>
            <aside class="main-sidebar sidebar-dark-primary elevation-4 show-on-mobile-view">
                

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <li class="nav-item replaceon-text">
                    <p><a href="{{route('home')}}"><img src="{{url('img/round-arrow.png')}}" alt="NDIS" /></a></p>
                        <a class="rotate-text" href="#">Expand</a>
                        </a>
                    </li>

                    <!-- Mobile Menu -->
                    @include('partials.menu')
                    
                    <!-- /.Mobile-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            
            </div>
        </div>
        <!-- Left navbar links -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 hide-on-desktop-view col-sm-3 pr-0">
        

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
           <li class="nav-item has-treeview {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'menu-open' : '' }}">
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
           <li class="nav-item has-treeview {{ request()->is('admin/events/statuses*') ? 'menu-open' : '' }} {{ request()->is('admin/task-tags*') ? 'menu-open' : '' }} {{ request()->is('admin/events*') ? 'menu-open' : '' }} {{ request()->is('admin/event/calendar*') ? 'menu-open' : '' }}">
               <a class="nav-link  nav-dropdown-toggle">
                   <i class="fa fa-tasks"></i>
                   <p>
                       
                       <span class="text-none">{{ trans('global.taskManagement.title') }}</span>
                       <i class="right fa fa-angle-left"></i>
                   </p>
               </a>
               <ul class="nav nav-treeview">
                   @can('task_status_access')
                       <li class="nav-item">
                           <p>
                               <a href="{{ route("admin.events.statuses.index") }}" class="nav-link {{ request()->is('admin/events/statuses') || request()->is('admin/events-statuses/*') ? 'active' : '' }}">
                                   <i class="fa fa-list" aria-hidden="true"></i>
                                   <span>{{ trans('global.taskStatus.title') }}</span>
                               </a>
                           </p>
                       </li>
                   @endcan
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
           <li class="nav-item has-treeview {{ request()->is('admin/participants*') ? 'menu-open' : '' }}">
               <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/participants') || request()->is('admin/participants/*') ? 'active' : '' }}">
                  {{-- <i class="fa fa-users" aria-hidden="true"></i> --}}
                   <img class="default-img" src="{{url('img/user-dobble-group.png')}}" alt="NDIS" />
                   <img class="active-show-img" src="{{url('img/user-group.png')}}" alt="NDIS" />
                   <p>
                       <span class="text-none">{{ trans('participants.title') }}</span>
                       <i class="right fa fa-angle-left"></i>
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
                       <li class="nav-item">
                           <p>
                               <a href="{{ route("admin.participants.create") }}" class="nav-link {{ request()->is('admin/participants/create') ? 'active' : '' }}">
                                   <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                   <span>{{ trans('participants.add_new') }}</span>
                               </a>
                           </p>
                       </li>
                   @endcan
               </ul>
           </li>
       @endcan
       
       @can('support_worker_access')
           <li class="nav-item {{ request()->is('admin/support-workers*') ? 'menu-open' : '' }}">
               <a href="{{ route("admin.support-workers.index") }}" class="nav-link {{ request()->is('admin/support-workers') || request()->is('admin/support-workers/*') ? 'active' : '' }}">
                   <!-- <img class="default-img" src="{{url('img/user.png')}}" alt="NDIS" />
                   <img class="active-show-img" src="{{url('img/user-blue.png')}}" alt="NDIS" /> -->
                   <i class="fa fa-id-card-o" aria-hidden="true"></i>
                   <p>
                       <span class="text-none">{{ trans('sw.title') }}</span>
                       <span class="count-no"><span class="dashb-count support">{{ \App\SupportWorker::all()->count() }}</span></span>
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
                       <li class="nav-item">
                           <p>
                               <a href="{{ route("admin.support-workers.create") }}" class="nav-link {{ request()->is('admin/support-workers/create') ? 'active' : '' }}">
                                   <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                   <span>{{ trans('sw.add_new') }}</span>
                               </a>
                           </p>
                       </li>
                   @endcan
               </ul>
           </li>
       @endcan
       
       @can('service_booking_access')
           <li class="nav-item {{ request()->is('admin/bookings*') ? 'menu-open' : '' }}">
               <a class="nav-link nav-dropdown-toggle {{ request()->is('admin/bookings') || request()->is('admin/bookings/*') ? 'active' : '' }}">
                   {{-- <i class="fa fa-file" aria-hidden="true"></i> --}}
                   <img class="default-img" src="{{url('img/copy.png')}}" alt="NDIS" />
                   <img class="active-show-img" src="{{url('img/copy-blue.png')}}" alt="NDIS" />
                   <p>
                       
                       <span class="text-none">{{ trans('bookings.menu.title') }}</span>
                       <span class="count-no"><span class="dashb-count service">{{ \App\BookingOrders::whereStatus(config('ndis.booking.statuses.Scheduled'))->count() }}</span></span>
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
                       <li class="nav-item">
                           <p>
                               <a href="{{ route("admin.bookings.create") }}" class="nav-link {{ request()->is('admin/bookings/create') ? 'active' : '' }}">
                                   <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                   <span>{{ trans('bookings.create_new') }}</span>
                               </a>
                           </p>
                       </li>
                   @endcan
               </ul>
           </li>
       @endcan

       @can('content_page_delete')
           <li class="nav-item has-treeview {{ request()->is('admin/cms*') ? 'menu-open' : '' }}">
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
           <li class="nav-item has-treeview {{ request()->is('admin/service/provider*') ? 'menu-open' : '' }}">
               <a class="nav-link nav-dropdown-toggle">
                   {{-- <i class="fa fa-building-o"></i> --}}
                   <!-- <img class="default-img" src="{{url('img/copy.png')}}" alt="NDIS" />
                   <img class="active-show-img" src="{{url('img/copy-blue.png')}}" alt="NDIS" /> -->
                   <i class="fa fa-id-card" aria-hidden="true"></i>
                   <p>
                       <span>{{ trans('serviceProvider.title') }}</span>
                       <i class="right fa fa-angle-left"></i>
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
           <li class="nav-item has-treeview {{ request()->is('admin/accounts*') ? 'menu-open' : '' }}">
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
        
    </div>

        <!-- Right navbar links -->
        @if(count(config('panel.available_languages', [])) > 1)
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                            <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
            </ul>
        @endif

    

    </nav>

     @section('scripts')
@parent
<script type="text/javascript">
  jQuery("document").ready(function(event) {
      $("span.header-search-dropdown").click(function(){
    $(".header-search-dropdown-input").toggle();
    
  });
  });
</script>
@endsection 