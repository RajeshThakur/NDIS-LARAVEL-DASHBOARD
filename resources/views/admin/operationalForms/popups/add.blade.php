@if ($modal_id = 'add_form') @endif
<div class="modal micromodal-slide" id="{{$modal_id}}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" >
        <div class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="{{$modal_id}}-title">

        <form class="black-80 onboarding" action= "" method="get">
                @csrf
                <header class="modal__header">
                    <button class="modal__close modal-close-trigger" aria-label="Close modal" data-custom-close></button>
                    <h2 class="modal__title">{{ trans('opforms.title') }}</h2>
                </header>
                <div class="main-column">
                    <div class="modal__content" id="{{$modal_id}}-content">
                        
                        <div class="row">
                            
                            {!! 
                                Form::select('user_tye', trans('opforms.selectionuserType'),  array('default'=>'Please Select','Participant' => 'Participant', 'Support Worker' => 'Support Worker', 'External Service Provider'=>'External Service Provider'))->required('required')->id("user_tye")
                            !!}

                            {!! 
                                Form::select('userList', trans('opforms.selectionuser'),  $userName)->required('required')->id("userList")
                            !!}

                            {{-- {!! 
                                Form::select('templateId', trans('opforms.selectionform'),  $opformTemplates)->required('required')->id("templateId")
                            !!} --}}

                        </div>

                    </div>

                    <footer class="modal__footer" id="form_buttons">
                        {{-- <button class="btn btn-success  submitter" type="submit" id="formRequest" >
                            {{ trans('opforms.openform') }}
                        </button> --}}
                    </footer>
                </div>

            </form>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
   $(function () {

        //hide all user list by default
        var roleUser = [];
        roleUser = <?php echo json_encode($userRole); ?>;
        
        //after click usert type then user list show according to selection of user type
        jQuery("#user_tye").on('change', function(ev) {

            jQuery.each($('#userList').children(),function(index,value) {
                $(value).show().css("display", "none");
            });
            
            $( "#form_buttons" ).empty();
            
            var selectedUserType = $(this).val();
            
            jQuery.each($('#userList').children(),function(index,value) {

                jQuery.each(roleUser,function(id, role) {
                
                    if(selectedUserType == role) {

                        if(id == $(value).val()) {
                            $(value).show().css("display", "block");
                        }
                    }
                });
            });


        })


        jQuery('#userList').on('change', function(ev) {
            
            var opforms = {!! json_encode($opformTemplates) !!};
            var templateForUser = [];
            var user_role = $('#user_tye').val();

            $( "#form_buttons" ).empty();

            if(user_role === 'Participant'){
                templateForUser = {!! json_encode($participantOnlyTemplates) !!};
            }
            if(user_role === 'Support Worker'){
                templateForUser = {!! json_encode($workerOnlyTemplate) !!};
            }
            if(user_role === 'External Service Provider'){
                templateForUser = {!! json_encode($externalOnlyTemplate) !!};
            }
            var templateName = '';
            $.each(opforms, function(i,v){
                templateName = v.toLowerCase();
                $.each(templateForUser, function(k,vl){
                    if(vl == i){
                        $('#form_buttons').append('<button class="btn btn-success  submitter form_open" id="formRequest_'+i+'" type="submit" data-form_id="'+i+'">'+templateName.toUpperCase()+'</button> ');    
                    }
                });
            });
            
        });        


        //after user request to open an form`
        jQuery("#form_buttons").on('click', '.form_open', function(ev){

            ev.preventDefault();
            var templateId = $(this).data('form_id');
            var userId = $('#userList').val();
            ndis.redirect("/admin/forms/create/"+templateId+"/"+userId);
            
        })

      
      
   })

</script>
@endsection