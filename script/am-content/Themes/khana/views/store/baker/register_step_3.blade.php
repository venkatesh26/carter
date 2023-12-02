@extends('theme::layouts.app')

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
														<a href="{{ route('baker.register_step_2') }}"><button type="button" class="btn btn-danger">{{ __('Back') }}</button></a>
														<button type="submit" id="step3_submit" class="btn btn-danger">{{ __('Save') }}</button>
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