@extends('layouts.admin')
@section('content')
<div class="content-onboard">
    
    <div class="jumbotron bg-white" id="onboard-message">
        <div class="row"  @if( !($errors->isEmpty()) ) style="display:none" @endif>
            <div class="col-lg-12">
                <h1 class="alert-heading text-center mt-5 mb-5">{{ trans('global.provider.onboarding.title') }}</h1>
                <h3 class="text-center mt-4 mb-4">{{ trans('global.provider.onboarding.message') }}</h3>
                <h5 class="text-center">{{ trans('global.provider.onboarding.message1') }}</h5>
                <hr class="my-4">
                <div class="text-center">
                    {{-- <a href="#" class="btn btn-success  rounded" id="show-form" role="button"> {{ trans('global.provider.onboarding.action') }} </a> --}}
                    <a href="admin/users/profile" class="btn btn-success  rounded"  role="button"> {{ trans('global.provider.onboarding.action') }} </a>
                    <a href="{{ route("admin.home",['skipped' => 1]) }}" id="skip"  class="btn btn-success rounded ml-40"role="button"> {{ trans('global.provider.onboarding.skip') }} </a>
                </div>
            </div>            
        </div>
    </div>
  {{-- 
    <div class="row" @if( $errors->isEmpty() ) style="display:none" @endif id="onboard-form">
        <div class="card" >
            <div class="card-body login-card-body">
               
                <form method="POST" action="{{ route("admin.complete-onboarding.store") }}" enctype="multipart/form-data" id="reg-grp-form">
                    <h2> {{ trans('global.provider.onboarding.message') }}</h2>
                    {{ csrf_field() }}

                    <div id="reg_grp_item_container">
                    </div>

                    <div class="row">  
                        
                        <div class="col-6 form-group">
                            <button type="submit" class="btn btn-success plr-100 rounded">
                                    {{ trans('global.save') }}
                            </button>
                        </div>
                        <div class="col-6 form-group text-right">
                            <button type="button" id="add_more_regrp" class="btn btn-success rounded">
                                    {{ trans('global.provider.onboarding.add_new_reg') }}                                
                            </button>
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

</div>

{{-- @include('template.regrp_fields') --}}

@endsection

@section('scripts')
@parent
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
    $(document).ready(function($) {
            @if( $errors->isEmpty() )            
                 $('#show-form').click(function(){
                    $("#onboard-message").hide();
                    $("#onboard-form").show();
                });   
            @endif

            // $('#skip').click(function(e){
            //     e.preventDefault();
            //     $(".content-onboard").remove();
            //     $(".content").show();
            // });
            $.validate();

            $('.content').on( 'change', '.reg_group', function(e){
            
                var $target = $('#'+jQuery(this).attr('rel'));
                var currentSection = $(this).parents('.reg_grp_item').attr('rel');             
                var parentID = this.value;             
                var childItems = $target.siblings('.child-grps');
              
                var request = $.ajax({
                    url: "/admin/getRegGroups",
                    method: "GET",
                    data: { parentID : parentID ,current: currentSection}
                });
                
                request.done(function( data ) {
                    childItems.empty();
                    childItems.append(data);
                });
                
                request.fail(function( jqXHR, textStatus ) {
                    console.log( "Request failed: " + textStatus );
                });

            });

        

                    
                
        });
</script>
@endsection