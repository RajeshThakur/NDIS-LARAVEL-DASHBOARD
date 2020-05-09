@extends('layouts.app')
@section('content')

<div class="main-plan-pricing">
    <div class="pricing">
    <h2 class="main-heading">Pricing</h2>
    <div class="row">
        <div class="col-sm-3">
            <div class="pricing-features">
                <h3 class="column-heading">Lite</h3>
                <h2 class="heading-rate">$15</h2>
                <p class="pricing-text">per staff per month</p>
                <h4 class="onlytext-for">For</h4>
                <h3 class="heading-color-green">0-9</h3>
                <p class="pricing-text">staff per</p>

                <div class="pricing-list">
                    <ul>
                        <li>Access to <span>ALL</span> features</li>
                        <li>Unlimited participants</li>
                        <li>Limited tech support</li>
                    </ul>
                </div>
                <div class="pricing-button">
                    <button class="btn btn-success rounded">Get Started</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pricing-features">
                <h3 class="column-heading">Standard</h3>
                <h2 class="heading-rate">$13</h2>
                <p class="pricing-text">per staff per month</p>
                <h4 class="onlytext-for">For</h4>
                <h3 class="heading-color-green">10-29</h3>
                <p class="pricing-text">staff per</p>

                <div class="pricing-list">
                    <ul>
                        <li>Access to <span>ALL</span> features</li>
                        <li>Unlimited participants</li>
                        <li>Limited tech support</li>
                    </ul>
                </div>
                <div class="pricing-button">
                    <button class="btn btn-success rounded">Get Started</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pricing-features">
                <h3 class="column-heading">Professional</h3>
                <h2 class="heading-rate">$11</h2>
                <p class="pricing-text">per staff per month</p>
                <h4 class="onlytext-for">For</h4>
                <h3 class="heading-color-green">30-49</h3>
                <p class="pricing-text">staff per</p>

                <div class="pricing-list">
                    <div class="pricing-listting">
                    <ul>
                        <li>Access to <span>ALL</span> features</li>
                        <li>Unlimited participants</li>
                        <li>Limited tech support</li>
                    </ul>
                    </div>
                </div>
                <div class="pricing-button">
                    <button class="btn btn-success rounded">Get Started</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="pricing-features custom-plr hover-view">
                <h3 class="column-heading green">Enterprise</h3>
                <p class="pricing-text">Discounts are available for enterprise-level organisations.</p>
                <p class="pricing-text">Just ask us how!</p>
                <div class="pricing-button">
                    <button class="btn btn-primary rounded mt-20">Contact us</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>






@endsection