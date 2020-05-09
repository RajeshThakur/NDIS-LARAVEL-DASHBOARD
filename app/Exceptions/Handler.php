<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use App\Http\Controllers\Traits\RestTrait;

class Handler extends ExceptionHandler
{
    
    use RestTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)){
            app('sentry')->captureException($exception);
        }
        parent::report($exception);
    }



    private function apiExceptionHandler($request, $exception){
        
        if ($exception instanceof ModelNotFoundException) {
            apiError( 'Record not found!', 401);
        }
        else if ($exception instanceof \Illuminate\Database\QueryException) {
            return reportAndRespond($exception, 401);
        }
        else if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return apiError( "unauthorized!", 403);
        }
        else{
            return reportAndRespond($exception, 401);
        }
    }


    private function appExceptionHandler($request, $exception){
        // dd($request->server->get('REQUEST_URI'));
        
        if($this->isHttpException($exception))
        {
            
            switch ($exception->getStatusCode())
            {
                // not found
                case 404:
                    if(! config('app.debug') )
                        return response()->view('errors.general', []);
                    else
                        return parent::render($request, $exception);
                break;

                // internal error
                case 500:
                    return parent::render($request, $exception);
                break;

                case 419:
                    return  redirect()->route('login')->withMessage( trans('global.session_expired') );
                break;
                default:
                    return $this->renderHttpException($exception);
                break;
            }
        }
        
        // In Case Session Timeout
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            session(['old_url' => $request->server->get('REQUEST_URI')]);
            return redirect()->route('login');
        }
        
        // In Case Session Timeout
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            session(['old_url' => $request->server->get('REQUEST_URI')]);
            return  redirect()->route('login')->withMessage( trans('global.session_expired') );
        }
        
        if ($exception instanceof \Illuminate\Database\QueryException) {
            // return response()->view('errors.general', []);
        }

        if(! config('app.debug') )
            return response()->view('errors.general', []);
        else
            return parent::render($request, $exception);

    }
    

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        
        $redirectTo = isset($exception->redirectTo)?$exception->redirectTo:null;
        
        if($redirectTo == '/login')
            return parent::render($request, $exception);

        

        if($this->isApiCall($request)) {
            return $this->apiExceptionHandler($request, $exception);
        }
        else{
            return $this->appExceptionHandler($request, $exception);
        }

        
    }
}
