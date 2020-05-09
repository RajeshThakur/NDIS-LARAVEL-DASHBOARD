
    <script type="text/html" id="tmpl-repeater">
        <fieldset class="position-relative">

        @if ("<%= data.count %>" !== 0)
        <div class="row remove-reg">
            <div class="">
                    <span class="close-icon reg_grp_item_remove"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </div>
        </div>
        @endif

        <div class="row reg_grp_item" rel="<%= data.count %>">

            <div class="col-sm-12 form-group mb-2">
                <label>{{ trans('global.provider.reg_state') }}</label>
                <div class='input-group'>
                    {!! App\Http\Controllers\Traits\Common::getStates('state[<%=data.count%>]','state_<%=data.count%>')  !!}
                    <i class='inputicon fa fa-caret-down' aria-hidden='true'></i>
                </div>
            </div>

            
            {!! registration_group_dd( "parent_reg_group[<%=data.count%>]", "parent_reg_group_<%=data.count%>",'in_house[<%=data.count%>]', 'in_house_<%=data.count%>' )  !!}
        

        </div> <!-- end of .reg_grp_item -->
    </fieldset>
    </script>