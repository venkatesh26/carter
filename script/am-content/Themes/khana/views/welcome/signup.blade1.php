@extends('theme::layouts.app')
@section('content')
<!-- hero area start -->
<section id="signup">
    <div class="bg-image"></div>
</section>

<div class="signup-page pt-50">
	<div class="container">
		<div class="row mb-20">
			<div class="col-lg-12 howitworks">
				<h3 class="text-center mb-3">How It Works</h3>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
			</div>
		</div>
		<div class="row reg-content">
            <div class="reg-btn mb-30">
                <a href="{{ route('restaurant.register') }}" class="btn">Register as a caterer</a>
                <a href="{{ route('baker.register') }}" class="btn">Register as a baker</a>
			</div>
            
		</div>
	</div>
</div>


@endsection

@push('js')
<script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key={{ env('PLACE_KEY') }}"></script>
<script src="{{ theme_asset('khana/public/js/store/home.js') }}"></script>
<script src="{{ theme_asset('khana/public/js/jquery.unveil.js') }}"></script>
        
@endpush