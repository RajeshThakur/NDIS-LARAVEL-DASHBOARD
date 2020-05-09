@extends('layouts.admin')
@section('content')
@can('content_page_create')
    {{-- <div style="margin-bottom: 10px;" class="row">
         <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.cms.pages.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.contentPage.title_singular') }}
            </a>
        </div> 
    </div> --}}
@endcan
<div class="card">
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>{{ trans('cruds.contentPage.title_singular') }} {{ trans('global.list') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create Content Page list">
                <a class="btn btn-success rounded" href="{{ route("admin.cms.pages.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.contentPage.title_singular') }}
                </a>
            </div>
        </div>
    </div>
    {{-- <div class="card-header">
        <div class="row">
            <div class="pageTitle">
                <h2>User List</h2>
            </div>
            <div class="icons ml-auto order-last">
                <a class="btn btn-success hint--top rounded" aria-label="Add Participant" href="http://localhost:8000/admin/users/create">Add User</a>
            </div>
        </div>
    </div> --}}
    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

   <div class="serchbaar mt-3" id="intro_step2"  data-intro="Add to create Content Page list">
        <form action="{{ route("admin.messages.index") }}" method="GET" class="m-0" role="search">

            <div class="input-group">
                {!! 
                    Form::text('q',  '', '' )->placeholder('Search Pagelist')->attrs(["class"=>"badge-pill bg-white"])
                !!}
                 <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"><img class="search" src="{{url('img/search.png')}}" alt="NDIS" /></span>
                    </button>
                </span>
            </div>

        </form>
    </div>

    <div class="card-body" data-step="2" data-intro="Chouse any list">
        <div class="table-responsive cursor-custom">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        {{-- <th width="10">

                        </th> --}}
                        <th>
                            {{ trans('cruds.contentPage.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.contentPage.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.contentPage.fields.tag') }}
                        </th>
                        <th>
                            {{ trans('cruds.contentPage.fields.excerpt') }}
                        </th>
                        <th>
                            {{ trans('cruds.contentPage.fields.featured_image') }}
                        </th>
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($contentPages as $key => $contentPage)
                        <tr data-href="{{ route('admin.cms.pages.edit', $contentPage->id) }}" data-entry-id="{{ $contentPage->id }}">
                            {{-- <td>

                            </td> --}}
                            <td>
                                  <a class="icon" href="{{ route('admin.cms.pages.edit', $contentPage->id) }}">{{ $contentPage->title ?? '' }}</a>
                            </td>
                            <td>
                                  <a class="icon" href="{{ route('admin.cms.pages.edit', $contentPage->id) }}"> @foreach($contentPage->categories as $key => $item)
                                    <span class="icon">{{ $item->name }}</span>
                                @endforeach
                                  </a>
                            </td>
                            <td>
                                  <a class="icon" href="{{ route('admin.cms.pages.edit', $contentPage->id) }}"> @foreach($contentPage->tags as $key => $item)
                                    <span class="">{{ $item->name }}</span>
                                @endforeach
                                  </a>
                            </td>
                            <td>
                                  <a class="icon" href="{{ route('admin.cms.pages.edit', $contentPage->id) }}"> {{ $contentPage->excerpt ?? '' }}</a>
                            </td>
                            <td>
                                @if($contentPage->featured_image)
                                    <a href="{{ $contentPage->featured_image->getUrl() }}" target="_blank">
                                        <img src="{{ $contentPage->featured_image->getUrl('thumb') }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>


                            {{-- <td>
                                @can('content_page_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.cms.pages.show', $contentPage->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('content_page_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.cms.pages.edit', $contentPage->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('content_page_delete')
                                    <form action="{{ route('admin.cms.pages.destroy', $contentPage->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td> --}}

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {

    $('*[data-href]').on("click",function(){
    window.location = $(this).data('href');
    return false;
    });
    $("td > a").on("click",function(e){
    e.stopPropagation();
    });

})

</script>
@endsection