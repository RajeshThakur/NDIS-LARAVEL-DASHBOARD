<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Product;

trait StripeApiTrait
{

    /**
     * Set global stripe key
     * @return bool
     */
    protected function setApiKey( )
    {
        Stripe::setApiKey( config('ndis.stripe_secret') );
        
    }


    /**
     * Get all plans 
     * @return plans
     */
    public function getPlans( )
    {

        try {
            $this->setApiKey();
            return \Stripe\Plan::all(['active' => true]);
        } 
        catch (\Stripe\Exception\AuthenticationException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiConnectionException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiErrorException $e) {
            return $e;
        }
        
    }    


    /**
     * Get stripe product by id
     * @return product
     */
    public function getProduct( $id )
    {

        try {
            $this->setApiKey();
            return Product::retrieve(config('ndis.stripe_product'));
        } 
        catch (\Stripe\Exception\AuthenticationException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiConnectionException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiErrorException $e) {
            return $e;
        }
        
    }   

    /**
     * Get all products list 
     * @return products
     */
    public function getProductsList( )
    {

        try {
            $this->setApiKey();
            return Product::all(['active' => true]);
        } 
        catch (\Stripe\Exception\AuthenticationException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiConnectionException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiErrorException $e) {
            return $e;
        }
        
    }


    /**
     * Check if card is already added
     * @return boolean 
     */
    public function checkFingerprint()
    {
        $user =  \Auth::user();
        $duplicate = false;
        try {
            $this->setApiKey();

            $paymentMethods = $user->paymentMethods();

            foreach ( $paymentMethods  as $card) {
                // // If this card is not the default card, but the fingerprints match...
                // if ( ($card->id != $defaultCard->id) and ($card->fingerprint == $defaultCard->fingerprint) ) {
        
                //         // Delete it.
                //         $card->delete();
                //     }
            }


            return $duplicate;
        } 
        catch (\Stripe\Exception\AuthenticationException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiConnectionException $e) {
            return $e;
        }
        catch (\Stripe\Exception\ApiErrorException $e) {
            return $e;
        }
        
    }

}