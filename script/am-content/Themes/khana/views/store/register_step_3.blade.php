@extends('theme::layouts.app')

@push('css')
<link rel="stylesheet" href="{{ theme_asset('khana/public/css/vanillaSelectBox.css') }}">
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
								<li class="active completed">
									<div class="register-progress-number">
										<span>&nbsp;</span>
									</div>
									<div class="register-progress-body">
										{{ __('Business') }}
									</div>
								</li>
								<li class="active completed">
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
					<div class="register-main-card">
						<div class="row">
							<div class="col-lg-12">
								<div class="main-info ">
									
									<form name="step3_form" method="POST">
										@csrf
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
														<select class="form-select" id="cuisine" name="cuisine" multiple="multiple" size="4" required>
															<!-- <option value="">Select</option> -->
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
												<input type="hidden" id="role_id" name="role_id" value="<?php echo $user->role_id; ?>">
												<!--<div class="col-lg-6">
													<div class="form-floating mb-3">
														<input  type="text" class="form-control mt-2" id="cuisine_1" name="cuisine[]" placeholder="Cuisine 1">
														<label for="cuisine_1">Cuisine 1</label>
													</div>
													<div class="form-floating mb-3">
														<input  type="text" class="form-control mt-2" id="cuisine_2" name="cuisine[]"  placeholder="Cuisine 2">
														<label for="cuisine_2">Cuisine 2</label>
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-floating mb-3">
														<input  type="text" class="form-control mt-2" id="cuisine_3" name="cuisine[]"  placeholder="Cuisine 3">
														<label for="cuisine_3">Cuisine 3</label>
													</div>
													<div class="form-floating mb-3">
														<input  type="text" class="form-control mt-2" id="cuisine_4" name="cuisine[]"  placeholder="Cuisine 4">
														<label for="cuisine_4">Cuisine 4</label>
													</div>
												</div>-->
												

												<div class="col-lg-12">
													<h5 class="ssft">Can you deliver</h5>
												</div>

												<div class="col-lg-12">
													<!--<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="delivery_type[]" class="custom-control-input" id="radius">
															<label class="custom-control-label" for="radius">Free within 3 mile radius</label>
														</div>
													</div> 
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="delivery_type[]" class="custom-control-input" id="cost_miles">
															<label class="custom-control-label" for="cost-miles">£20 upto 10 miles and £1.50 per extra mile after 10 miles</label>
														</div>
													</div> 
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="delivery_type[]" class="custom-control-input" id="collection">
															<label class="custom-control-label" for="collection">Collection only</label>
														</div>
													</div>-->

													<div class="form-check">
														<input class="form-check-input" type="checkbox" id="radius" name="can_you_deliver[]" value="Collection and free delivery up to 3 mile radius">
														<label class="form-check-label" for="radius"> Collection and free delivery up to 3 mile radius </label>
													</div>
													<div class="form-check">
														<input class="form-check-input" type="checkbox" id="collection" name="can_you_deliver[]" value="Collection only">
														<label class="form-check-label" for="collection"> Collection only </label>
													</div>
													<div class="form-check">
														<input class="form-check-input" type="checkbox" id="cost_miles" name="can_you_deliver[]" value="£20 up to 10 miles and £___ per extra mile">
														<label class="form-check-label" for="cost_miles"> £20 up to 10 miles and £___ per extra mile </label>
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
														<!---<div class="custom-control custom-checkbox d-flex align-items-center">
															Yes
															<input  type="radio" class="form-control" name="min_order" value="yes" checked>
															No
															<input  type="radio" class="form-control" name="min_order" value="no">
														</div>-->
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
													<!--<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="extra_service[]" class="custom-control-input" id="waiter">
															<label class="custom-control-label" for="waiter">Provide waiter service</label>
														</div>
													</div>
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="extra_service[]" class="custom-control-input" id="cutleries">
															<label class="custom-control-label" for="cutleries">Provide cutleries</label>
														</div>
													</div>-->
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
													<!--<div class="form-check">
														<input class="form-check-input" type="checkbox" id="cutleries" name="extra_service[]">
														<label class="form-check-label" for="cutleries"> Provide cutleries </label>
													</div>-->
												</div>
											
												<div class="col-lg-12">
													<h5 class="ssft">Specialities</h5>
													<!--<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="specialities[]" class="custom-control-input" id="Wedding">
															<label class="custom-control-label" for="Wedding">Wedding catering-delivery is must</label>
														</div>
													</div>
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="specialities[]" class="custom-control-input" id="cooks">
															<label class="custom-control-label" for="cooks">Home cooks</label>
														</div>
													</div>
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" name="specialities[]" class="custom-control-input" id="catering">
															<label class="custom-control-label" for="catering">Corporate catering - delivery is must</label>
														</div>
													</div>-->

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
												
												
												<div class="col-lg-12 bottom-btn">
													<div>
														<a href="{{ route('restaurant.register_step_2') }}"><button type="button" class="btn btn-danger">{{ __('Back') }}</button></a>
														<button type="submit" id="step3_submit" class="btn btn-danger">{{ __('Register') }}</button>
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
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')

<script src="{{ theme_asset('khana/public/js/vanillaSelectBox.js') }}"></script>

@endpush