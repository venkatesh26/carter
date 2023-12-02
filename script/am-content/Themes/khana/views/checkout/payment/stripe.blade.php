@extends('theme::layouts.app')

@push('css')
<style>
    .StripeElement {
        box-sizing: border-box;

        height: 40px;

        padding: 10px 12px;

        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;

        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
    .billingaddr p{
        /*margin-bottom: 5px;*/
    }
</style>
<script src="https://js.stripe.com/v3/"></script>
@endpush

@section('content')
<div class="stripe-payment mt-100 mb-30">
    <div class="container">
        <div class="row">
            <?php
               $billingInfo = Session::get('order_info');

               // print_r($billingInfo);

            ?>

            @if(isset($billingInfo) && count($billingInfo) )

            <div class="col-lg-6">
                <div class="stripe-payment-form billingaddr mb-4" style="padding-top: 40px;padding-bottom: 40px;">
                    <h4>Billing Details</h4>
                    <p><strong>First Name :</strong> {{$billingInfo["b_first_name"]}}</p>
                    <p><strong>Last Name :</strong> {{$billingInfo["b_last_name"]}}</p>
                    @if($billingInfo["b_c_name"] !="")
                    <p><strong>Company Name :</strong> {{$billingInfo["b_c_name"]}}</p>
                     @endif
                    <p><strong>Address :</strong> {{$billingInfo["b_address"]}}</p>
                    <p><strong>Email :</strong> {{$billingInfo["b_email"]}}</p>
                    <p><strong>Phone number :</strong> {{$billingInfo["b_phone"]}}</p>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="stripe-payment-form" style="padding-top: 25px;padding-bottom: 25px;">
                    <h4>{{ __('Your Order') }} </h4>
                    <div class="order-product-list">
                        @foreach($billingInfo["orderDetails"] as $cart)
                        <div class="single-order-product-info d-flex">
                            <div class="product-qty-name">
                                <span class="product-qty">{{ $cart->qty }}</span> <span class="symbol">x</span><span>{{ $cart->name }} (&euro; {{ number_format($cart->price,2) }})</span>
                            </div>
                            <div class="product-price-info">
                                <span>&euro;: {{ number_format($cart->price * $cart->qty,2)  }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
               
                    <div class="product-another-info-show">
                        <div class="single-product-another-info-show d-flex">
                            <span class="product-another">{{ __('Subtotal') }}</span>
                            <span class="product-price">&euro;: {{ number_format($billingInfo["amount"],2) }}</span>
                        </div>
                        @if(Session::has('coupon'))
                        <div class="single-product-another-info-show d-flex">
                            <span class="product-another">{{ __('Discount') }}</span>
                            <span class="product-price">{{ Session::get('coupon')['percent'] }}%</span>
                        </div>
                        @endif
                        
                        <div class="single-product-another-info-show total d-flex">
                            <span class="product-another">{{ __('Total Price') }}</span>
                            <span class="product-price">&euro;: <span id="last_total">{{ number_format($billingInfo["amount"],2) }}</span></span>
                        </div>
                        <hr style="height: 2px;">
                        <?php 
                            $dueAmount = 0;
                            $dueAmount = (env('DEPOSIT_PERCENT') / 100) * $billingInfo["amount"];
                            $balanceAmount = $billingInfo["amount"] - $dueAmount;
                            // $dueOndel = Cart::total() - $dueAmount;
                        ?>
                        <div class="single-product-another-info-show total d-flex">
                            <span class="product-another" style="color: #ff3252;">{{ __('Deposit Due Now (15%)') }}</span>
                            <span class="product-price" style="color: #ff3252;">&euro;: <span id="last_total"><?php echo number_format($dueAmount,2);?></span></span>
                        </div>

                        <div class="single-product-another-info-show total d-flex">
                            <span class="product-another" style="color: #ff3252;">{{ __('Amount Due on Delivery') }}</span>
                            <span class="product-price" style="color: #ff3252;">&euro;: <span id="last_total"><?php echo number_format($balanceAmount, 2);?></span></span>
                        </div>

                        <div class="single-product-another-info-show total d-flex">
                            <span class="product-another" style="color: #ff3252;">{{ __('Total to Pay Now') }}</span>
                            <span class="product-price" style="color: #ff3252;">&euro;: <span id="last_total"><?php echo number_format($dueAmount, 2);?></span></span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-lg-6" style="margin: auto;margin-top: 25px;">
                    <div class="stripe-payment-form">
                        <form action="{{ route('stripe.charge') }}" method="post" id="payment-form">
                            <div>
                                <p>We need payment to ensure we have only genuine cateres that would love to serve our customers.</p>
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                            <button>Submit Payment</button>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
             @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    var publishable_key = '{{ env('STRIPE_KEY') }}';
</script>

<script type="text/javascript">
    // Create a Stripe client.
    var stripe = Stripe(publishable_key);

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', {hidePostalCode: true, style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
</script>
@endpush

