<?php

namespace App;

use \stdClass;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Documents extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'collection_name',
        'url',
        'size',
        's3_bucket',
        's3_key',
        'user_id',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'provider_id'
    ];


    /**
     * Relationship to user table
     */
    public function user()
    {
      return $this->belongsTo(App\User::class);
    }
    


    public static function getParticipantDocuments( $participantId ){

        // $provider = \Auth::user();
        return Documents::where('participants_details.user_id', $participantId)
                    ->leftJoin('participants_details', 'documents.user_id', '=', 'participants_details.user_id')
                    ->leftJoin('users', 'participants_details.user_id', '=', 'users.id')
                    ->leftJoin('users_to_providers', 'participants_details.user_id', '=', 'users_to_providers.user_id')
                    ->select('documents.id','documents.title','documents.mime_type','documents.local_path','documents.url','documents.size','documents.s3_key','documents.created_at')
                    ->get();
  
    }

    public static function getUserDocuments( $user_id ){

        // $provider = \Auth::user();
        return Documents::where('documents.user_id', $user_id)
                    ->leftJoin('users', 'documents.user_id', '=', 'users.id')
                    ->select('documents.id','documents.title','documents.mime_type','documents.local_path','documents.url','documents.size','documents.s3_key','documents.created_at')
                    ->get();

    }




    public static function saveDoc( \Illuminate\Http\UploadedFile $file, $docAttr = [] ){

        try{

          $fileInfo = Documents::saveFileGetInfo( $file, $docAttr['user_id'] );

          $title = ($docAttr['title'])?($docAttr['title']):'';

          //Make sure these aren't Unique Documents before uploading
          $unique_docs = config('app.unique_doc_titles');

          $document = null;
          
          if( in_array($title, $unique_docs) ){
              $document = Documents::where('title', $title)
                  ->where('user_id', $docAttr['user_id'])
                  ->where('provider_id', $docAttr['provider_id'])
                  ->first();
          }

          if(!$document){
              $document = new Documents();
              $document->title = $title;
              $document->user_id = $docAttr['user_id'];
              $document->provider_id = $docAttr['provider_id'];
          }
          
          $document->collection_name = isset($docAttr['collection_name'])?($docAttr['collection_name']):'';
          $document->mime_type = $fileInfo->mime;
          $document->local_path = isset($fileInfo->local_path)?($fileInfo->local_path):'';
          $document->s3_bucket = config('ndis.AWS_BUCKET');
          $document->s3_key = $fileInfo->filePath;
          $document->url = $fileInfo->fileURL;
          $document->size = $fileInfo->size;
          $document->save();

          return $document;
        }
        catch(Exception $error){
          return false;
        }

    }


    public static function saveFileGetInfo( \Illuminate\Http\UploadedFile $file, $user_id ){

      try{

        $fileInfo = Documents::docInfo( $file );

        $fileName = time() . '.' . $fileInfo->ext;
        
        $fileInfo->filePath = $user_id . '/' . $fileName;

        $fileInfo->fileURL = config('ndis.AWS_URL').'/'.$fileInfo->filePath;
        
        $s3Res = \Storage::disk('s3')->put( $fileInfo->filePath, file_get_contents($file), 'public');

        return $fileInfo;

      }
      catch(Exception $error){
          // return back()->withError($error->message());
          // return back()->withError('Internal Server Error Occurred!');
      }
      

    }

    public static function docInfo( \Illuminate\Http\UploadedFile $file ){
        $fileInfo = new stdClass();

        $fileInfo->path = $file->path();
        $fileInfo->ext = $file->getClientOriginalExtension();
        $fileInfo->mime = $file->getClientMimeType();
        $fileInfo->size = $file->getClientSize();
        $fileInfo->error = $file->getError();
        $fileInfo->errorMsg = $file->getErrorMessage();

        return $fileInfo;
    }

}
