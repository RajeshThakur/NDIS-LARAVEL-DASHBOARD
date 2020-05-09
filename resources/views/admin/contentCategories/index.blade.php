@extends('layouts.admin')
@section('content')
@can('content_category_create')
    {{-- <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.cms.categories.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.contentCategory.title_singular') }}
            </a>
        </div>
    </div> --}}
@endcan
<div class="card">
    {{-- <div class="card-header">
        {{ trans('cruds.contentCategory.title_singular') }} {{ trans('global.list') }}
    </div> --}}
      <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
              <h2>{{ trans('cruds.contentCategory.title_singular') }} {{ trans('global.list') }}</h2>
            </div>
            <div class="icons ml-auto order-last" id="intro_step1"  data-intro="Add to create Content Category list"> 
                <a class="btn btn-success rounded" href="{{ route("admin.cms.categories.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.contentCategory.title_singular') }}
                </a>
            </div>
          
        </div>
    </div>

    {{-- <div class="Search-Results">
        <h2>Search Results</h2>
    </div> --}}

   <div class="serchbaar mt-3"  data-step="3"  data-intro="Add to create Content Category list">
        <form action="{{ route("admin.messages.index") }}" method="GET" class="m-0" role="search">

            <div class="input-group">
                {!! 
                    Form::text('q',  '', '' )->placeholder('Search Category')->attrs(["class"=>"badge-pill bg-white"])
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
                            {{ trans('cruds.contentCategory.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.contentCategory.fields.slug') }}
                        </th>
                        {{-- <th>
                            &nbsp;
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($contentCategories as $key => $contentCategory)
                        <tr data-href="{{ route('admin.cms.categories.edit', $contentCategory->id) }}" data-entry-id="{{ $contentCategory->id }}">
                            {{-- <td>

                            </td> --}}
                            <td>
                                {{-- {{ $contentCategory->name ?? '' }} --}}
                                 <a class="icon"  href="{{ route('admin.cms.categories.edit', $contentCategory->id) }}">  {{ $contentCategory->name ?? '' }}</a>
                            </td>
                            <td>
                                <a class="icon"  href="{{ route('admin.cms.categories.edit', $contentCategory->id) }}"> {{ $contentCategory->slug ?? '' }}</a>
                            </td>
                            {{-- <td>
                                @can('content_category_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.cms.categories.show', $contentCategory->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('content_category_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.cms.categories.edit', $contentCategory->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('content_category_delete')
                                    <form action="{{ route('admin.cms.categories.destroy', $contentCategory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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