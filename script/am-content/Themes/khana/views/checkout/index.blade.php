@extends('theme::layouts.app')

@section('content')

<!-- success-alert start -->
<div class="alert-message-area">
	<div class="alert-content">
		<h4 class="ale">{{ __('Your Settings Successfully Updated') }}</h4>
	</div>
</div>

<!-- success-alert end -->

<!-- error-alert start -->
<div class="error-message-area">
	<div class="error-content">
		<h4 class="error-msg"></h4>
	</div>
</div>
<!-- error-alert end -->

<style>
.delivery-form input{
	padding: 0.375rem 0.75rem !important;
	    height: auto;
}
.delivery-form label {
    font-size: 16px;
    color: #7e7e7e;
    font-weight: 500;
}
.checkout-area .bootstrap-datetimepicker-widget table td span, .bootstrap-datetimepicker-widget table td i {
    display: inline-block;
    width: 50px !important;
    height: 40px !important;
    line-height: 38px !important;
    margin: 2px 1.5px;
    cursor: pointer;
    border-radius: 0.25rem;
}
.checkout-area .bootstrap-datetimepicker-widget table td span:hover, .checkout-area .bootstrap-datetimepicker-widget table td i:hover {
    background: none;
}
</style>
<link rel="stylesheet" href="{{ theme_asset('khana/public/css/bootstrap-datetimepicker-build.css') }}">

