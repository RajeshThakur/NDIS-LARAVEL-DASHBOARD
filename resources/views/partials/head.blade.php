    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('global.site_title') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700&display=swap" rel="stylesheet">
    {{-- <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap-grid.css" rel="stylesheet" /> --}}
    <link href="{{url('assets/fontawesome/css/all.min.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />


    {{-- <link href="{{ asset('assets/dataTables/datatables.min.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/dataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    {{--
    <link href="{{ asset('assets/dataTables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dataTables/css/select.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/dataTables/css/buttons.dataTables.min.css') }}" rel="stylesheet" />
    --}}
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

    <link href="{{ asset('assets/datetimepicker/datetimepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/hint/hint.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/micromodal.css') }}" rel="stylesheet" />
    
    @yield('libStyles')

    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/adminltev3.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/introjs.css') }}" rel="stylesheet" />
    <script type="text/javascript">
      /** @namespace ndis */
      window.ndis = window.ndis || {};
      
      calDisabledDates = [];
      calDaysOfWeekDisabled = [];

      @yield('globalJSVars')
    </script>