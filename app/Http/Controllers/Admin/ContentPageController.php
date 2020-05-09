<?php

namespace App\Http\Controllers\Admin;

use App\ContentCategory;
use App\ContentPage;
use App\ContentTag;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreContentPageRequest;
use App\Http\Requests\UpdateContentPageRequest;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PolicyUpdated;


class ContentPageController extends Controller
{
    use MediaUploadingTrait, Notifiable;

    public function index()
    {
        abort_unless(\Gate::allows('content_page_access'), 403);

        $contentPages = ContentPage::all();

        return view('admin.contentPages.index', compact('contentPages'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('content_page_create'), 403);
        
        $categories = ContentCategory::all()->pluck('name', 'id');

        $tags = ContentTag::all()->pluck('name', 'id');

        return view('admin.contentPages.create', compact('categories', 'tags'));
    }

    public function store(StoreContentPageRequest $request)
    {
        abort_unless(\Gate::allows('content_page_create'), 403);

        $contentPage = ContentPage::create($request->all());
        $contentPage->categories()->sync($request->input('categories', []));
        $contentPage->tags()->sync($request->input('tags', []));

        if ($request->input('featured_image', false)) {
            $contentPage->addMedia(storage_path('tmp/uploads/' . $request->input('featured_image')))->toMediaCollection('featured_image');
        }

        return redirect()->route('admin.cms.pages.index')->with('success',  trans('msg.content_page_add.success') );
    }

    public function edit(ContentPage $contentPage, $id)
    {
        abort_unless(\Gate::allows('content_page_edit'), 403);

        $categories = ContentCategory::all()->pluck('name', 'id');

        $tags = ContentTag::all()->pluck('name', 'id');

        $contentPage = $contentPage->find($id);
        //dd($contentPage);
        return view('admin.contentPages.edit', compact('categories', 'tags', 'contentPage'));
    }

    public function update(UpdateContentPageRequest $request, ContentPage $contentPage, $id)
    {
        abort_unless(\Gate::allows('content_page_edit'), 403);
        
        $contentPage = ContentPage::whereId($id)->first();
        $contentPage->update($request->all());
        $contentPage->categories()->sync($request->input('categories', []));
        $contentPage->tags()->sync($request->input('tags', []));

        if ($request->input('featured_image', false)) {
            if (!$contentPage->featured_image || $request->input('featured_image') !== $contentPage->featured_image->file_name) {
                $contentPage->addMedia(storage_path('tmp/uploads/' . $request->input('featured_image')))->toMediaCollection('featured_image');
            }
        } elseif ($contentPage->featured_image) {
            $contentPage->featured_image->delete();
        }

        $providers = \App\User::ProviderUsers();
        Notification::send($providers, new PolicyUpdated($contentPage));

        return redirect()->route('admin.cms.pages.index')->with('success',  trans('msg.content_page_update.success') );
    }

    public function show(ContentPage $contentPage, $id)
    {
        abort_unless(\Gate::allows('content_page_show'), 403);
        $contentPage = $contentPage->find($id);
        $contentPage = $contentPage->load('categories', 'tags');
        
        return view('admin.contentPages.show', compact('contentPage'));
    }

    public function destroy(ContentPage $contentPage, $id)
    {
        abort_unless(\Gate::allows('content_page_delete'), 403);

        $contentPage->destroy($id);

        // return back();
        return redirect()->route('admin.cms.pages.index')->with('success',  trans('msg.content_page_delete.success') );
    }



    public function searchBySlug(ContentCategory $categories, $slug)
    {

        $slug = slugify($slug);
        
        $categories = ContentCategory::where('slug', $slug)->get();
        
        if(isset($categories['0'])) {

            $categories = $categories['0']->pages;

            $contentPages = ContentPage::where('id',$categories[0]->pivot->content_page_id)->get();

        } else {

            $contentPages = ContentPage::where('slug', $slug)->get();
            
        }
        
        // dd($categories);
        


        return view('admin.contentPages.index', compact('contentPages'));

    }
}