<!-- checkout area start -->
<section>
	<div class="checkout-area">
		<div class="container">
			<div class="row mt-50">
				<div class="col-lg-8 delivery-form">
					<form action="{{ route('order.create') }}" method="POST" id="place_order_form">
						@csrf
						<div class="single-checkout mb-50">
							@if ($errors->any())
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif

							<div class="row ">
							  <div class="col-md-12 mb-4">
							    <div class=" mb-4">

							        <h3><span>1</span> {{ __('Billing Address') }}</h3>

							          <div class="row mb-4">
							            <div class="col-lg-6 mb-4">
											<div class="form-group">
												<label for="b_first_name">{{ __('Name') }}</label>
												<input autocomplete="off" type="text" class="form-control" name="b_first_name" id="b_first_name" placeholder="" required>
											</div>
										</div>
							            <div class="col-lg-6 mb-4">
											<div class="form-group">
												<label for="b_last_name">{{ __('Last name') }}</label>
												<input autocomplete="off" type="text" class="form-control" name="b_last_name" id="b_last_name" placeholder="" value="" required>
											</div>
										</div>

							            <div class="col-lg-6 mb-4">
											<div class="form-group">
												<label for="b_c_name">{{ __('Door Number') }}</label>
												<input autocomplete="off" type="text" class="form-control" name="b_c_name" id="b_c_name" placeholder="" value="">
											</div>
										</div>
							            <div class="col-lg-6 mb-4">
											<div class="form-group">
												<label for="b_address">{{ __('Address') }}</label>
												<input autocomplete="off" type="text" class="form-control" name="b_address" id="b_address" placeholder="" value="" required>
											</div>
										</div>

							            
							            <div class="col-lg-6 mb-4 d-none">
											<div class="form-group">
												<label for="b_phone">{{ __('Phone') }}</label>
												<input autocomplete="off" type="hidden" class="form-control" name="b_phone" id="b_phone" placeholder="" value="">
											</div>
										</div>
							          </div>
							    </div>
							  </div>
							</div>


							<h3><span>2</span> {{ __('Delivery Details') }}</h3>
							<!-- <h6 class="text-danger none" id="msg">{{ __('Service Not Available On Your Area') }}</h6> -->
							<div class="">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="first_name">{{ __('Name') }}</label>
											<input autocomplete="off" type="text" class="form-control" name="name" id="first_name" placeholder="{{ __('Name') }}" value="{{ Auth::user()->first_name ?? '' }}">
										</div>
									</div>
								
									<div class="col-lg-6 mb-4">
											<div class="form-group">
												<label for="b_email">{{ __('Email') }}</label>
												<input autocomplete="off" type="text" class="form-control" name="b_email" id="b_email" placeholder="" value="{{Auth::user()->email}}" required>
											</div>
										</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label for="phone">{{ __('Phone Number') }}</label>
											<input autocomplete="off" type="number" class="form-control" name="phone" id="phone" placeholder="" required autocomplete="off">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group" style="position: relative">
											<label for="first_name">{{ __('Event Date/Time') }}</label>
											<input autocomplete="off" type="text" class="form-control" name="event_date" id="event_date" placeholder="" value="">

										</div>
									</div>

									<!-- <div class="col-lg-6 mt-3">
										<div class="form-group">
											<label for="first_name">{{ __('Event Time') }}</label>
											<input autocomplete="off" type="text" class="form-control" name="event_date" id="event_date" placeholder="" value="">
										</div>
									</div> -->

									<input type="hidden" name="order_type" value="{{ $ordertype }}">
									@if($ordertype == 1)
									<input type="hidden" name="latitude" id="latitude" value="$resturent_info->resturentlocation->latitude">
									<input type="hidden" name="longitude" id="longitude" value="$resturent_info->resturentlocation->longitude">


									<div class="row">
										<!-- <hr>
										<h4>{{ __('Delivery Address') }}</h4> -->
										<!-- <div class="col-lg-6 mt-3 ">
											<div class="form-group">
												<label for="billing">{{ __('Door No /Flat Number') }}</label>
												<input  type="text" class="form-control " autocomplete="off" id="" placeholder="{{ __('Door No / Flat Number') }}" name="flatno" required>
											</div>
										</div> -->

										<div class="col-lg-6 mt-3 ">
											<div class="form-group ">
												<label for="billing">{{ __('Door No /Flat Number') }}</label>
												<input  type="text" class="form-control " autocomplete="off" id="" placeholder="{{ __('Door No / Flat Number') }}" name="flatno" required>
											</div>
										</div>
										<div class="col-lg-6 mt-3 d-none">
											<div class="form-group ">
												<label for="billing">{{ __('Apartment Number') }}</label>
												<input  type="hidden" class="form-control " autocomplete="off" id="" placeholder="{{ __('') }}" name="apartmentno">
											</div>
										</div>
											<div class="col-lg-12 form-group mt-3">
												<label for="phone">{{ __('Delivery Address') }}</label>
												<input  type="text" class="form-control location_input" autocomplete="off" id="location_input" placeholder="{{ __('Delivery Address') }}" name="delivery_address" required>
											</div>
										</div>
									</div>



									<div class="col-lg-12">
										<div class="form-group">
											<!-- <div class="map-canvas" id="map-canvas">

											</div> -->
											<input type="hidden" name="shipping" id="shipping">
										</div>
									</div>

									@endif
									<div class="col-lg-12 mt-3">
										<div class="form-group">
											<label for="order_details">{{ __('Order Note') }}</label>
											<textarea name="note" class="form-control" name="order_note" id="order_details" cols="5" rows="5" maxlength="200" placeholder="{{ __('Order Note') }}"></textarea>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="select-payment-area mt-50">
											<h3><span>3</span> {{ __('Select Payment Method') }}</h3>
											<div class="row justify-content-center select_payment">

												@if(env('STRIPE_KEY') != '')
												<div class="col-lg-3 payment_section">
													<label for="stripe" class="single-payment-section stripe text-center mb-30" onclick="select_payment('stripe')">
														<img class="img-fluid" src="{{ theme_asset('khana/public/img/stripe.png') }}" alt="">
													</label>
													<input type="radio" name="payment_method" value="stripe" id="stripe" class="d-none">
												</div>
												@endif

												<!-- <div class="col-lg-3 payment_section">
													<label for="cod" class="single-payment-section text-center cod" onclick="select_payment('cod')">
														<img class="img-fluid cod" src="{{ theme_asset('khana/public/img/cod.png') }}" alt="">
													</label>
													<input id="cod" type="radio" class="d-none" name="payment_method" value="cod">
												</div> -->


											</div>
										</div>
									</div>
									
									@foreach(Cart::instance('multi_cart')->content() as $cart)
										<div class="single-order-product-info d-flex">

										</div>
									@endforeach

									<input type="hidden" name="total_amount" id="total_amount" value="{{ Cart::total() }}">
									<div class="col-lg-12">
										<div class="form-group">
											<div class="place-order mt-20">
												<button id="place_order_button">{{ __('Place Order') }}</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				
				<div class="col-lg-4">
					<div id="checkout_right">
						<div class="checkout-right-section">
							<div class="order-store text-center">
								<h4>{{ __('Your Order') }} {{ Session::get('restaurant_id')['name'] }}</h4>
							</div>
							<div class="order-product-list">
								@foreach(Cart::instance('multi_cart')->content() as $cart)
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


								@if(Cart::discount() > 0)
								<div class="single-product-another-info-show d-flex">
									<span class="product-another" style="color: #2AAA8A;font-weight: bold;">{{ __('Discount') }} ( {{ Session::get('coupon')['percent'] }}%)</span>
									<span class="product-price" style="color: #2AAA8A;font-weight: bold;">&euro;: {{ Cart::discount() }} <span id="delivery_fee"></span></span>
								</div>
								@endif


								<div class="single-product-another-info-show d-flex">
									<span class="product-another">{{ __('Subtotal') }}</span>
									<span class="product-price">&euro;: {{ Cart::subtotal() }}</span>
								</div>


								<!-- @if($ordertype == 1)
								<div class="single-product-another-info-show d-flex">
									<span class="product-another">{{ __('Delivery fee') }}</span>
									<span class="product-price">{{ $currency->value }}: <span id="delivery_fee"></span></span>
								</div>
								@endif -->
								<!-- <div class="single-product-another-info-show d-flex">
									<span class="product-another">{{ __('Tax fee') }}</span>
									<span class="product-price">{{ $currency->value }}: {{ Cart::tax() }} <span id="delivery_fee"></span></span>
								</div> -->
								<div class="single-product-another-info-show total d-flex">
									<span class="product-another">{{ __('Total Price') }}</span>
									<span class="product-price">&euro;: <span id="last_total">{{ Cart::total() }}</span></span>
								</div>
								<hr style="height: 2px;">
								<?php 
									$dueAmount = 0;
									$dueAmount = (env('DEPOSIT_PERCENT') / 100) * Cart::total();
									$balanceAmount = Cart::total() - $dueAmount;
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
						@if(!Session::has('coupon'))
						 <div class="checkout-right-section mt-35">
							<form action="{{ route('coupon') }}" method="POST" id="couponform">
								@csrf
								 <div class="apply-coupon">
									<div class="form-group">
										<label>{{ __('Enter Coupon Code') }}</label>
										<div class="d-flex">
											<input class="form-control" type="text" name="code">
											<button type="submit">{{ __('Apply') }}</button>
										</div>
									</div>
								</div>
							 </form>
						</div> 
						@endif
						@if(Session::has('coupon'))

							<div class="checkout-right-section mt-35">
								<form action="{{ route('couponDelete') }}" method="POST" id="coupondelete">
									@csrf
									 <div class="apply-coupon">
										<div class="form-group">
											<label style="color: #2AAA8A;font-weight: bold;">{{ Session::get('coupon')['code'] ?? 'Coupon ' }}   {{ __('Code Appllied Sucesssfully') }}</label>
											<div class="d-flex">
												<button type="submit">{{ __('Remove') }}</button>
											</div>
										</div>
									</div>
								 </form>
							</div> 
						@endif
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- checkout area end -->

