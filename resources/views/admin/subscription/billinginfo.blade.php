@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header mb-4">
        <div class="row">
            <a href="{{ url('admin/subscription')}}"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span></a>
            <div class="pageTitle">
                <h2>Edit billing information</h2>
            </div>           
        </div>
    </div>

    <div class="subscription-content">
        <div class="row">            
            <div class="col-sm-12">
                <div class="column-contnet">
                    <h3>Billing Address</h3> 
                    <form class="remove-card" method="POST" action="{{ route('admin.subscription.updatebillinginfo') }}">
                        @csrf
                        Line 1:      <input type="textarea" name="line1" value="{{ $customerInfo->address ? $customerInfo->address->line1 : '' }}"></br>
                        Line 2:      <input type="textarea" name="line2" value="{{ $customerInfo->address ?  $customerInfo->address->line2 : '' }}"></br>
                        City:        <input type="text" name="city" value="{{ $customerInfo->address ? $customerInfo->address->city : ''}}"></br>
                        State:       <input type="text" name="state" value="{{ $customerInfo->address ?  $customerInfo->address->state : ''}}"></br>
                        Postal code: <input type="text" name="postal_code" value="{{ $customerInfo->address ?  $customerInfo->address->postal_code : ''}}"></br>
                        <input type="submit" value="Update">
                    </form>
                </div>                
                
            </div>
        </div>
    </div>
</div>
    
@endsection
@section('scripts')
@parent
@endsection