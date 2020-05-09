
    @foreach ($childGroups as $childGroup)
        <tr>
            <td>
                {{$childGroup->parent->title}}
            </td>
            <td>
                {{$childGroup->title}}
            </td>
            <td>
                {!! 
                    isset($participantItems[$childGroup->id]) ? $participantItems[$childGroup->id]['anual'] : ''
                !!}

            </td>
            <td>
                {!!
                    isset($participantItems[$childGroup->id])?$participantItems[$childGroup->id]['monthly']:'' 
                !!}
            </td>
            <td>
                {!!
                    isset($participantItems[$childGroup->id])?$participantItems[$childGroup->id]['frequency']: old('frequency')
                !!}
            </td>
            <td>NDIS</td>
            <td>
                {{$childGroup->item_number}}
            </td>
        </tr>
    @endforeach