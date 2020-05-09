<ul>
    <li><a class="dropdown-item" href="{{route('admin.users.profile', \Auth::user()->id)}}"><span><i class="fa fa-user" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.my_provider_profile') }}</a></li>
    <li class="show-menu">
    <a class="dropdown-item custom-dropdown" href="#"><span><i class="fa fa-rocket" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.user_governance') }}<span class="caret">&nbsp;</span></a>
    <div class="custom-menu">
    <ul>
        <li><a class="dropdown-item" href="{{route('admin.cms.pages.search', ['policies'])}}"><span><i class="fa fa-building" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.user_policies') }}</a></li>
        <li><a class="dropdown-item" href="{{route('admin.forms.index')}}"><span><i class="fa fa-square" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.operational_form') }}</a></li>
        {{-- <li><a class="dropdown-item" href="{{route('admin.forms.create')}}"><span><i class="fa fa-files-o" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.create_new_form') }}</a></li> --}}
        <li><a class="dropdown-item" href="{{route('admin.cms.pages.search', ['self-audit'])}}"><span><i class="fa fa-credit-card" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.self_audit') }}</a></li>
        <li><a class="dropdown-item" href=""><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.create_new_self_audit') }}</a></li>
        <li><a class="dropdown-item" href="{{route('admin.cms.pages.search', ['past-audit'])}}"><span><i class="fa fa-pie-chart" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.past_audit') }}</a></li>
    </div>
    
    </li>
    @php if( !checkUserRole('1') ): @endphp
    <li><a class="dropdown-item" href="{{url('admin/reports')}}"><span><i class="fa fa-files-o" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.user_reporting') }}</a></li>
    <li><a class="dropdown-item" href="{{route('admin.provider.rates')}}"><span><i class="fa fa-cog" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.user_setting') }}</a></li>
    @php endif; @endphp
    <li><a class="dropdown-item" href="{{route('admin.cms.pages.search', ['tutorials-and-help'])}}"><span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>{{ trans('global.usermenu.fields.tutorials_and_half') }}</a></li>
    <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><span><i class="fa fa-sign-out" aria-hidden="true"></i></span>{{ trans('global.logout') }}</a></li>
    
</ul>