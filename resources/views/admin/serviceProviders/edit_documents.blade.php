
<div>
    <div class="participant-opforms form-mt">
            {{-- <div class="card-header">
                {{ trans('supportWorkers.fields.opforms_title') }}
            </div> --}}
        <div class="table-responsive">
            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                                <th>
                                    Title 
                                </th>
                                <th>
                                    Date
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($opforms->count())
                            @foreach($opforms as $key => $form)
                                <tr data-entry-id="{{ $form->id }}">
                                    <td>
                                        <a href="{{ route('admin.forms.edit', [$form->id, $isParticipantTrue=2]) }}">{{ $key + 1 }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.forms.edit', [$form->id, $isParticipantTrue=2]) }}">{{ $form->optitle }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.forms.edit', [$form->id, $isParticipantTrue=2]) }}">{{ $form->date }}</a>
                                    </td>
                                </tr>
                            @endforeach
                      @else
                        <tr>
                            <td colspan="8" class="text-center">
                                No Records Found!
                            </td>
                        </tr>
                    @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    