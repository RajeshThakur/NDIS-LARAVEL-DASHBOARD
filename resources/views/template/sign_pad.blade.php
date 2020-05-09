<div id="dm-{{$id}}" class="col-sm-12">
    <div class="form-group">
        {{-- <label for="participant_name">{!!$label!!}</label> --}}
        <div class="input-group">
            <canvas id="canv_{{$id}}" class="signature-pad" width=800 height="400" style="width: 800px;height: 400px;border: 25px solid #EEE; max-width: 100%;"></canvas>
            <input type="hidden" name="{{$name}}" id="inp_{{$id}}" value="" />
        </div>
        <small class="form-text text-muted">{{(isset($help)??$help)}}</small>
    </div>
    <input type="button" id="save{{$id}}" value="Save" />
    <input type="button" id="clear{{$id}}" value="clear" />
</div>

@section('scripts')
@parent
    
    <script>
    //     if( typeof SignaturePad === "undefined"){
    //         var fileref=document.createElement('script')
    //         fileref.setAttribute("type","text/javascript")
    //         fileref.setAttribute("src", filename)
    //         document.getElementsByTagName("head")[0].appendChild(fileref)
    //     }
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var signaturePad = new SignaturePad(document.getElementById('canv_{{$id}}'), {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)'
            });
            var saveButton = jQuery("#save{{$id}}")
            var cancelButton = jQuery("#clear{{$id}}")


            saveButton.on('click', function (event) {
                if (signaturePad.isEmpty()) {
                    ndis.displayMsg( "error", "Please provide signature first.", "error");
                } else {

                    ndis.ajax(
                        "{{route('admin.sign.save')}}",
                        'POST',
                        {
                            signature: signaturePad.toDataURL('image/png'),
                            user_id: {{$user_id}}
                        },
                        function(data) {
                            console.log( "msg", data )
                            // On Success
                            if( data.status ){
                                jQuery("#inp_{{$id}}").val(data.file_path);
                                saveButton.val('Saved');
                                saveButton.attr('disabled','disabled');
                                cancelButton.hide();
                                //ndis.displayMsg("success", "Good stuff! Your signature is now saved");
                            }
                            else {                                
                                ndis.displayMsg("error",  data.message );
                            }

                        },
                        function(jqXHR, textStatus) {
                            ndis.displayMsg("error", trans('errors.internal_error'));
                        }
                    );


                }

            });

            cancelButton.on('click', function (event) {
                signaturePad.clear();
            });

        });
</script>
@endsection