<!DOCTYPE html>
<html>

<head>
    @include('partials.head')
</head>

<body class="sidebar-mini sidebar-open" style="height: auto;">
    <div class="wrapper">

        @include('partials.header')

        <div class="content-wrapper row pl-0 pr-0" style="min-height: 917px;">
          
            <!-- Sidebar content -->
            @include('partials.menu')

            <!-- Main content -->
            <section class="content col-sm-9">
                
                @include('partials.message')

                {{-- @if( Auth::user()->roles()->get()->contains(2) )
                  @if( !$onboarding )
                    @include('admin.onboard')
                  @endif
                @endif --}}

                {{-- @if( Auth::user()->roles()->get()->contains(2) )
                  @if( !(\App\Provider::where('user_id', '=', \Auth::user()->id )->firstOrFail())->is_onboarding_complete )
                    @include('admin.onboard')
                  @endif
                @endif --}}
                
                @yield('content')
            </section>
            <!-- /.content -->
        </div>

        <footer class="main-footer">
            <p><span> &copy; 2019 Cloud Access Pty Ltd</span></p>
        </footer>

        @yield('bottom')

        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>

    <div id="toast-container"></div>
    
    @include('template.toast')

    @include('partials.scripts')
    
    @yield('scripts')
    
    {{-- @include('partials.footerScripts') --}}

</body>

</html>