<input type="hidden" id="stripe_api_key" value="{{ env('STRIPE_KEY') }}">
<input type="hidden" id="currency_value" value="{{ $currency->value }}">
@endsection
@push('js')
 <script>
	 $('#place_order_form').on('submit',function(){
		$('#place_order_button').attr('disabled','');
		$('#place_order_button').html('Please wait....');
	 });
	
	//coupon form submit
	$('#couponform').on('submit',function(e){
		alert(1);
    	e.preventDefault();
    	$.ajaxSetup({
    		headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	});
    	$.ajax({
    		type: 'POST',
    		url: this.action,
    		data: new FormData(this),
    		dataType: 'json',
    		contentType: false,
    		cache: false,
    		processData:false,

    		success: function(response){
    			if(response.message)
    			{
    				$('#checkout_right').load(' #checkout_right');
    				$('.alert-message-area').fadeIn();
    				$('.ale').html(response.message);
    				$(".alert-message-area").delay( 2000 ).fadeOut( 2000 );
    				//window.location.reload();
    			}

    			if(response.error)
    			{
    				$('.error-message-area').fadeIn();
    				$('.error-msg').html(response.error);
    				$(".error-message-area").delay( 2000 ).fadeOut( 2000 );
    			}

    		},
    		error: function(xhr, status, error)
    		{
    			$('.errorarea').show();
    			$.each(xhr.responseJSON.errors, function (key, item)
    			{
    				Sweet('error',item)
    				$("#errors").html("<li class='text-danger'>"+item+"</li>")
    			});
    			errosresponse(xhr, status, error);
    		}
    	})
    });

    $('#coupondelete').on('submit',function(e){
		e.preventDefault();
    	$.ajaxSetup({
    		headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	});
    	$.ajax({
    		type: 'POST',
			url: this.action,
			data: new FormData(this),
    		dataType: 'json',
    		contentType: false,
    		cache: false,
    		processData:false,

    		success: function(response){
    			if(response.message)
    			{
    				$('#checkout_right').load(' #checkout_right');
    				$('.alert-message-area').fadeIn();
    				$('.ale').html(response.message);
    				$(".alert-message-area").delay( 2000 ).fadeOut( 2000 );
    				//window.location.reload();
    			}

    		},
    		error: function(xhr, status, error)
    		{
    			$('.errorarea').show();
    			$.each(xhr.responseJSON.errors, function (key, item)
    			{
    				Sweet('error',item)
    				$("#errors").html("<li class='text-danger'>"+item+"</li>")
    			});
    			errosresponse(xhr, status, error);
    		}
    	});

	});

