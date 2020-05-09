<?php

namespace App\Http\Controllers\Admin;

use App\ContentCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentCategoryRequest;
use App\Http\Requests\UpdateContentCategoryRequest;

class ContentCategoryController extends Controller
{
    public function index()
    {
        abort_unless(\Gate::allows('content_category_access'), 403);

        $contentCategories = ContentCategory::all();

        return view('admin.contentCategories.index', compact('contentCategories'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('content_category_create'), 403);

        return view('admin.contentCategories.create');
    }

    public function store(StoreContentCategoryRequest $request)
    {
        abort_unless(\Gate::allows('content_category_create'), 403);

        $contentCategory = ContentCategory::create($request->all());

        return redirect()->route('admin.cms.categories.index')->with('success',  trans('msg.content_category_add.success') );
    }

    public function edit(ContentCategory $contentCategory, $id)
    {
        abort_unless(\Gate::allows('content_category_edit'), 403);
        
        $contentCategories = ContentCategory::find($id);
        //d($contentCategories->name);
        return view('admin.contentCategories.edit', compact('contentCategories'));
    }

    public function update(UpdateContentCategoryRequest $request, ContentCategory $contentCategory, $id)
    {
        abort_unless(\Gate::allows('content_category_edit'), 403);
        
        $contentCategory->where('id',$id)
                        ->update(['name'=>$request->name, 'slug'=>$request->slug]);

        return redirect()->route('admin.cms.categories.index')->with('success',  trans('msg.content_category_update.success') );
    }

    public function show(ContentCategory $contentCategory, $id)
    {
        abort_unless(\Gate::allows('content_category_show'), 403);

        $contentCategory = ContentCategory::find($id);
        
        return view('admin.contentCategories.show', compact('contentCategory'));
    }

    public function destroy(ContentCategory $contentCategory, $id)
    {
        abort_unless(\Gate::allows('content_category_delete'), 403);
    
        $contentCategory->destroy($id);

        return redirect()->route('admin.cms.categories.index')->with('success',  trans('msg.content_category_delete.success') );
    }


}
