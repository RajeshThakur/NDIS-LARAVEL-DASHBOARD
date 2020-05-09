<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\ContentTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentTagRequest;
use App\Http\Requests\UpdateContentTagRequest;

class ContentTagApiController extends Controller
{
    public function index()
    {
        $contentTags = ContentTag::all();

        return $contentTags;
    }

    public function store(StoreContentTagRequest $request)
    {
        return ContentTag::create($request->all());
    }

    public function update(UpdateContentTagRequest $request, ContentTag $contentTag)
    {
        return $contentTag->update($request->all());
    }

    public function show(ContentTag $contentTag)
    {
        return $contentTag;
    }

    public function destroy(ContentTag $contentTag)
    {
        $contentTag->delete();

        return response("OK", 200);
    }
}
