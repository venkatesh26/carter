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

/* .form-control.floating:valid~label{
    transform-origin: bottom left;
    transform: translate(1px,-85%) scale(0.80);
    opacity: .8;
} */
</style>
<div class="main-content mt-50 mb-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="register-card">
					<div class="register-progress text-center">
						<nav>
							<ul>
								<li class="active">
									<div class="register-progress-number">
										<span>&nbsp;</span>
									</div>
									<div class="register-progress-body">
										{{ __('Personal') }}
									</div>
								</li>
								<li>
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
					<form name="step1_form" method="POST">
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
										<input  type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ $user->first_name ?? '' }}">
										<label for="first_name">First Name</label>
									</div>
								</div>
                              	<div class="col-lg-6">
									<div class="form-floating mb-3">
										<input  type="text" class="form-control"  id="last_name" name="last_name" placeholder="Last Name">
										<label for="last_name">Last Name</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-floating mb-3">
										<input type="email" class="form-control" id="email" name="email"  placeholder="Email Address">
										<label for="email">Email Address</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-floating mb-3">
										<input  type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth">
										<label for="dob">Date of Birth</label>
									</div>
								</div>
								<!--<div class="col-lg-6">
									<div class="form-group radio-input mb-0 mt-2 cpb-08">
										<label>Gender</label>
										<br>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" id="inlineCheckbox1" name="gender" value="male" checked>
											<label class="form-check-label" for="inlineCheckbox1">Male</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" id="inlineCheckbox2" name="gender" value="female">
											<label class="form-check-label" for="inlineCheckbox2">Female</label>
										</div>
									</div>
								</div>-->
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
											<input type="text" class="form-control mb-0" id="phone" name="phone" placeholder="Phone Number">
											<label class="ms-1" for="phone">Phone Number</label>
										</div>
									</div>
								</div>
								
							
								<div class="col-lg-12 bottom-btn">
									<div>
										<button type="submit" id="step1_submit">{{ __('Next & Save') }}</button>
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