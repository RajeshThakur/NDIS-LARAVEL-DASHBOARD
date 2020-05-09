<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait SignatureTrait
{

    /**
     * Save Signature
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSign(Request $request)
    {
        try{
            $signature = new \App\Signature;
        
            $signature = \App\Signature::where('user_id', $request->input('user_id'))->first();
            
            if(!$signature){
                $signature = new \App\Signature;
                $signature->user_id = $request->input('user_id');
            }
            
            $data_uri = $request->signature;
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);

            $sig = md5(  time() . $signature->user_id ) . "_signature.png";

            $filePath ='/sign/'.$sig;
        
            $s3Res = \Storage::disk('s3')->put( $filePath, $decoded_image, 'public');

            $fileURL = config('ndis.AWS_URL').$filePath;

            // // Storage::put($folder, $sig);
            // \Storage::disk('local')->put($file_path, $decoded_image);
            if($s3Res){
                
                $signature->url = $fileURL;

                $signature->save();
            
                return response()->json([
                    'status'     => true,
                    'file_path'  => $fileURL,
                    'sign_id' => $signature->id
                ]);
            } else {

                return response()->json([
                    'status'     => false,
                    'message'  => 'Opps something wrong happen try again.',
                    'sign_id' => $signature->id
                ]);
            }
            
        }
        catch(Exception $e){
            return response()->json([
                'status'          => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }

}
