	@extends('theme::layouts.app')
@section('content')
<!-- hero area start -->
<!-- <section id="signup">
    <div class="bg-image"></div>
</section>
 -->
<style>
.signup-page .cater-info p{font-size: 17px;}
.howitworks p{
	text-align: justify;
}
.signup-page p{font-size: 17px;font-family: 'Poppins' !important;}
#myCarousel .carousel-caption {

    bottom: initial;
    top: 35%;
}
/*#myCarousel .carousel-caption h1{
	font-family: 'Poppins' !important;font-weight: 500 !important;font-size: 55px;
}*/
#myCarousel p{
	font-size: 19px;
    font-family: 'Poppins' !important;
    color: #000;
    font-weight: 500;
}
.cater-pricing-table{
	width: 80%;
	background-color: #fff;
	border-radius: 15px;
}
.cater-pricing-table p span{
	font-size: 13px;
}

.card-body .card-text{
font-size: 13px;
}

</style>
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
       	<img src="{{ asset('uploads/order1.jpg') }}" class="w-100" alt="Los Angeles">
          <div class="carousel-caption text-start">
            <h1>Partner with us</h1>
            <div class="col-lg-5 ">
            	<p>We welcome all the home cooks and the passionate caterers tto join us.</p>
        	</div>
          </div>
      </div>

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>


  <div class="signup-page pt-50">
	<div class="container">
		<div class="row mb-20">
			<div class="col-lg-12 cater-info">
				<p>Dear Caterer/Baker, </p>
				<p>We want to provide an equal platform for all the home cooks, passionate caterers and bakers to find the right customers to flourish their business. We have made an effort to give you a simple but powerful tool to run your business without any need for investment for the website, marketing E. promotion. </p>
				<p>Let us join the hands and make this platform successful. </p>
				<p>Yours truly,</p>
				<p> CEO, Cateranevent.com </p>

			</div>
		</div>
	</div>
</div>





<div class="signup-page pt-50">
	<div class="container">
		<div class="row mb-20">
			<div class="col-lg-12 howitworks">
				<h2 class="text-center mb-3">How It Works</h2>
				<div class="col-lg-7 mx-auto">
				<p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.  </p>
				</div>
			</div>
		</div>

		<div class="row mb-20">
			<div class="col-lg-10 mx-auto" style="background-color: #FAF2F0;-webkit-box-shadow: 0px 0px 44px 28px rgb(250 242 240 / 75%);-moz-box-shadow: 0px 0px 44px 28px rgba(0,0,0,0.95);box-shadow: 0px 0px 44px 28px rgb(250 242 240 / 95%);">
				<div class="row pt-30 pb-30" >
					<div class="col-lg-3 text-center">
						<div class="card" >
						  <img src="{{ asset('uploads/01.png') }}" class="w-50 mx-auto">
						  <div class="card-body">
						    <h5 class="card-title">Choose caterer</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
						  </div>
						</div>
					</div>
					<div class="col-lg-3 ">
						<div class="card text-center" >
						  <img src="{{ asset('uploads/02.png') }}" class="w-50 mx-auto">
						  <div class="card-body">
						    <h5 class="card-title">Select Items</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  </div>
						</div>
					</div>

					<div class="col-lg-3 ">
						<div class="card text-center">
						  <img src="{{ asset('uploads/03.png') }}" class="w-50 mx-auto">
						  <div class="card-body">
						    <h5 class="card-title">Make Payment</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  </div>
						</div>
					</div>


					<div class="col-lg-3 ">
						<div class="card text-center">
						  <img src="{{ asset('uploads/04.png') }}" class="w-50 mx-auto">
						  <div class="card-body">
						    <h5 class="card-title">Contact Caterer</h5>
						    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="signup-page pt-50">
	<div class="container">
		<div class="row mb-20">
			<div class="col-lg-12 ">
				<h2 class="text-center mb-3">Membership Benefits</h2>
				<div class="col-lg-7 mx-auto">
					<p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
				</div>
			</div>
		</div>

		<div class="row  mb-50 h-100">

			<div class="col-lg-4 mt-30">
				<img src="{{ asset('uploads/package1.jpg') }}" class="w-100" alt="Los Angeles" style="height: 300px !important;    border-radius: 15px;">
			</div>
			<div class="col-lg-8 mt-30">
				<div class="col-lg-10  mx-auto">
					<h3 class="text-left mb-3">Simple Menu Packages</h3>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
				</div>
			</div>

		</div>

		<div class="row mb-40 h-100">

			<div class="col-lg-8 mt-30">
				<div class="col-lg-10 ">
					<h3 class="text-left mb-3">User friendly website</h3>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
				</div>
			</div>

			<div class="col-lg-4 mt-30">
				<img src="{{ asset('uploads/package2.jpg') }}" class="w-100" alt="Los Angeles" style="height: 300px !important;    border-radius: 15px;">
			</div>
		</div>


		<div class="row mb-50 h-100">
			<div class="col-lg-4 mt-30">
				<img src="{{ asset('uploads/package.jpg') }}" class="w-100" alt="Los Angeles" style="height: 300px !important;    border-radius: 15px;">
			</div>
			<div class="col-lg-8 mt-30">
				<div class="col-lg-10  mx-auto">
					<h3 class="text-left mb-3">Marketing & Promotion</h3>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
					<p class="text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry.  Lorem Ipsum has been the industry's standard dummy text ever since the 1500.</p>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="signup-page pt-50 pb-50" style="background-color: #EBEBEB;overflow:auto;">
	<div class="container">
		<div class="row mb-20">
			<div class="col-lg-12 ">
				<h2 class="text-center mb-3">Simple Pricing</h2>

				<p class="text-center">Choose a plan that works for you</p>
			</div>
		</div>
		<div class="row mb-20">
			<div class="col-lg-8 mx-auto">
				<div class="row">
					<div class="col-lg-6 ">

						<div class="cater-pricing-table text-center p-4">
							<h4>Cater <span style="color: #EE5E53;">Monthly</span></h4>
							<p><span>Select if you are just starting and want to test your business</span></p>
							<h4>£{{$plan[0]->s_price}}/M</h4>
							<p class="mt-4"><a class="btn btn-primary home-joinus" href="{{ route('restaurant.register') }}" data-planid="{{$plan[0]->strip_plan_id}}" role="button">Get Started</a></p>
							<p><span>Billed Monthly. No Contract</span></p>
						</div>
					</div>
					<div class="col-lg-6 ">
						<div class="cater-pricing-table text-center p-4">
							<h4>Cater <span style="color: #EE5E53;">Annually</span></h4>
							<p><span>Become a partner to grow your business</span></p>
							<h5><del>£12.99/M</del></h5>
							<h4>£{{$plan[1]->s_price}}/Y</h4>
							<p class="mt-4"><a class="btn btn-primary home-joinus" href="{{ route('restaurant.register') }}" data-planid="{{$plan[1]->strip_plan_id}}" role="button">Get Started</a></p>
							<p><span>Billed Annually. Yearly Contract</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


