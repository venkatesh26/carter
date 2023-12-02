@extends('theme::layouts.app')
@push('css')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACE_KEY') }}&libraries=places&callback=initialize"></script>
@endpush
@section('content')
<div class="main-content mt-50 mb-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="register-card">
					
					<div class="register-progress text-center">
						<nav>
							<ul>
								<li class="active completed">
									<div class="register-progress-number">
										<span>&nbsp;</span>
									</div>
									<div class="register-progress-body">
										{{ __('Personal') }}
									</div>
								</li>
								<li class="active">
									<div class="register-progress-number">
										<span>&nbsp;</span>
									</div>
									<div class="register-progress-body">
										{{ __('Business') }}
									</div>
								</li>
								<li>
									<div class="register-progress-number">
										<span>&nbsp;</span>
									</div>
									<div class="register-progress-body">
										{{ __('Completion') }}
									</div>
								</li>
								
							</ul>
						</nav>
					</div>

					<form name="step2_form" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="register-card-body">
							<div class="row mt-30">
								@if(Session::has('errors'))
								<div class="col-lg-12">
									<p class="alert alert-danger">{{ Session::get('errors') }}</p>
								</div>
								@endif
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
                              
                                <!-- <div class="col-lg-6">
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
								</div> -->
                              
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
									<input  type="text" class="form-control" id="business_town" name="business_town" placeholder="Town/City">
									<label for="business_town">Town/City</label>
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

								<!--<div class="col-lg-4">
									<div class="form-floating mb-3">
										<input  type="text" class="form-control" id="country" name="country" placeholder="Country">
										<label for="country">Country</label>
									</div>
								</div>-->

								<div class="col-lg-4">
									<div class="form-group radio-input pb-19">
										<!--<label>Registered with fsa?</label>
										<div class="custom-control custom-checkbox d-flex align-items-center">
											Yes
											<input  type="radio" class="form-control" name="fsa" value="yes" checked>
											No
											<input  type="radio" class="form-control" name="fsa" value="no">
										</div>-->
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
										<!--<label>Food hygiene certificate?</label>
										<div class="custom-control custom-checkbox d-flex align-items-center">
											Yes
											<input  type="radio" class="form-control" name="food_hygiene_certificate" value="yes" checked>
											No
											<input  type="radio" class="form-control" name="food_hygiene_certificate" value="no">
										</div>-->
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

								<div class="col-lg-4">
									<div class="form-floating mb-3">
										<input  type="text" class="form-control" id="hygiene_rating" name="hygiene_rating" placeholder="Hygiene Rating">
										<label for="hygiene_rating">Hygiene Rating</label>
									</div>
								</div>
                              
                              	<!--<div class="col-lg-12">
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="agree" class="custom-control-input" id="agree" required="">
											<label class="custom-control-label" for="agree">Please accept our  <a href="#">Terms and conditions</a></label>
										</div>
									</div>                
                 				</div>
                              
                              	<div class="col-lg-12">
                                    <div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="agree2" class="custom-control-input" id="agree2" required="">
											<label class="custom-control-label" for="agree2">Please accept our  <a href="#">Privacy Policy</a></label>
										</div>
									</div>
								</div> --> 
							

								<div class="col-lg-12 bottom-btn">
									<div>
										<a href="{{ route('baker.register') }}"><button type="button" class="btn btn-danger">{{ __('Back') }}</button></a>
										<button type="submit" id="step2_submit" class="btn btn-danger">{{ __('Next & Save') }}</button>
									</div>
								</div>
							</div>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')

<script src="{{ theme_asset('khana/public/js/frontend/storeregister.js') }}"></script>

@endpush