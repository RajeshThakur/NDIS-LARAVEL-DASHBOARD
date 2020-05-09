<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Documents;


class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('registration_group_access'), 403);

        $documents = RegistrationGroup::all();

        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        
        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageName]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate([
                                    'title' => 'required|max:255',
                                    'file' => 'required',
                                    'user_id' => 'required'
                                ],[
                                    'title.required' => 'A title is required',
                                    'file.required' => 'document must be uploaded',
                                    'user.required' => trans('errors.internal_error'),
                                ]);

        $file = $request->file('file');
        $title = $data['title'];
        $user_id = $data['user_id'];

        $provider = \Auth::user();

        $document = Documents::saveDoc( $file, [
                                                'title'=>$title,
                                                'user_id'=>$user_id,
                                                'provider_id'=>$provider->id,
                                                ]);

        return response()->json([ "success"=>true, "id"=>$document->id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function show(documents $documents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function edit(documents $documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, documents $documents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\documents  $documents
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, documents $documents )
    {
        $filename =  $request->get('filename');
        ImageUpload::where('filename',$filename)->delete();
        $path=public_path().'/images/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }



}
