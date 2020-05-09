@extends('layouts.admin')


@section('content')
    @if($users->count() > 0)
    <div class="melissa-parker add-new-custom">
                <p class="welcome-text"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span>New Message</p>
                <p class="update"><a href="#"><img src="/img/watch.png"></a>Update few second ago</p>
            </div>
        {{-- <h1 class="new-message">Create a new message</h1> --}}


        @if( empty($users->messagables))
        <div class="alert alert-danger alert-dismissible">
            <p>No Support Worker, External Service Provider or Participant is availbale under you. So you won't be able to send message.</p>
        </div>
        @else
        <form action="{{ route("admin.messages.store") }}" class="validated" method="post">
            {{ csrf_field() }}
            <div class="col-md-12">
                <!-- Subject Form Input -->
                {!! 
                    Form::text('subject',  'Subject*', old('subject') )
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.messanger.subject') 
                    ])
                    ->placeholder('Subject')
                !!}

                <!-- Message Form Input -->
                {!!
                    Form::textarea('message',  'Message*', old('message') )
                    ->attrs([ 
                        "required"=>"required", 
                        "data-rule-required"=>"true", 
                        "data-msg-required"=>trans('errors.messanger.message') 
                    ])
                    ->placeholder('Type Your Message Here....')
                !!}
                
                {{-- <div class="checkbox">
                  
                    <label title="Select user"></label>
                    <input type="text" value="" id="users">
                    <input type="hidden" name="recipients[]" value="" id="recipients">

                    <div id="userList"></div>
                </div> --}}

                {!! Form::select('recipients', trans('global.messaging.fields.recipients'),$users->messagables, '')->size('col-sm-12') !!}

               
        
                <!-- Submit Form Input -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary custom-btn rounded">Submit</button>
                </div>
            </div>
        </form>
        @endif

        
    @else
        <p>No active user available</p>
    @endif
@stop

@section('scripts')
@parent
<script>
    $(document).ready(function(){
    
     $('#users').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
             var _token = $('input[name="_token"]').val();
             $.ajax({
              url:"{{ route('autocomplete.fetch') }}",
              method:"POST",
              data:{query:query, _token:_token},
              success:function(data){
                   $('#userList').fadeIn();  
                   $('#userList').empty();
                   $('#userList').html(data);
                // console.log(data);
              }
             });
            }
        });
    
        $(document).on('click', 'li', function(){  
            $('#users').val($(this).text());
            $('#recipients').val($(this).data('id'));  
            $('#userList').fadeOut();  
        });  
    
    });
</script>
@endsection
