
    @foreach ($childGroups as $childGroup)
        <tr id="grp-{{$childGroup->id}}">
            <td>
                {{$childGroup->parent->title}}
            </td>
            <td>
                {{$childGroup->title}}
            </td>
            <td>
                {!!
                    Form::text('regGrp_anual['.$childGroup->id.']', '',  isset($participantItems[$childGroup->id])?$participantItems[$childGroup->id]['anual']:'' )
                    ->id('grp-anual-'.$childGroup->id)
                    ->attrs(['style'=>'width:150px;'])
                    ->required()
                    ->hideLabel()
                !!}

            </td>
            <td>
                {!!
                    Form::text('regGrp_monthly['.$childGroup->id.']', '',  isset($participantItems[$childGroup->id])?$participantItems[$childGroup->id]['monthly']:'' )
                    ->id('grp-monthly-'.$childGroup->id)
                    ->attrs(['style'=>'width:150px;'])
                    ->required()
                    ->hideLabel()
                !!}
            </td>
            <td>
                {!!
                    Form::select(
                                'regGrp_frequency['.$childGroup->id.']', 
                                '',
                                config("ndis.forms.frequency"),
                                isset($participantItems[$childGroup->id])?$participantItems[$childGroup->id]['frequency']: old('frequency')                 )
                        ->id('grp-frequency-'.$childGroup->id)
                        ->required()
                !!}
            </td>
            <td>NDIS</td>
            <td>
                {{$childGroup->item_number}}
            </td>
        </tr>
    @endforeach