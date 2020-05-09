<?php

namespace App\Http\Controllers\Admin;

use App\ContentTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentTagRequest;
use App\Http\Requests\UpdateContentTagRequest;

class ContentTagController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('content_tag_access'), 403);

        $contentTags = ContentTag::all();

        return view('admin.contentTags.index', compact('contentTags'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('content_tag_create'), 403);

        return view('admin.contentTags.create');
    }

    public function store(StoreContentTagRequest $request)
    {
        abort_unless(\Gate::allows('content_tag_create'), 403);

        $contentTag = ContentTag::create($request->all());

        return redirect()->route('admin.cms.tags.index')->with('success',  trans('msg.content_tag_add.success') );
    }

    public function edit(ContentTag $contentTag, $id)
    {
        abort_unless(\Gate::allows('content_tag_edit'), 403);

        $contentTag = $contentTag->find($id);

        return view('admin.contentTags.edit', compact('contentTag'));
    }

    public function update(UpdateContentTagRequest $request, ContentTag $contentTag, $id)
    {
        abort_unless(\Gate::allows('content_tag_edit'), 403);

        $contentTag->where('id',$id)
                        ->update(['name'=>$request->name, 'slug'=>$request->slug]);

        return redirect()->route('admin.cms.tags.index')->with('success',  trans('msg.content_tag_update.success') );
    }

    public function show(ContentTag $contentTag, $id)
    {
        abort_unless(\Gate::allows('content_tag_show'), 403);

        $contentTag = $contentTag->find($id);

        return view('admin.contentTags.show', compact('contentTag'));
    }

    public function destroy(ContentTag $contentTag, $id)
    {
        abort_unless(\Gate::allows('content_tag_delete'), 403);

        $contentTag->destroy($id);

        // return back();
        return redirect()->route('admin.cms.tags.index')->with('success',  trans('msg.content_tag_delete.success') );
    }

  
}