// $("body").on("contextmenu",function(e){
// return false;
// });
// $(document).keydown(function(e){
// if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 || e.keyCode === 117)){
// return false;
// }
// if(e.which === 123){
// return false;
// }
// if(e.metaKey){
// return false;
// }
// //document.onkeydown = function(e) {
// // "I" key
// if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
// return false;
// }
// // "J" key
// if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
// return false;
// }
// // "S" key + macOS
// if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
// return false;
// }
// if (e.keyCode == 224 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
// return false;
// }
// // "U" key
// if (e.ctrlKey && e.keyCode == 85) {
// return false;
// }
// // "F12" key
// if (event.keyCode == 123) {
// return false;
// }
// });
</script>

@if($ordertype == 1)

<!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACE_KEY') }}&libraries=places&callback=initialize"></script> -->
<script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key={{ env('PLACE_KEY') }}"></script>
<script src="{{ theme_asset('khana/public/js/store/home.js') }}"></script>
<script src="{{ theme_asset('khana/public/js/jquery.unveil.js') }}"></script>

<script>
	"use strict";
	if (localStorage.getItem('location') != null) {
		var locs= localStorage.getItem('location');
	}
	else{
		var locs = "$json->full_address ";
	}
	$('#location_input').val(locs);
	if (localStorage.getItem('lat') !== null) {
		var lati=localStorage.getItem('lat');
		$('#latitude').val(lati)
	}
	else{
		// var lati= $resturent_info->resturentlocation->latitude;
		var lati= "$resturent_info->resturentlocation->latitude";
	}

	if (localStorage.getItem('long') !== null) {
		var longlat=localStorage.getItem('long');
		$('#longitude').val(longlat)
	}
	else{
		//var longlat=  $resturent_info->resturentlocation->longitude;
		var longlat= "$resturent_info->resturentlocation->longitude";

	}


	// var resturentlocation="$json->full_address";
	var resturentlocation="";
	var feePerkilo= {{ $km_rate->value }};
	var mapOptions;
	var map;
	var marker;
	var searchBox;
	var city;

	function select_payment(type)
	{
		$('#payment_type').val(type);
	}
</script>
<!-- <script src="{{ theme_asset('khana/public/js/checkout/map.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{ theme_asset('khana/public/js/checkout/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('#event_date').datetimepicker({
        	 // initTime: true,
             // format: 'd-m-Y H:m',
             minDate: moment(),
             // startDate: new Date()
             // roundTime: 'ceil'
        });

    });
</script>

@endif

@endpush



