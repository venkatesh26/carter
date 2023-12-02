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


<!-- checkout area start -->
<section>
	<div class="checkout-area">
		<div class="container">
			<div class="row mt-50">
				<div class="col-lg-8">
					<form action="{{ route('restaurant.register_step_2') }}" method="POST" id="place_order_form">
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
							<h6 class="text-danger none" id="msg">{{ __('Service Not Available On Your Area') }}</h6>
							<div class="delivery-form">
								<div class="row">

									<div class="col-lg-12">
										<div class="select-payment-area mt-50">
											<h3><span>2</span> {{ __('Select Payment Method') }}</h3>
											<div class="row justify-content-center select_payment">

												@if(env('STRIPE_KEY') != '')
												<div class="col-lg-3 payment_section">
													<label for="stripe" class="single-payment-section stripe text-center mb-30" onclick="select_payment('stripe')">
														<img class="img-fluid" src="{{ theme_asset('khana/public/img/stripe.png') }}" alt="">
													</label>
													<input type="radio" name="payment_method" value="stripe" id="stripe" class="d-none">
												</div>
												@endif
												@if ($credentials != null)
												@if($credentials->paypal_status == 'enabled')
												<div class="col-lg-3 payment_section">
													<label for="paypal" class="single-payment-section paypal text-center mb-30" onclick="select_payment('paypal')">
														<img class="img-fluid" src="{{ theme_asset('khana/public/img/paypal.png') }}" alt="">
													</label>
													<input id="paypal" type="radio" class="d-none" name="payment_method" value="paypal">
												</div>
												@endif

												@if($credentials->toyyibpay_status == 'enabled')
												<div class="col-lg-3 payment_section">
													<label for="toyyibpay" class="single-payment-section toyyibpay text-center mb-30" onclick="select_payment('toyyibpay')">
														<img class="img-fluid" src="{{ theme_asset('khana/public/img/toyyibpay.png') }}" alt="">
													</label>
													<input id="toyyibpay" type="radio" class="d-none" name="payment_method" value="toyyibpay">
												</div>
												@endif

												@if($credentials->razorpay_status == 'enabled')
												<div class="col-lg-3 payment_section">
													<label for="razorpay" class="single-payment-section razorpay text-center mb-30" onclick="select_payment('razorpay')">
														<img class="img-fluid" src="{{ theme_asset('khana/public/img/razorpay-logo.svg') }}" alt="">
													</label>
													<input id="razorpay" type="radio" class="d-none" name="payment_method" value="razorpay">
												</div>
												@endif

												@if($credentials->instamojo_status == 'enabled')
												<div class="col-lg-3 payment_section">
													<label for="instamojo" class="single-payment-section text-center instamojo" onclick="select_payment('instamojo')">
														<img class="img-fluid" src="{{ theme_asset('khana/public/img/logo_instamojo.webp') }}" alt="">
													</label>
													<input id="instamojo" type="radio" class="d-none" name="payment_method" value="instamojo">
												</div>
												@endif
												@endif



											</div>
										</div>
									</div>

									<div class="col-lg-12">
										<div class="form-group">
											<div class="place-order mt-20">
												<button id="place_order_button">{{ __('Make Payment') }}</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
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
    				window.location.reload();
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

<!--
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACE_KEY') }}&libraries=places&callback=initialize"></script>
<script>
	"use strict";
	if (localStorage.getItem('location') != null) {
		var locs= localStorage.getItem('location');
	}
	else{
		var locs = "$json->full_address";
	}
	$('#location_input').val(locs);
	if (localStorage.getItem('lat') !== null) {
		var lati=localStorage.getItem('lat');
		$('#latitude').val(lati)
	}
	else{
		// var lati=  $resturent_info->resturentlocation->latitude ;
		var lati= "";
	}

	if (localStorage.getItem('long') !== null) {
		var longlat=localStorage.getItem('long');
		$('#longitude').val(longlat)
	}
	else{
		// var longlat=  $resturent_info->resturentlocation->longitude ;
		var longlat= "";

	}


	var resturentlocation=" $json->full_address";
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
<script src="{{ theme_asset('khana/public/js/checkout/map.js') }}"></script>
 -->

@endpush

