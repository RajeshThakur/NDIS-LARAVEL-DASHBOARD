<!DOCTYPE html>
<html>

<head>
    @include('partials.head_pdf')
</head>

<body class="sidebar-mini sidebar-open" style="height: auto;">
    <div class="wrapper">

        {{-- @include('partials.header') --}}

        <div class="content-wrapper row pl-0 pr-0" style="min-height: 917px;">
          
            <!-- Sidebar content -->
            {{-- @include('partials.menu') --}}

            <!-- Main content -->
            <section class="content col-sm-9">
                
                {{-- @include('partials.message') --}}
                
                @yield('content')
            </section>
            <!-- /.content -->
        </div>



        @yield('bottom')

        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>

    <div id="toast-container"></div>
    
    @include('template.toast')

    @include('partials.scripts_pdf')
    
    @yield('scripts')

    <script type="text/javascript">
      jQuery(document).ready(function(){
        $(':input').attr('readonly','readonly');
      })
    </script>
    
    {{-- @include('partials.footerScripts') --}}

</body>

</html>