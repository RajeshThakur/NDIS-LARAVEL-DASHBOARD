@extends('layouts.admin')
@section('content')

<div class="card main-card">
    <div class="card-header mb-4">
        <div class="row">   
            <a href="{{ url('admin/subscription')}}"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span></a>
            <div class="pageTitle">                 
                <h2>Add Payment method</h2>
            </div>           
        </div>
    </div>

    <p>You will be charged under <b>Lite</b> plan with $15 per month for this staff member.</p>

    {{-- START --}}
    <div class="cell example example4" id="example-4">
        <form id="add-method-form">
          <fieldset>
            <legend class="card-only" data-tid="elements_examples.form.pay_with_card">Add card</legend>
            <div class="container">
              <div id="example4-card"></div>
              <button id="card-button" data-secret="{{ $intent->client_secret }}" type="submit" data-tid="elements_examples.form.donate_button">Add card</button>
            </div>
          </fieldset>          
        </form>
        <div class="success">
          <div class="icon">
            <svg id="successAnimation" class="animated" xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 70 70">
            <path id="successAnimationResult" fill="#D8D8D8" d="M35,60 C21.1928813,60 10,48.8071187 10,35 C10,21.1928813 21.1928813,10 35,10 C48.8071187,10 60,21.1928813 60,35 C60,48.8071187 48.8071187,60 35,60 Z M23.6332378,33.2260427 L22.3667622,34.7739573 L34.1433655,44.40936 L47.776114,27.6305926 L46.223886,26.3694074 L33.8566345,41.59064 L23.6332378,33.2260427 Z"/>
            <circle id="successAnimationCircle" cx="35" cy="35" r="24" stroke="#979797" stroke-width="2" stroke-linecap="round" fill="transparent"/>
            <polyline id="successAnimationCheck" stroke="#979797" stroke-width="2" points="23 34 34 43 47 27" fill="transparent"/>
            </svg>
          </div>
          <h3 class="title" data-tid="elements_examples.success.title">Card added successfully</h3>          
        </div>
    </div>
    {{-- END --}}
</div>


    
@endsection
@section('scripts')
@parent

<script src="https://js.stripe.com/v3/"></script>
<script>
    
    const stripe = Stripe( '{{ config('ndis.stripe_key') }}' );

    const elements = stripe.elements({
            fonts: [
            {
                cssSrc: "https://rsms.me/inter/inter-ui.css"
            }
            ],
            // Stripe's examples are localized to specific languages, but if
            // you wish to have Elements automatically detect your user's locale,
            // use `locale: 'auto'` instead.
            locale: window.__exampleLocale
    });
    const cardElement = elements.create('card',{
        style: {
        base: {
            color: "#32325D",
            fontWeight: 500,
            fontFamily: "Inter UI, Open Sans, Segoe UI, sans-serif",
            fontSize: "16px",
            fontSmoothing: "antialiased",

            "::placeholder": {
            color: "#CFD7DF"
            }
        },
        invalid: {
            color: "#E25950"
        }
        }
    });


    cardElement.mount('#example4-card');


    // const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        e.preventDefault();
        const { setupIntent, error } = await stripe.handleCardSetup(
            clientSecret, cardElement, {
                payment_method_data: {
                    // billing_details: { name: cardHolderName.value }
                }
            }
        );
        
        console.log(error)       
        if (error) {
            if( typeof error.setup_intent != "undefined" &&  error.setup_intent.payment_method != "null" && error.setup_intent.payment_method != ''  ){
                //use previously succeded attempt's identifier 
                ndis.addLoader( $('#card-button') );
                ndis.ajax(
                '{{ route("admin.subscription.method") }}',
                'POST',
                { p_method : error.setup_intent.payment_method },
                function(res){
                        console.log(res);                        
                        if(res.status){
                            $('#add-method-form').hide();
                            $('.success').show();
                        }
                        if(res.error){
                            ndis.displayMsg( 'error', res.msg)
                        }

                        ndis.removeLoader($('#card-button'));
                    }
                );
            }else{
                // Display "error.message" to the user...
                console.log(error)
            }
        } else {
            // The card has been verified successfully...
            console.log('card verified')
            console.log(setupIntent)
            ndis.addLoader( $('#card-button') );
            ndis.ajax(
                '{{ route("admin.subscription.method") }}',
                'POST',
                { p_method : setupIntent.payment_method },
                function(res){
                    console.log(res);                 
                    if(res.status){
                        $('#add-method-form').hide();
                        $('.success').show();
                    }
                    if(res.error){
                        ndis.displayMsg( 'error', res.msg)
                    }
                    ndis.removeLoader($('#card-button'));
                }
            );
        }
    });



    var animation = document.getElementById('successAnimation');
    var restart = document.getElementById('replay');

    restart.addEventListener('click', function(e) {
        e.preventDefault;
        animation.classList.remove('animated');
        void animation.parentNode.offsetWidth;
        animation.classList.add('animated');
    }, false);

</script>



@endsection