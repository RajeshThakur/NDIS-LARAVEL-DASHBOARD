<div id="display-msg">
    @if ($errors->any())
        {!! '<div class="alert bg-danger alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'. implode('', $errors->all('<p><i class="icon fa fa-ban"></i> :message</p>')) . '</div>' !!}
    @endif

    @if(session('success'))
        <div class="alert bg-success alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p><i class="icon fa fa-check"></i> {{session('success')}}</p>
        </div>
    @endif



    @if(session('warning'))

        <div class="alert bg-warning alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p><i class="icon fa fa-exclamation-triangle"></i> {{session('warning')}}</p>
        </div>

    @endif


    @if(session('message'))

        <div class="alert bg-info alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p><i class="icon fa fa-info"></i> {{session('message')}}</p>
        </div>

    @endif

</div>

@if(session('status'))
    <div id="page-status">
        <div class="alert bg-info alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p><i class="icon fa fa-info"></i> {{session('status')}}</p>
        </div>
    </div>
@endif