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
								<div class="main-info text-center">
									<i class="far fa-check-circle"></i>
									<h4>{{ __("Your request is sent successfully and it's pending for approval") }}</h4>
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