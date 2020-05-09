<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Traits\StripeApiTrait;


class SubscriptionController extends Controller
{
    use StripeApiTrait;
             
    /**
     * My Subscriptions
     */
    public function index()
    {
        $user = \Auth::user();
       
        
        $paymentMethods = $user->paymentMethods();
        $defaultPaymentMethod = $user->defaultPaymentMethod();
        $customerInfo = $user->asStripeCustomer(); //customer object
        $invoices = $user->invoices();
        $invoices = $user->invoicesIncludingPending();
        
        // dd($paymentMethods);
        // dd($defaultPaymentMethod);

        // if ($user->subscribed('main')) {
            // dd($user->subscriptions());
        // }

        // if ($user->hasPaymentMethod()) {
        //     pr($defaultPaymentMethod,1);
        // }
        
        $product = $this->getProduct(config('ndis.stripe_product'));
        $products = $this->getProductsList();
        $plans = $this->getPlans();

        $intent = $user->createSetupIntent();
        
        // dd(config('ndis.stripe_product'));
        // dd($customerInfo);
        // dd($product);
        // dd($plans);

        return view('admin.subscription.index',compact('customerInfo','invoices','plans','product', 'intent','defaultPaymentMethod','paymentMethods'));
    }

    /**
     * Add card
     */
    public function addCard()
    {
        $user = \Auth::user();

        $intent = $user->createSetupIntent();

        return view('admin.subscription.addcard',compact('intent'));
    }

    /**
     * Default card
     */
    public function defaultCard(Request $request)
    {
        $messages = [
            'method_id'   => "No payment method found.",
        ];

        $data = Validator::make( $request->all(), [
                            'method_id' => 'required|string'
                            ], $messages);

        if($data->fails()):
            return redirect()->route("admin.subscription")->with('message', $data->messages());
        endif;

        try{
            $user = \Auth::user();

            $user->updateDefaultPaymentMethod($request->method_id);

            return redirect()->route("admin.subscription");
        }
        catch(Exception $error){
            return back()->withError($error->message());
        }

        
    }

    /**
     * Default card
     */
    public function removeCard(Request $request)
    {
        $messages = [
            'method_id'   => "No payment method found.",
        ];

        $data = Validator::make( $request->all(), [
                            'method_id' => 'required|string'
                            ], $messages);

        if($data->fails()):
            return redirect()->route("admin.subscription")->with('message', $data->messages());
        endif;

        try{
            $user = \Auth::user();

            $user->removePaymentMethod($request->method_id);
    
            return redirect()->route("admin.subscription");
        }
        catch(Exception $error){
            return back()->withError($error->message());
        }

       
    }

    /**
     * Available plans
     */
    public function availablePlans()
    {

        $user = \Auth::user();

        $customerInfo = $user->asStripeCustomer();

        // $subscriptions = $user->subscriptions();

        $product = $this->getProduct(config('ndis.stripe_product'));
        $products = $this->getProductsList();
        $plans = $this->getPlans();

        // pr($customerInfo,1);

        return view('admin.subscription.plans',compact('product','plans'));
    }

    /**
     * Subscribe to plan
     */
    public function subscribeToPlan(Request $request)
    {

        $user = \Auth::user();

        $product = $this->getProduct(config('ndis.stripe_product'));
        $products = $this->getProductsList();
        $plans = $this->getPlans();

        // pr($plans,1);

        return view('admin.subscription.subscribe',compact('product','plans'));
    }


    /**
     * Editing view of user's stripe billing information
     */
    public function billingInfo(Request $request)
    {

        $user = \Auth::user();

        $customerInfo = $user->asStripeCustomer();

        return view('admin.subscription.billinginfo',compact('customerInfo'));
    }


    /**
     * Update user's stripe billing information
     */
    public function updateBillingInfo(Request $request)
    {       

        // pr($request->all(),1);
        $messages = [
            'line1'   => "Address line 1 is empty.",
            'line2'   => "Address line 2 is empty.",
            'city'   => "City is empty.",
            'state'   => "State is empty.",
            'postal_code'   => "Postal code is empty.",
        ];

        $data = Validator::make( $request->all(), [
                            'line1' => 'required|string',
                            'line2' => 'required|string',
                            'city' => 'required|string',
                            'state' => 'required|string',
                            'postal_code' => 'required|digits:4'                           
                            ], $messages);
        $message ="";
        foreach(collect(json_decode($data->messages()))->flatten() as $i=>$m):
            $message .= $m;
        endforeach;       

        if($data->fails()):
            return redirect()->route("admin.subscription.billinginfo")->with('message', $message);
        endif;

        $address['line1'] = $request->line1;
        $address['line2'] = $request->line2;
        $address['city'] = $request->city;
        $address['state'] = $request->state;
        $address['postal_code'] = $request->postal_code;

        $options = ['address' => $address]; //options array with user field keys

        try{
            $user = \Auth::user();
            $customer = $user->updateStripeCustomer($options);
        }
        catch(Exception $error){
            return back()->withError($error->message());
        }

        // pr($customer,1);

        return redirect()->route("admin.subscription");
    }

    /**
     * Add payment method
     */
    public function ajaxAddMethod(Request $request)
    {
        $messages = [
            'p_method'   => "No payment method found.",
        ];

        $data = Validator::make( $request->all(), [
                            'p_method' => 'required|string'
                            ], $messages);
        $message ="";
        foreach(collect(json_decode($data->messages()))->flatten() as $i=>$m):
            $message .= $m;
        endforeach;  
        if($data->fails()):
            echo json_encode(['status'=>false, 'message'=>$message]);
            exit;
        endif;

        $user =  \Auth::user();

        if( !empty($request->p_method) ){
            $res = $user->addPaymentMethod($request->p_method);

            //set as default payment method
            $user->updateDefaultPaymentMethod($request->p_method);

            // $user->removePaymentMethod($request->p_method);

            echo json_encode(['status'=>true, 'message'=>'Card added successfully.','data'=>$res]);
            exit;
        }
        else{            
            echo json_encode(['status'=>false, 'message'=>'Please try again.']);
            exit;
        }
    }

}
