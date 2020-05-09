<!DOCTYPE html>
<html>

<head>
    @include('partials.head')
</head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">

    @yield('content')

    <footer class="main-footer">
        <p><span> &copy;  2019 Cloud Access Pty Ltd</span> {{ trans('global.allRightsReserved') }}</p>
    </footer>

    @include('partials.scripts')
    
    @yield('scripts')
    
</body>



</html>