@extends('layouts.admin')
@section('content')

<div class="opform-content">
    @include( 'admin.operationalForms.template.'.$templateId  )
</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script>
    $(document).ready(function(){

        var count_registration_groups_selected_options = $("#registration_groups :selected").length;
        $('.count_registration_groups_selected_options').text(count_registration_groups_selected_options);

        $('select#registration_groups').on('change', function () {
            var count_registration_groups_selected_options = $("option:selected", this).length;
            $('.count_registration_groups_selected_options').text(count_registration_groups_selected_options);
            // console.log(count_registration_groups_selected_options);
        });
        // console.log(count_childitems_option_selected);
        
        $('select#registeration_group').on('change', function (e) {

            var budget_table = $('#reg_budget tbody');
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            
            var count_selected_options = $("option:selected", this).length; 
            $('.count_selected_options').text( count_selected_options );
            // console.log(count_selected_options);
            $.each($('#reg_budget tbody tr'), function(key, v){
        
                var true_false = 0;
                
                if (optionSelected.length == 0){
                    $(this).remove();
                }

                $.each(optionSelected, function(i,val){    
                    if( $(this).data('reg_id') != $(val).val() )
                        true_false = 1;
                });
                
                if(true_false)
                    $(this).remove();

            });
            
        });

        $('select#childitems').on('change', function (e) {
            var count_selected_options_ = $("option:selected", this).length;
            $('.childitems_count_selected_options').text(count_selected_options_);
            // console.log(count_selected_options_);
        });

       

        
    });
    </script>
    @if($templateId == 11)
    <script>
            $(document).ready(function(ev){
                
                function loadRegItems(e){
                    var parentGrp = [];
                    var childGrp = [];

                    $("select#registeration_group :selected").each(function(i, val){
                        parentGrp.push($(this).val());
                    });

                    $("select#childitems :selected").each(function(i, val){
                        childGrp.push($(this).val());
                    });
                    
                    var user_id_val = jQuery("#user_id_val").val();

                    if(childGrp.length) {

                        ndis.ajax(
                            "{{route('admin.sa.reg.table')}}",
                            'POST',
                            {'parentGrp':parentGrp, 'childGrp':childGrp, 'user_id':user_id_val },
                            function(data){
                                if(!data.status){
                                    ndis.displayMsg('error', data.message);
                                }
                                else{
                                    jQuery("table#reg_budget tbody").html(data.html);
                                }
                            },
                            function(jqXHR, textStatus){
                            
                            }
                        );
                    }
                    
                }

                function loadRegItemsSelection(e){
                    
                    var parentGrp = [];
                    var childItems = [];
                    var ttchild =0;

                    $("select#registeration_group :selected").each(function(i, val){
                        parentGrp.push(+$(this).val());
                    });

                    $("select#childitems :selected").each(function(i, val){
                        childItems.push(parseInt($(this).val()));
                    });
                    
                    var user_id_val = jQuery("#user_id_val").val();

                    if(parentGrp.length){
                        $('#childitems').find('option').remove();
                        ndis.ajax(
                            "{{route('admin.sa.reg.items')}}",
                            'POST',
                            {'parentGrp':parentGrp, 'user_id':user_id_val },
                            function(data){
                                if(!data.status){
                                    ndis.displayMsg('error', data.message);
                                }
                                else{
                                    // $('#childitems').find('option').remove();
                                    $(data.childItems).each(function(i,val){ 
                                        // $('#childitems').append($("<option></option>").attr("value",val.id).attr('data-parentId',val.parent_id).text(val.title));
                                        if(childItems.indexOf(parseInt(val.id)) >= 0)
                                            $('#childitems').append($("<option selected></option>").attr("value",val.id).attr('data-parentId',val.parent_id).text(val.title));
                                        else
                                            $('#childitems').append($("<option></option>").attr("value",val.id).attr('data-parentId',val.parent_id).text(val.title));
                                    });
                                }
                            },
                            function(jqXHR, textStatus){
                            
                            }
                        );
                    }else{
                        $('#childitems').find('option').remove();
                    }

                    $("select#childitems :selected").each(function(i, val){
                        ttchild++;
                    });
                    $('.childitems_count_selected_options').text(ttchild);
                    
                }

                loadRegItems(ev);

                $('.content').on( 'change', 'select#registeration_group', function(e){
                    
                    loadRegItemsSelection(e);
                    loadRegItems(e);
                    
                });

                $('.content').on( 'change', 'select#childitems', function(e){
                    loadRegItems(e);
                });

                $('.new-agreement-table').keyup ( '[name="regGrp_anual[]"]',function(e){
                    // e.preventDefault();
                    let annual = $(e.target);
                    if( (annual[0].id).indexOf('grp-anual-') == -1)
                    return;
                    let annualInput = $('#'+annual[0].id);
                    let mounthlyInput = annualInput.closest('td').next('td').find('input')[0].id;
                    let monthlyVal = annualInput.val() / 12;
                    $('#'+mounthlyInput).val(monthlyVal.toFixed(2));
                })

            });
    </script>
    @endif

@endsection
