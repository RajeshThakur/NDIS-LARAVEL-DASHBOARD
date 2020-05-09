<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;

use App\Notifications\DocumentUploaded;
use Carbon\Carbon;

class DocumentsApiController extends Controller
{
    use Notifiable;

    /**
     * upload user document
     *
     * @return mixed docid and status
     * 
     */
    public function upload( Request $request )
    {
        $messages = [
            'document.required' => 'Upload a document.',
            'document.title' => 'Document title is required.',
        ];

        $data = Validator::make($request->all(),[
            'document' => 'required | file | mimes:jpg,jpeg,bmp,png,pdf,doc,docx,xls,xlsx',
            'title'     => 'required'
        ], $messages);

        if($data->fails()):
            return response()->json(['status'=>false,'error'=>$data->messages()], 400);
        endif;

        $file = $request->file('document');
        // $user_id = \Auth::id();
        $user = \Auth::User();
        $provider = \App\User::find($user->getUserProviders()->first()->provider_id);
        
        try {
            $document = \App\Documents::saveDoc( $file, [
                                            'title'=> trim($request->title),
                                            'user_id'=>$user->id,
                                            'provider_id'=>1,
                                        ]);

            $notification_data['title'] = $document->title;
            $notification_data['user'] = $user->id;

            if( isset($document->url) ){

                $provider->notify(new DocumentUploaded( $notification_data ));

                return response()->json([ "status"=>true, "document_id" => $document->id, 'file_url'=>$document->url ], 200);
            }else {
                return response()->json([ "status"=>false, "error" => $document ], 400);
            }
        }
        catch(Exception $exception) {
            return reportAndRespond($exception, 400);
        }
       
    }
}
