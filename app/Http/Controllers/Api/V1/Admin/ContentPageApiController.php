<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\ContentPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentPageRequest;
use App\Http\Requests\UpdateContentPageRequest;

class ContentPageApiController extends Controller
{
    public function index()
    {
        $contentPages = ContentPage::all();

        return $contentPages;
    }

    public function store(StoreContentPageRequest $request)
    {
        return ContentPage::create($request->all());
    }

    public function update(UpdateContentPageRequest $request, ContentPage $contentPage)
    {
        return $contentPage->update($request->all());
    }

    public function show(ContentPage $contentPage)
    {
        return $contentPage;
    }

    public function destroy(ContentPage $contentPage)
    {
        $contentPage->delete();

        return response("OK", 200);
    }
}
