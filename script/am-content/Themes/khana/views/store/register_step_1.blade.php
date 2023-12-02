@extends('theme::layouts.app')

@section('content')
<style>
.form-group.floating>label {
     bottom: 34px;
     left: 0px;
     position: relative;
     background-color: white;
     padding: 0px 5px 0px 5px;
     font-size: 1.1em;
     transition: 0.1s;
     pointer-events: none;
     font-weight: 500 !important;
     transform-origin: bottom left;
}
 .form-control.floating:focus~label{
     transform: translate(1px,-85%) scale(0.80);
     opacity: .8;
     color: #005ebf;
}

 hr {
     display: block;
     height: 1px;
     border: 0;
     border-top: 1px solid #ccc;
     margin: 1em 0;
     padding: 0;
}
 img {
     vertical-align: middle;
}
 fieldset {
     border: 0;
     margin: 0;
     padding: 0;
}
 textarea {
     resize: vertical;
}

 .hidden {
     display: none !important;
     visibility: hidden;
}
 .visuallyhidden {
     border: 0;
     clip: rect(0 0 0 0);
     height: 1px;
     margin: -1px;
     overflow: hidden;
     padding: 0;
     position: absolute;
     width: 1px;
}
 .visuallyhidden.focusable:active, .visuallyhidden.focusable:focus {
     clip: auto;
     height: auto;
     margin: 0;
     overflow: visible;
     position: static;
     width: auto;
}
 .invisible {
     visibility: hidden;
}
 .clearfix:before, .clearfix:after {
     content: " ";
     display: table;
}
 .clearfix:after {
     clear: both;
}
 .clearfix {
     *zoom: 1;
}

 article, aside, details, figcaption, figure, footer, header, hgroup, main, nav, section, summary {
     display: block;
}

 [hidden] {
     display: none;
}
 a:focus {
     outline: thin dotted;
}
 a:active, a:hover {
     outline: 0;
}
 small {
     font-size: 80%;
}
 sub, sup {
     font-size: 75%;
     line-height: 0;
     position: relative;
     vertical-align: baseline;
}
 sup {
     top: -0.5em;
}
 sub {
     bottom: -0.25em;
}

 img {
     border: 0;
    /* 1 */
     -ms-interpolation-mode: bicubic;
    /* 2 */
}
/** * Correct overflow displayed oddly in IE 9. */
 svg:not(:root) {
     overflow: hidden;
}
 figure {
     margin: 0;
}
 form {
     margin: 0;
}
 fieldset {
     border: 1px solid #c0c0c0;
     margin: 0 2px;
     padding: 0.35em 0.625em 0.75em;
}
 .wizard a, .tabcontrol a {
     outline: 0;
}
 .wizard ul, .tabcontrol ul {
     list-style: none !important;
     padding: 0;
     margin: 0;
}
 .wizard ul > li, .tabcontrol ul > li {
     display: block;
     padding: 0;
}
/* Accessibility */
 .wizard > .steps .current-info, .tabcontrol > .steps .current-info {
     position: absolute;
     left: -999em;
}
 .wizard > .content > .title, .tabcontrol > .content > .title {
     position: absolute;
     left: -999em;
}
 .wizard > .steps {
     position: relative;
     display: block;
     width: 100%;
}
 .wizard.vertical > .steps {
     display: inline;
     float: left;
     width: 30%;
}
 .wizard > .steps .number {
    /*font-size: 1.429em;
    */
}
 .wizard > .steps > ul > li {
     width: 33%;
}
 .wizard > .steps > ul > li, .wizard > .actions > ul > li {
     float: left;
}
 .wizard.vertical > .steps > ul > li {
     float: none;
     width: 100%;
}
 .wizard > .steps a, .wizard > .steps a:hover, .wizard > .steps a:active {
     display: block;
     width: auto;
     margin: 0 0.5em 0.5em;
     padding: 1em 1em;
     text-decoration: none;
     -webkit-border-radius: 5px;
     -moz-border-radius: 5px;
     border-radius: 5px;
}
 .wizard > .steps .disabled a, .wizard > .steps .disabled a:hover, .wizard > .steps .disabled a:active {
     background: #eee;
     color: #aaa;
     cursor: default;
     font-size: 16px;
     color: #2a2b4485;
     font-weight: 600;
}
 .wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active {
     color: #fff;
     cursor: default;
     background: #f15e53!important;
     font-weight: 600;
}
 .wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active {
     background: #4CAF50;
     color: #fff;
}
 .wizard > .steps .error a, .wizard > .steps .error a:hover, .wizard > .steps .error a:active {
     background: #ff3111;
     color: #fff;
}
 .wizard > .content {

     display: block;
     margin: 0.5em;
     min-height: 30em;
     overflow: hidden;
     position: relative;
     width: auto;
     -webkit-border-radius: 5px;
     -moz-border-radius: 5px;
     border-radius: 5px;
}

 .wizard > .content > .body {
     float: left;
}
 .wizard > .content > .body ul {
     list-style: disc !important;
}
 .wizard > .content > .body ul > li {
     display: list-item;
}
 .wizard > .content > .body > iframe {
     border: 0 none;
     width: 100%;
     height: 100%;
}
 .wizard > .content > .body input {
     display: block;
     border: 1px solid #ccc;
}
 .wizard > .content > .body input[type="checkbox"] {
     display: inline-block;
}

 .wizard > .content > .body label.error {
     color: #8a1f11;
     display: inline-block;
     margin-left: 1.5em;
}
 .wizard > .actions {
     position: relative;
     display: block;
     text-align: right;
     width: 100%;
}
 .wizard.vertical > .actions {
     display: inline;
     float: right;
     margin: 0 2.5%;
     width: 95%;
}
 .wizard > .actions > ul {
     display: inline-block;
     text-align: right;
}
 .wizard > .actions > ul > li {
     margin: 0 0.5em;
}
 .wizard.vertical > .actions > ul > li {
     margin: 0 0 0 1em;
}
 .wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active {
     border: none;
     color: #fff;
     font-weight: 500;
     background: #222;
     line-height: 38px;
     padding: 3px 27px;
     border-radius: 5px;
     font-size: 17px;
     margin-top: 10px;
}
 .wizard > .actions .disabled a, .wizard > .actions .disabled a:hover, .wizard > .actions .disabled a:active {
     background: #eee;
     color: #aaa;
}
 .wizard > .loading {
}
 .wizard > .loading .spinner {
}
/* Tabcontrol */
 .tabcontrol > .steps {
     position: relative;
     display: block;
     width: 100%;
}
 .tabcontrol > .steps > ul {
     position: relative;
     margin: 6px 0 0 0;
     top: 1px;
     z-index: 1;
}
 .tabcontrol > .steps > ul > li {
     float: left;
     margin: 5px 2px 0 0;
     padding: 1px;
     -webkit-border-top-left-radius: 5px;
     -webkit-border-top-right-radius: 5px;
     -moz-border-radius-topleft: 5px;
     -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
 .tabcontrol > .steps > ul > li:hover {
     background: #edecec;
     border: 1px solid #bbb;
     padding: 0;
}
 .tabcontrol > .steps > ul > li.current {
     background: #fff;
     border: 1px solid #bbb;
     border-bottom: 0 none;
     padding: 0 0 1px 0;
     margin-top: 0;
}
 .tabcontrol > .steps > ul > li > a {
     color: #5f5f5f;
     display: inline-block;
     border: 0 none;
     margin: 0;
     padding: 10px 30px;
     text-decoration: none;
}
 .tabcontrol > .steps > ul > li > a:hover {
     text-decoration: none;
}
 .tabcontrol > .steps > ul > li.current > a {
     padding: 15px 30px 10px 30px;
}
 .tabcontrol > .content {
     position: relative;
     display: inline-block;
     width: 100%;
     height: 35em;
     overflow: hidden;
     border-top: 1px solid #bbb;
     padding-top: 20px;
}
 .tabcontrol > .content > .body {
     float: left;
     position: absolute;
     width: 95%;
     height: 95%;
     padding: 2.5%;
}
 .tabcontrol > .content > .body ul {
     list-style: disc !important;
}
 .tabcontrol > .content > .body ul > li {
     display: list-item;
}

 fieldset {
     border: medium none !important;
     margin: 0 0 10px;
     min-width: 100%;
     padding: 0;
     width: 100%;
}

 .copyright {
     text-align: center;
}

 ::-webkit-input-placeholder {
     color: #888;
}
 :-moz-placeholder {
     color: #888;
}
 ::-moz-placeholder {
     color: #888;
}
 :-ms-input-placeholder {
     color: #888;
}
 .steps > ul > li > a, .actions li a {
     padding: 10px;
     text-decoration: none;
     margin: 1px;
     display: block;
     color: #777;
}
 .steps > ul > li, .actions li {
     list-style:none;
}


</style>
@push('css')
<link rel="stylesheet" href="{{ theme_asset('khana/public/css/vanillaSelectBox.css') }}">
@endpush
<?php
// print_r($request);exit;
?>
<div class="main-content mt-50 mb-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="register-card">

					<form method="POST" autocomplete="off" name="main_form" id="main_form" enctype="multipart/form-data">
						 @csrf
						<div>
							<h3>{{ __('Personal') }}</h3>
							<section>

								<div class="register-card-body">
									<div class="row mt-30">
										@if(Session::has('errors'))
										<div class="col-lg-12">
											<p class="alert alert-danger">{{ Session::get('errors') }}</p>
										</div>
										@endif
										<div class="col-lg-6">
											<div class="form-floating mb-3">
												<input  type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
												<label for="first_name">First Name</label>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-floating mb-3">
												<input  type="text" class="form-control"  id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
												<label for="last_name">Last Name</label>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-floating mb-3">
												<input type="email" class="form-control" id="email" name="email"  placeholder="Email Address" value="{{ old('email') }}">
												<label for="email">Email Address</label>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-floating mb-3">
												<input  type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" value="{{ old('dob') }}">
												<label for="dob">Date of Birth</label>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-floating mb-3">
											<input  type="password" class="form-control" id="password" name="password" id="password" placeholder="Password">
											<label for="password">Password</label>
											</div>
										</div>

										<div class="col-lg-6">
											<div class="form-floating mb-3">
											<input  type="password" class="form-control" name="c_password" id="c_password" placeholder="Confirm Password">
											<label for="c_password">Confirm Password</label>
											</div>
										</div>

										<div class="col-lg-6">
											<div class="input-group mb-3 mt-3">
												<span class="input-group-text">+44</span>
												<div class="form-floating form-floating-group flex-grow-1">
													<input type="text" class="form-control mb-0" id="phone" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">
													<label class="ms-1" for="phone">Phone Number</label>
												</div>
											</div>
										</div>
									</div>
								</div>

							</section>

							<h3>{{ __('Business') }}</h3>
							<section>

								<div class="register-card-body">
									<div class="row mt-30">
										@if(Session::has('errors'))
										<div class="col-lg-12">
											<p class="alert alert-danger">{{ Session::get('errors') }}</p>
										</div>
										@endif
										<div class="col-lg-6">
											<div class="form-floating1 mb-3">
											<label for="business_type">Business Name</label>
											<select class="form-control" id="business_type" name="business_type" >
												<option value="">Select Business Type</option>
												<option value="3">Cater</option>
												<option value="5">Baker</option>
											</select>
											</div>
										</div>
										<div class="col-lg-6">

										</div>
										<div class="col-lg-6">
											<div class="form-floating mb-3">
											<input  type="text" class="form-control" id="business_name" name="business_name" placeholder="First Name">
											<label for="business_name">Business Name</label>
											</div>
										</div>


										<div class="col-lg-6">
											<div class="form-floating mb-3">
											<input  type="text" class="form-control" id="business_disp_name" name="business_disp_name" placeholder="Business Displayname">
											<label for="business_disp_name">Business Displayname</label>
											</div>
										</div>

										<div class="col-lg-6">
											<div class="form-group mb-3">
												<label class="bl">Business Logo</label>
												<input type="file" class="form-control" name="business_logo_file">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-floating">
												<textarea class="form-control" name="business_desc" id="business_desc" placeholder="Leave a comment here" style="height: 139px"></textarea>
												<label for="business_desc">Business Description</label>
											</div>
										</div>
                                        <input type="hidden" id="lat" name="lat" required="">
                                        <input type="hidden" id="long" name="long" required="">
                                        <input type="hidden" id="city" name="city" required="">
										<div class="col-lg-12">
											<div class="form-floating mb-3">
											<input  type="text" class="form-control" id="business_address_1" name="business_address_1" placeholder="Business Address 1">
											<label for="business_address_1">Business Address 1</label>
											</div>
										</div>

										<div class="col-lg-12">
											<div class="form-floating mb-3">
											<input  type="text" class="form-control" id="business_address_2" name="business_address_2" placeholder="Business Address 2">
											<label for="business_address_2">Business Address 2</label>
											</div>
										</div>

										<div class="col-lg-4">
											<div class="form-floating mb-3">
											<input  type="text" class="form-control" id="business_town" name="business_town" placeholder="Town/City" readonly>
											<label for="business_town" >Town/City</label>
											</div>
										</div>

										<div class="col-lg-4">
											<div class="form-floating mb-3">
											<input  type="text" class="form-control" id="business_country" name="business_country" placeholder="County">
											<label for="business_country">County</label>
											</div>
										</div>

										<div class="col-lg-4">
											<div class="form-floating mb-3">
												<input  type="text" class="form-control" id="business_postal_code" name="business_postal_code" placeholder="Post Code">
												<label for="business_postal_code">Post Code</label>
											</div>
										</div>

										<div class="col-lg-4">
											<div class="form-group radio-input pb-19">
												<label>Registered with fsa?</label>
												<br>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" id="inlineCheckbox1" name="registered_fsa" value="1" checked>
													<label class="form-check-label" for="inlineCheckbox1">Yes</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" id="inlineCheckbox2" name="registered_fsa" value="0">
													<label class="form-check-label" for="inlineCheckbox2">No</label>
												</div>
											</div>
										</div>
										<div class="col-lg-8">
											<div class="form-group mb-3">
												<label>If Yes</label>
												<input type="file" class="form-control pb-5" name="registered_fsa_file">
											</div>
										</div>
										<div class="col-lg-4">
											<div class="form-group radio-input pb-19">
												<label>Food hygiene certificate?</label>
												<br>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" id="inlineCheckbox3" name="hygiene_certificate" value="1" checked>
													<label class="form-check-label" for="inlineCheckbox3">Yes</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" id="inlineCheckbox4" name="hygiene_certificate" value="0">
													<label class="form-check-label" for="inlineCheckbox4">No</label>
												</div>
											</div>
										</div>
										<div class="col-lg-8">
											<div class="form-group mb-3">
												<label>If Yes</label>
												<input  type="file" class="form-control pb-5" name="hygiene_certificate_file">
											</div>
										</div>

										<div class="col-lg-4" id="hygine_rating_div">
											<div class="form-floating1 mb-3">
												<label for="hygiene_rating">Hygiene Rating</label>
												<select class="form-control" id="hygiene_rating" name="hygiene_rating">
													<option value="">Select Rating</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>
										</div>

									</div>
								</div>

							</section>

							<h3>{{ __('Completion') }}</h3>
							<section>
								<div class="register-card-body">
									<div class="row mt-30">
										@if(Session::has('errors'))
										<div class="col-lg-12">
											<p class="alert alert-danger">{{ Session::get('errors') }}</p>
										</div>
										@endif

										<div class="col-lg-12 cater_fields">
											<h5 class="ssft">Cuisine</h5>
										</div>

										<div class="col-lg-6 cater_fields">
											<div class="form-floating">
												<select class="form-control" id="cuisine" name="cuisine[]" multiple="multiple" size="4" required style="height: auto;">
													<option value="1">Indian</option>
													<option value="2">Sri Lanka</option>
													<option value="3">Bangladeshi</option>
													<option value="4">Chinese</option>
													<option value="5">Thai</option>
													<option value="6">Italian</option>
													<option value="7">Japanese</option>
													<option value="8">Korean</option>
													<option value="9">English</option>
													<option value="10">Caribbean</option>
													<option value="11">Polish</option>
													<option value="12">Others</option>
												</select>
												<!--<label for="floatingSelect">Works with selects</label>-->
											</div>
										</div>
										<div class="col-lg-6 cater_fields">
											<div class="form-floating mb-3">
												<input  type="text" class="form-control" id="others_specifiy" name="others_specifiy"  placeholder="Others specify">
												<label for="others_specifiy">Others specify</label>
											</div>
										</div>

										<div class="col-lg-12">
											<h5 class="ssft">Can you deliver</h5>
										</div>

										<div class="col-lg-12">
                                                       <div class="form-check">
                                                            <input class="form-check-input" type="radio" id="collection" name="can_you_deliver[]" value="Collection only">
                                                            <label class="form-check-label" for="collection"> Collection only </label>
                                                       </div>
											<div class="form-check">
												<input class="form-check-input" type="radio" id="radius" name="can_you_deliver[]" value="Collection and free delivery up to 3 mile radius">
												<label class="form-check-label" for="radius">Free Delivery up to 3 mile radius </label>
											</div>

											<div class="form-check">
												<input class="form-check-input" type="radio" id="cost_miles" name="can_you_deliver[]" value="£20 up to 10 miles">
												<label class="form-check-label" for="cost_miles">£20 up to 10miles </label>
											</div>
                                                       <div class="extramileprice d-none">
                                                            <div class="col-lg-12">
                                                                 <h5 class="ssft">Enter pence per mile</h5>
                                                            </div>
                                                            <div class="col-lg-6 cater_fields  extramileprice">
                                                                 <div class="form-floating mb-3">
                                                                      <input  type="number" class="form-control" id="extra_per_miles" name="extra_per_miles"  placeholder="Enter pence per mile">
                                                                      <label for="extra_per_miles">Enter pence per mile</label>
                                                                 </div>
                                                            </div>
                                                       </div>
										</div>

										<div class="col-lg-12">
											<h5 class="ssft">No of guests you can take</h5>
										</div>

										<div class="col-lg-6 cater_fields">
											<div class="form-floating mb-3">

												<input  type="text" class="form-control" id="guests_max" name="guests_max" placeholder="Maximum">
												<label for="guests_max">Maximum</label>
											</div>
										</div>

										<div class="col-lg-6 cater_fields">
											<div class="form-floating mb-3">
											<input  type="text" class="form-control" id="guests_min" name="guests_min" placeholder="Minimum">
											<label for="guests_min">Minimum</label>
											</div>
										</div>

										<div class="col-lg-12 cater_fields">
											<h5 class="ssft">Do you have minimum order amount?</h5>
										</div>
										<div class="col-lg-4 cater_fields">
											<div class="form-group radio-input mt-3 cpb-08">
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" id="inlineCheckbox1" name="min_order" value="1" checked>
													<label class="form-check-label" for="inlineCheckbox1">Yes</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" id="inlineCheckbox2" name="min_order" value="0">
													<label class="form-check-label" for="inlineCheckbox2">No</label>
												</div>
											</div>
										</div>
										<div class="col-lg-8 cater_fields">
											<div class="form-floating mb-3">
												<input  type="text" class="form-control floating pb-3" id="min_order_amount" name="min_order_amount" placeholder="If Yes">
												<label for="min_order_amount">If Yes</label>
											</div>
										</div>


										<div class="col-lg-12 d-none" >
											<h5 class="ssft">Extra Services with cost</h5>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="waiter" name="extra_serivices[]" value="Provide waiter service upto 20 people £___">
												<label class="form-check-label" for="waiter"> Provide waiter service upto 20 people £___</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="waiter" name="extra_serivices[]" value="Provide waiter service upto 20 - 50 people £___">
												<label class="form-check-label" for="waiter"> Provide waiter service upto 20 - 50 people £___</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="waiter" name="extra_serivices[]" value="Provide waiter service 50+ £___">
												<label class="form-check-label" for="waiter"> Provide waiter service 50+ £___</label>
											</div>
										</div>

										<div class="col-lg-12">
											<h5 class="ssft">Specialities</h5>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="wedding" name="specialities[]" value="Wedding catering-delivery is must">
												<label class="form-check-label" for="wedding"> Wedding catering-delivery is must </label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="cooks" name="specialities[]" value="Home cooks">
												<label class="form-check-label" for="cooks"> Home cooks </label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" id="catering" name="specialities[]" value="Corporate catering - delivery is must">
												<label class="form-check-label" for="catering"> Corporate catering - delivery is must </label>
											</div>
										</div>
									</div>

								</div>
							</section>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key={{ env('PLACE_KEY') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.js"></script>
<script src="{{ theme_asset('khana/public/js/vanillaSelectBox.js') }}"></script>
<script>
$(document).on('change','input[name="can_you_deliver[]"]', function() {
     // console.log($(this).val());

     if($(this).val() == "£20 up to 10 miles"){
          $(".extramileprice").removeClass("d-none");
     }else{
          $(".extramileprice").addClass("d-none");
     }
});
</script>
@endpush
