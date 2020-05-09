<script type="text/html" id="tmpl-repeater">
    <tr class="availability_row edit" id="availability_<%=data.count%>">
        <td>
            <div class="row mb-3 text-left rangeplaceholder"></div>
            {!!
                Form::select('range', 'Range', $availabiltyRange, '')
                    ->id('range')
                    ->required('required')
                    ->hideLabel()
                    ->attrs(['class'=>'range'])
                    ->size('col-sm-12');
            !!}
        </td>
        <td >
            <div class="row mb-3 text-center inputplaceholder">
                From {{(isset($availability->from) ? $availability->from : 'N/A')}} - {{isset($availability->to) ? $availability->to : 'N/A'}}
            </div>
            <div class="row input-group mb-3 bg-select">
                {!!
                    Form::time('availability[][from]', '', '')
                        ->id('availability__from')
                        ->placeholder('From')
                        ->required('required')
                        ->attrs(['class'=>'from'])
                        ->hideLabel()
                        ->size('col-sm-6');
                !!}
                {!!
                    Form::time('availability[][to]', '', '')
                        ->id('availability__to')
                        ->placeholder('To')
                        ->required('required')
                        ->attrs(['class'=>'to'])
                        ->hideLabel()
                        ->size('col-sm-6');
                !!}
            </div>
        </td>
        <td>
            <div class="edit-remove">
                <a class="save" href="javascript://"><span>Save</span></a>
                <a class="edit" href="javascript://"><span><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                <a class="remove" href="javascript://"><span><i class="fa fa-trash-o" aria-hidden="true"></i></span></a>
            </div>
        </td>
    </tr>
</script>

@section('scripts')
@parent

<script>
    jQuery(document).ready(function() {
        

        jQuery("#addAvailability").on('click', function(ev){
            ev.preventDefault();
            var rowCount = jQuery(".table .availability_row").length;
            var template = ndis.template('repeater');
            var html     = template({count:rowCount});
        
            jQuery(".table tbody").append( html );

            // update Id's for the Fields
            jQuery('.table').find("#dm-availability__from").attr( {'id':"dm-availability_"+rowCount+"_from"} );
            jQuery('.table').find("#dm-dm-availability__to").attr( {'id':"dm-availability_"+rowCount+"_to"} );
            jQuery('.table').find("#availability__from").attr( {'id':"availability_"+rowCount+"_from", 'data-target':"#availability_"+rowCount+"_from" } );
            jQuery('.table').find("#availability__to").attr( {'id':"availability_"+rowCount+"_to", 'data-target':"#availability_"+rowCount+"_to" } );
            jQuery('.table').find("#range").attr( {'id':"range_"+rowCount} );

            ndis.defaultAlways();
        });


        jQuery(".table").on('click', '.availability_row .edit', function(ev){
            var row = jQuery(this).closest('.availability_row');
            row.addClass('edit');
        });
        
        jQuery(".table").on('click', '.availability_row .save', function(ev){
            ev.preventDefault();
            var _this = jQuery(this);
            var row = _this.closest('.availability_row');
            var rowId = row.attr('id');

            var rangeEl = $( "#"+rowId ).find('.range');
            var fromEl = $( "#"+rowId ).find('.from');
            var toEl = $( "#"+rowId ).find('.to');
            var ava_id = ($( "#"+rowId ).attr('data-id') !== undefined)?$( "#"+rowId ).attr('data-id'):0;
            
            var valObj = { user_id: {{$participant->user_id}}, type: 'participant', range: rangeEl.val(), from: fromEl.val(), to: toEl.val(), availability_id:ava_id };

            //Validate if time is selected
            if( ! moment( valObj.from,  'h:mm a', true).isValid() ){
                fromEl.addClass('error');
                return;
            }
            else
                fromEl.removeClass('error')

            if( ! moment( valObj.to,  'h:mm a', true).isValid() ){
                toEl.addClass('error');
                return;
            }
            else
                toEl.removeClass('error')
            

            
            // Validate the time validaity
            var time_from = moment( valObj.from,  'h:mm a');
            var time_to = moment( valObj.to,  'h:mm a');

            if( ! time_from.isBefore(time_to) ){
                fromEl.addClass('error');
                toEl.addClass('error');
                ndis.displayMsg('error', 'Start time should be lower than End time!');
                return;
            }
            
            ndis.addLoader(_this);
            ndis.ajax(
                "{{route('admin.availability.save')}}",
                'post',
                valObj,
                function(data){
                    if(!data.status){
                        ndis.displayMsg('error', data.message);
                    }
                    else{
                        $( "#"+rowId ).attr( 'data-id', data.availability_id );
                        $( "#"+rowId+' .rangeplaceholder' ).html( rangeEl.val() );
                        $( "#"+rowId+' .inputplaceholder' ).html( "From "+fromEl.val()+" - "+toEl.val() );
                        row.removeClass('edit');
                        
                        ndis.displayMsg('success', data.message);
                        
                        ndis.removeLoader(_this);
                    }
                }
            );

        });
        
        jQuery(".table").on('click', '.availability_row .remove', function(ev){
            ev.preventDefault();
            var _this = jQuery(this);
            var row = _this.closest('.availability_row');

            if( confirm("Are you sure, you want to delete this availbility?" ) ){
                ndis.addLoader(_this);

                var ava_id = (row.attr('data-id') !== undefined)?row.attr('data-id'):0;
                var valObj = { user_id: {{$participant->user_id}}, availability_id:ava_id };

                ndis.ajax(
                    "{{route('admin.availability.destroy')}}",
                    'delete',
                    valObj,
                    function(data){
                        if(!data.status){
                            ndis.displayMsg('error', data.message);
                        }
                        else{
                            row.remove();
                            ndis.displayMsg('success', data.message);
                        }

                    }
                );
            }
        })
    });
</script>

@endsection