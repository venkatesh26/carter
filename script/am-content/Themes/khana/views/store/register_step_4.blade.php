@extends('theme::layouts.app')

@section('content')
<div class="main-content mt-50 mb-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="register-card">

					<div class="register-main-card">
						<div class="row">
							<div class="col-lg-12">
								<div class="main-info text-center">
									<i class="far fa-check-circle"></i>
									<h4>{{ __("Account already exist. Please login to complete your profile") }}</h4>
									<p class="mt-5"><a class="btn" href="{{ route('login') }}">Login</a></p>
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
