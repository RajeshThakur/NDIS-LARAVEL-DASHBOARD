<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\Common;
use App\Jobs\JobSendEmail;
use App\Notifications\WelcomeEmail;
use App\Http\Controllers\Traits\BookingTrait;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }

    
    /**
     * Success page for App users
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function success()
    {
        return view('success');
    }

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sentry_debug()
    {
        throw new Exception('My first Sentry error!');
    }

    public function push_test(){

        try{

            // $user->

            // \OneSignal::sendNotificationToUser(
            //     "Some Message",
            //     '5cbf6821-ed3b-4509-958e-4a34a56714d1',
            //     $url = null,
            //     $data = null,
            //     $buttons = null,
            //     $schedule = null,
            //     $headings = "This is Demo Message",
            //     $subtitle = null
            // );
            \OneSignal::sendNotificationToUser(
                "Some Message",
                '5cbf6821-ed3b-4509-958e-4a34a56714d1',
                $url = null,
                $data = null,
                $buttons = [
                    ["id"=>"id1", "text"=> "Button 1", "icon"=>"ic_menu_share"],
                    ["id"=>"id2", "text"=> "Button 2", "icon"=>"ic_menu_send"]
                ],
                $schedule = null,
                $headings = "This is Demo Message",
                $subtitle = null
            );
    
            return response()->json([ 'status'=>true,'message'=>'Sent' ]);
        }
        catch(Exception $ex){
            return response()->json([ 'status'=>false,'message'=>$ex->getMessage() ]);
        }
        
    }

    public function form(){

        $worker = \App\SupportWorker::where('support_workers_details.user_id', 4)->with('bookingOrder')->first();

        // pr($worker);
        

        foreach($worker->bookingOrder as $bookingOrder){
            // pr($bookingOrder);
        }

        // $this->addTask([
        //                 'name'=>'Check for Demo',
        //                 'due_date'=>'2019-09-22',
        //                 'start_time'=>'11:30 AM',
        //                 'end_time'=> '12:30 PM',
        //                 'provider_id'=>2
        //                 ],
        //                 [2,5],
        //                 [2,3,4]
        //         );

        $title = "Laravel Forms";

        $user = \Auth::user();

        return view('public.form', compact('title', 'user'));

    }



    public function session_checker(Request $request){
        if ($request->ajax() && \Auth::guest()) {
            return response()->json(['status'=>false, 'message' => 'Session expired', "redirect"=>route('login')]);
        }
        return response()->json([ 'status'=>true,'session'=>'okay' ]);
    }


    /**
     * Handle Queue Process
     */
    public function testQueue()
    {
        $email = new WelcomeEmail();
        $emailJob = new JobSendEmail($email,'info@larashout.com');
        dispatch($emailJob);
        return response()->json([ 'status'=>true,'session'=>'okay' ]);
    }


    /**
     * Test on decoding a string
     */
    public function decode()
    {
        $string = 'TmljZSB3b3JrISBXZSBhcmUgYSBjb21wYW55IHRoYXQgZmFjaWxpdGF0ZXMgYW5kIG1vdGl2YXRlcyBleGNlcHRpb25hbCBwZW9wbGUgdG8gZG8gZ3JlYXQgd29yay4gQSBwbGFjZSB3aGVyZSBkZXZlbG9wZXJzIGNhbiBoYXJuZXNzIHRoZWlyIGNvbGxlY3RpdmUgdGFsZW50cyBhbmQgYWJpbGl0aWVzIHRvIGFjY29tcGxpc2ggY2hhbGxlbmdpbmcgYW5kIG1lYW5pbmdmdWwgdGhpbmdzLiBXZSdyZSBkZXZlbG9wZXIgZHJpdmVuLCBhbmQgd2UgaGF2ZSBiaWcgYW1iaXRpb25zISBJZiB5b3UnZCBsaWtlIHRvIGpvaW4gb3VyIHRlYW0sIGhhdmUgc29tZSBmdW4gaGFja2luZyB0aGlzIHBhZ2U6CgpodHRwczovL2NhcmVlcnMua2lyc2NoYmF1bWRldmVsb3BtZW50LmNvbS9kby1ub3QtdHJ5LXRvLWd1ZXNzLXRoaXMtdXJs';
        
        pr(base64_decode($string), 1);
        
    }


    /**
     * Clear all caches
     */
    public function clearCache()
    {
        // $this->bookingCron();
        \Artisan::call('cache:clear');
        \Artisan::call('config:cache');
        // \Artisan::call('route:cache');
        \Artisan::call('route:clear');
        \Artisan::call('view:cache');
        return response()->json([ 'status'=>true,'session'=>array('Application Cache cleared','Config Cache cleared','Route Cache cleared','View cache cleared') ]);
    }

     /**
     * Dummy Admin view
     */
    public function testview()
    {
       return view('public.appview');
    }


    public function testLog(){

        $response = loggly([ 'fromAddress' => "fromAddress_asdhadja", 'toAddress' => "toAddress_Asdsada", 'subject' => "subject_ASdasda", 'content' => 'content_asdad']);

        return response()->json($response);

    }


    
    /**
     * Email Test
     */
    public function ses_test()
    {
        $admin = \App\User::findorfail(1);
        $admin->notify(new WelcomeEmail($admin));

        return response()->json([ 'status'=>true,'session'=>'okay' ]);
    }



    /**
     * Email Test
     */
    public function smtp_test()
    {

        // pr(env('MAIL_HOST'), 1);
        
        // Create the Transport
        $transport = (new \Swift_SmtpTransport( env('MAIL_HOST') , env('MAIL_PORT') ))
        ->setUsername( env('MAIL_USERNAME') )
        ->setPassword( env('MAIL_PASSWORD') )
        ;

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('Wonderful Subject'))
        ->setFrom(['john@doe.com' => 'John Doe'])
        ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
        ->setBody('Here is the message itself')
        ;

        // Send the message
        $result = $mailer->send($message);
        
        dd($result);

    }

    






}
