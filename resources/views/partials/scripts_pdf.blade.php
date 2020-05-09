<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> --}}
{{-- <script src="{{ asset('assets/bootstrap-4.2.1/js/bootstrap.min.js') }}"></script> --}}
<script src="{{ public_path().'/assets/bootstrap-4.2.1/js/bootstrap.js' }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>

{{-- <script src="{{ asset('assets/dataTables/datatables.min.js') }}"></script> --}}
<script src="{{ public_path().'/assets/dataTables/DataTables-1.10.18/js/jquery.dataTables.min.js' }}"></script>
{{-- 
<script src="{{ asset('assets/dataTables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/dataTables/js/jszip.min.js') }}"></script>
--}}

{{-- <script src="https://adminlte.io/themes/dev/AdminLTE/dist/js/"></script> --}}
<script src="{{ public_path().'/js/app.js' }}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key={{config("ndis.google_maps_key")}}&libraries=places"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

<script src="{{ public_path().'/assets/datetimepicker/datetimepicker.min.js' }}"></script>
<script src="{{ public_path().'/assets/daterangepicker/daterangepicker.js' }}"></script>
<script src="{{ public_path().'/assets/ckeditor5/11.0.1/ckeditor.js' }}"></script>
<script src="{{ public_path().'/js/micromodal.min.js' }}"></script>
<script src="{{ public_path().'/js/intro.js' }}"></script>

{{-- One Signal JS SDK --}}
{{-- 
<script src="//cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
<script>
    var OneSignal = OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "{{config('onesignal.app_id')}}",
        });
        /* In milliseconds, time to wait before prompting user. This time is relative to right after the user presses <ENTER> on the address bar and navigates to your page */
        var notificationPromptDelay = 30000;
        /* Use navigation timing to find out when the page actually loaded instead of using setTimeout() only which can be delayed by script execution */
        var navigationStart = window.performance.timing.navigationStart;
        /* Get current time */
        var timeNow = Date.now();
        /* Prompt the user if enough time has elapsed */
        // setTimeout(promptAndSubscribeUser, Math.max(notificationPromptDelay - (timeNow - navigationStart), 0));
    });
    function promptAndSubscribeUser() {
        window.OneSignal.isPushNotificationsEnabled(function(isEnabled) {
        if (!isEnabled) {
            window.OneSignal.showSlidedownPrompt();
        }
        });
    }
</script> --}}

@yield('libScripts')

<script src="{{ public_path().'/js/main.js' }}"></script>