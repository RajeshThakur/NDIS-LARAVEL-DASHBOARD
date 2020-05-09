@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header mb-4">
        <div class="row">
            <div class="pageTitle">
                <h2>Subscription</h2>
            </div>
            {{-- <div class="icons ml-auto order-last" id="intro_step1" data-intro="Add Participant Using this Button">
                    <a class="btn btn-success hint_top rounded" aria-label="Add Participant" href="http://localhost:8000/admin/participants/create">
                        Add Participant
                    </a>
            </div>  --}}
        </div>
    </div>

    <div class="subscription-content">
        <div class="row">
            <div class="col-sm-6">
                <div class="column-contnet">
                    {{-- <h3>{{$product->name}}</h3> --}}
                    <h3>Pricing Tiers</h3>
                    <ul>
                        {{-- @if( $customerInfo->subscriptions->total_count > 0 )
                            @foreach($customerInfo->subscriptions as $key => $val)                              
                                <li>You are subscribed to <b>{{ $val->plan->nickname }}</b> package.</li>
                                <li>Started on  : {{\Carbon\Carbon::parse($val->plan->start)->toDayDateTimeString()}}</li>
                                <li>Ends on  : {{\Carbon\Carbon::parse($val->plan->start)->toDayDateTimeString()}}</li>
                            @endforeach
                        @endif     --}}                        
                        
                        {{-- <li>{{$product->name}}</li> --}}
                           
                        {{-- @if( sizeof($plans->data) >0 )
                            @foreach($plans->data as $key => $plan)
                                <li>{{$plan->nickname}} : ${{ number_format( ($plan->amount / 100),2 ) }}</li>
                            @endforeach
                        @endif --}}
                        <li>Lite : $15 per staff per month for 0-9 staff</li>
                        <li>Standard : $13 per staff per month for 10-29 staff</li>
                        <li>Professional : $11 per staff per month for 30-49 staff</li>
                    </ul>
                    {{-- <div class=" buttom-section mt-40">
                        <a class="btn btn-normal btn-primary rounded" href="{{ route("admin.subscription.plans") }}">Upgrade</a>
                    </div> --}}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="column-contnet">
                    <h3>Billing Address</h3>
                    @if( !is_null($customerInfo->address) )
                    <span>{{ ($customerInfo->address->line1) ? $customerInfo->address->line1 : '' }}</span></br>
                    <span>{{ ($customerInfo->address->line2) ? $customerInfo->address->line2 : '' }}</span></br>
                    <span>{{ ($customerInfo->address->city) ? $customerInfo->address->city : '' }}</span></br>
                    <span>{{ ($customerInfo->address->state) ? $customerInfo->address->state : '' }}</span></br>
                    <span>{{ ($customerInfo->address->postal_code) ? $customerInfo->address->postal_code : '' }}</span></br>
                    @else
                    <span>No billing information available</span></br>
                    @endif
                </div> 
                <div class=" buttom-section mt-40">               
                    <a class="btn btn-normal btn-primary rounded" href="{{ route("admin.subscription.billinginfo") }}">Edit billing address</a>
                </div>
            </div>
        </div>
    </div>

    <div class="subscription-content subscription-history mt-40">
        <div class="row">
                <div class="col-sm-12">
                    <div class="column-contnet">
                        <h3>Billing History</h3>
                        <div class="table-responsive mt-40">
                            <table class=" table table-bordered table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>
                                             Date  
                                        </th>
                                        <th>
                                             Amount 
                                        </th>
                                        <th>
                                             {{-- Download --}}
                                        </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>01-01-2020</td>
                                    <td>A$2000</td>                                        
                                    <td><a href="#">Download</a></td>
                                </tr>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                                        <td>{{ $invoice->total() }}</td>                                        
                                        <td><a href="{{ route("admin.invoice",['invoice' => $invoice->id]) }}">Download</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
            </div>
        </div>
    </div>


    <div>
        <h3>Added cards</h3>
        <table class=" table table-bordered table-striped table-hover datatable">            
            <tbody>
            <thead>
                <tr>
                    <th>
                            Card number  
                    </th>
                    <th>
                            Provider 
                    </th>
                    <th>
                           
                    </th>                                        
                    <th>
                           
                    </th>                                        
                </tr>
            </thead>
            @if($paymentMethods->isNotEmpty())
                @foreach ($paymentMethods as $key => $method)
                    <tr>
                        <td>**** ***** **** {{ $method->card->last4 }}</td>
                        <td>{{ strtoupper($method->card->brand) }}</td>
                        {{-- <td><input type="radio" class="make-default" name="default-card" value="{{ $method->id }}" @if($defaultPaymentMethod->id == $method->id){{'checked'}} @endif"/></td> --}}
                        <td>
                            @if( $defaultPaymentMethod && $defaultPaymentMethod->id == $method->id)
                                <a class="is-default badge-info" data-id="{{ $method->id }}">Default</a>
                            @else
                                <form class="set-default" method="POST" action="{{ route('admin.subscription.defaultcard') }}">
                                    @csrf
                                    <input type="hidden" value="{{$method->id}}" name="method_id">
                                    <input type="submit" value="Make default">
                                </form>
                            @endif
                        </td>
                        <td>
                            <form class="remove-card" method="POST" action="{{ route('admin.subscription.removecard') }}">
                                @csrf
                                <input type="hidden" value="{{$method->id}}" name="method_id">
                                <input type="submit" value="Remove">
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else 
                <tr>
                    <td>No card added</td>
                    <td>Please add a card</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            </tbody>
        </table>
        <div class=" buttom-section mt-40">            
            <a class="btn btn-normal btn-primary rounded" href="{{ route("admin.subscription.addcard") }}">Add new card</a>
        </div>
    </div>
</div>
    
@endsection
@section('scripts')
@parent
@endsection