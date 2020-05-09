@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.contentPage.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.cms.pages.store") }}" method="POST" class="validated" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <label for="title">{{ trans('cruds.contentPage.fields.title') }}*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($contentPage) ? $contentPage->title : '') }}" 
                 required="required" data-rule-required="true" data-msg-required="{{ trans('errors.content_category.page_title')}}"> 
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentPage.fields.title_helper') }}
                </p>
            </div>
            
            <div class="form-group {{ $errors->has('categories') ? 'has-error' : '' }}">
                <label for="category">{{ trans('cruds.contentPage.fields.category') }}
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="categories[]" id="categories" class="form-control select2" multiple="multiple">
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || isset($contentPage) && $contentPage->categories->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <em class="invalid-feedback">
                        {{ $errors->first('categories') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentPage.fields.category_helper') }}
                </p>
            </div>

            <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
                <label for="tag">{{ trans('cruds.contentPage.fields.tag') }}
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                <select name="tags[]" id="tags" class="form-control select2" multiple="multiple">
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || isset($contentPage) && $contentPage->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <em class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentPage.fields.tag_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('page_text') ? 'has-error' : '' }}">
                <label for="page_text">{{ trans('cruds.contentPage.fields.page_text') }}</label>
                <textarea id="page_text" name="page_text" class="form-control ckeditor">{{ old('page_text', isset($contentPage) ? $contentPage->page_text : '') }}</textarea>
                @if($errors->has('page_text'))
                    <em class="invalid-feedback">
                        {{ $errors->first('page_text') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentPage.fields.page_text_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                <label for="excerpt">{{ trans('cruds.contentPage.fields.excerpt') }}</label>
                <textarea id="excerpt" name="excerpt" class="form-control ">{{ old('excerpt', isset($contentPage) ? $contentPage->excerpt : '') }}</textarea>
                @if($errors->has('excerpt'))
                    <em class="invalid-feedback">
                        {{ $errors->first('excerpt') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentPage.fields.excerpt_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('featured_image') ? 'has-error' : '' }}">
                <label for="featured_image">{{ trans('cruds.contentPage.fields.featured_image') }}</label>
                <div class="needsclick dropzone" id="featured_image-dropzone">

                </div>
                @if($errors->has('featured_image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('featured_image') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.contentPage.fields.featured_image_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-success rounded mt-4" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.featuredImageDropzone = {
    url: '{{ route('admin.cms.pages.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4086,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="featured_image"]').remove()
      $('form').append('<input type="hidden" name="featured_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      $('form').find('input[name="featured_image"]').remove()
      this.options.maxFiles = this.options.maxFiles + 1
    },
    init: function () {
@if(isset($contentPage) && $contentPage->featured_image)
      var file = {!! json_encode($contentPage->featured_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="featured_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@stop