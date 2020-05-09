@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        
        {{ trans('global.provider.reg_edit') }}

    </div>

    <div class="card-body">

        <form action="{{ route('admin.users.reg.update') }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- {!! registration_group_edit_dd( $regGrps ) !!} --}}

            <div class="row table-view">
                
                <table class="table table-bordered table-striped table-hover datatable dataTable no-footer reg_price_table no-pointer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                    <thead>
                        <tr>
                            <th>
                                State
                            </th>
                            <th>
                                Registration Group
                            </th>
                            <th>
                                Price Limit
                            </th>
                            <th>
                                Amount to Pay to Support Worker
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @if($providerRegGroups && !empty($providerRegGroups))
                            <?php $currentItem = 0; ?>
                            @foreach($providerRegGroups as $key=>$providerRegGrp  )
                                
                            @if( $providerRegGrp->parent_id != $currentItem )
                                    <tr>
                                        <th colspan="4">
                                            {{ regGroupById($providerRegGrp->parent_id)->title }}
                                        </th>
                                    </tr>
                                @endif

                                <?php $currentItem = $providerRegGrp->parent_id; ?>
                                <tr>
                                    <td>
                                        {{ $providerRegGrp->short_name }}
                                    </td>
                                    <td>
                                        {{ $providerRegGrp->title }}
                                    </td>
                                    <td>
                                        {{ $providerRegGrp->price_limit }}
                                    </td>
                                    <td>
                                        <input type="number" class="form-control entered_price" name="reg_groups[{{$key}}][cost]" min="1" max="{{$providerRegGrp->price_limit}}"
                                            value="{{$providerRegGrp->cost}}" required>
                                        <span class="">/ {{$providerRegGrp->unit}}</span>
                                    </td>
                                    <input type="hidden" name="reg_groups[{{$key}}][state_id]" value="{{$providerRegGrp->state_id}}" />
                                    <input type="hidden" name="reg_groups[{{$key}}][reg_group_id]" value="{{$providerRegGrp->id}}" />
                                    <input type="hidden" name="reg_groups[{{$key}}][parent_reg_group_id]" value="{{$providerRegGrp->parent_id}}" />
                                </tr>
                            @endforeach
                        @endif

                        
                    </tbody>

                </table>
                
                
                



            </div>            
            
            <div class="register-group-page mt-4">
                <button class="btn btn-success rounded" type="submit" value="{{ trans('global.save') }}">Save</button>
            </div>

        </form>

    </div>
</div>

@endsection


@section('scripts')
@parent
<script>
   jQuery(document).ready(function(){
        
        // $('.card-body').on('change','.state_group', function(){            

        //     $("#parent_group option").each(function(i,val){
               
        //         if($('#reg_state :selected').val() == $(val).data('state')){
        //             $(val).show();
        //         }else{
        //             $(val).hide();
        //         }
    
        //     });

        //     $('.limit_cost').each(function(i,val){
        //         if($('#reg_state :selected').val() == $(val).data('relstate')){
        //             $(this).parent().parent().parent().parent().show();
        //         }else{
        //             $(this).parent().parent().parent().parent().hide();
        //         }
                
        //     });


        // });


        // $("input#reg_grps").click(function(){

        //     $("div.row.child-grps").toggle();
        // });


        // $('.card-body').on('change','#parent_group',function(){

        //     var partentID = $('#parent_group :selected').val();
            
        //     $('.limit_cost').each(function(i,val){
        //         if(partentID == $(val).data('relparent')){
        //             $(this).parent().parent().parent().parent().show();
        //         }else{
        //             $(this).parent().parent().parent().parent().hide();
        //         }
                
        //     });

        // });

        $('.card-body').on('input', '.entered_price', function(e) {
            //console.log($(this).parent().parent().find('td.price_limit').text());
            var enterCost = $(this).val();
            //console.log(enterCost);
            var cost_limit = $(this).parent().parent().find('td.price_limit').text();
            
            if(parseFloat(enterCost) > parseFloat(cost_limit)){
                $(this).focus();
                $(this).val('');
                alert('Enter the amount less than price limit');
            }
           
        });

   });
   
</script>
@endsection
