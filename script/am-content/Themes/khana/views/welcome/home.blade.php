@extends('theme::layouts.app')
@section('content')
<!-- hero area start -->

<style>
@media(max-width:767px){
    .search-input input#location_input{
        width: 100% !important;
        border-right: 0px solid #fff !important;
    }
}
.pac-container {
    border-top: 0px solid #d9d9d9 !important;
}
.search-input .slider-search-content-area {
    padding-top: 5px !important;
    padding-bottom: 5px !important;
}
.single-restaturants .restaturants-content {
    min-height: 65px;
}
.single-restaturants img{
    height: 175px;
}
</style>
<section id="hero">
   <div class="hero-area">
      <div class="container">
         <div class="row">
            <div class="col-lg-8">
               <div class="hero-main-content">
                  <p id="hero_des">We bring the home cooks to your doorstep</p>
                  <h2 id="hero_title">Find Your <span class="sanbrand">Local Caterer</span><br/>
                     For Your Event
                  </h2>
                  <!--       <h2 id="hero_title">{{ content('hero','hero_title') }}</h2>
                     <p id="hero_des">{{ content('hero','hero_des') }}</p>  -->
                  <nav>
                     <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Caterer</a>
                        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Bakers</a>
                     </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                     <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="food-search-bar">
                           <form action="{{ route('resturents.search') }}" id="searchform">
                              <div class="search-input">
                                 <div class="row w-100">
                                    <div class="col-lg-9 col-9 pr-0">
                                       <!-- <input type="hidden" id="lat" name="lat" required="">
                                       <input type="hidden" id="long" name="long" required=""> -->
                                       <input type="hidden" id="city" name="city" required="">
                                       <div class="slider-search-content-area">
                                          <input type="text" placeholder="{{ __('Postal Code') }}" id="location_input1" class="sanbar" name="postalcode" required="">
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-3 pr-0 text-right" style="text-align: right;">
                                       <button type="submit" id="button_title"><i class="fa fa-search"></i></button>
                                       <!-- <a href=""><img src="{{ asset('uploads/search01.png') }}" /></a> -->
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="food-search-bar">
                           <form action="{{ route('resturents.search') }}" id="searchform">
                              <div class="search-input">
                                 <div class="row w-100">
                                    <div class="col-lg-9 col-9 pr-0">
                                       <input type="hidden" id="lat" name="lat" required="">
                                       <input type="hidden" id="long" name="long" required="">
                                       <input type="hidden" id="city" name="city" required="">
                                       <div class="slider-search-content-area">
                                          <input type="text" placeholder="{{ __('Your Location') }}" id="location_input" class="sanbar" name="address" required="">

                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-3 pr-0 text-right" style="text-align: right;">
                                       <button type="submit" id="button_title"><i class="fa fa-search"></i></button>
                                       <!-- <a href=""><img src="{{ asset('uploads/search01.png') }}" /></a> -->
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-4">
               <!--  <div class="slider-img">
                  <img id="hero_right_image"  class="lazy" src="{{ asset('uploads/lazyload-138x135.png') }}" data-src="{{ asset(content('hero','hero_right_image')) }}" alt="{{ env('APP_NAME') }}">
                  <div class="slider-content">
                      <h3 id="hero_right_title">{{ content('hero','hero_right_title') }}</h3>
                      <h5 id="hero_right_content">{{ content('hero','hero_right_content') }}</h5>
                  </div>
                  </div>-->
            </div>
         </div>
      </div>
   </div>
</section>
<!-- hero area end -->
@php
$categories=\App\Category::where('type',2)->select('name','slug','avatar')->inRandomOrder()->take(20)->get();

@endphp
@if(count($categories) > 0)
<!-- all restaurants slider area start -->
<div class="restaurants-slider-area pt-50 pb-50" id="category">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="restaurants-slider-title">
                    <h1 class="text-center" id="category_title">{{ content('category','category_title') }}</h1>
                </div>
            </div>

        </div>
        <div class="owl-carousel restaurants">


            @foreach($categories as $key => $row)
            <div class="col-lg-12 p-0">
                <div class="single-restaurants">
                    <a href="{{ route('category',$row->slug) }}">
                        <img class="lazy" src="{{ asset('uploads/lazyload-138x135.png') }}" data-src="{{ asset(imagesize($row->avatar,'medium')) }}" alt="{{ $row->name }}">
                        <h5>{{ $row->name }}</h5>
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
<!-- all restaurants slider area end -->
@endif
<!-- best rated restaurants area start -->



<div class="best-rated-restaturants pt-50" id="best_restaurant">
    <img class="lazy" src="{{ asset('uploads/cooking.png') }}" style="position:absolute; left:20px; opacity: 0.1; " />

    <div class="container">
        <div class="row mb-20">
            <div class="col-lg-12">
                <h1 class="text-center" id="best_restaurant_title" style="margin-bottom:10px !important;">Events we cater</h1>
                <p class="san-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a tincidunt sem. Donec et erat magna. Etiam porta fringilla velit, vitae sodales massa malesuada at. Phasellus luctus sem eu quam mattis tincidunt. Etiam tristique maximus dolor fermentum malesuada.</p>
            </div>
        </div>
        <div class="row" id="best_rated" style="">
            @if(count($stores) > 0)
                @foreach($stores as $row)

                    @if($row->business_disp_name)
                        <div class="col-lg-3 mb-30">
                            <a href="{{ route('store.show',$row->slug) }}">
                                <div class="single-restaturants">
                                    <img class="lazy" src="{{ asset('uploads/lazyload-250x186.png') }}" data-src="{{  asset($row->business_logo_file) }}" alt="{{ $row->first_name }}">

                                    <?php

                                        //print_r($row->can_you_deliver);

                                    ?>
                                    <div class="restaturants-content">
                                        <div class="name-rating">
                                            <h4>{{ Str::limit($row->business_disp_name,15) }}</h4>
                                            <span class="ratings-component">
                                                <span class="stars">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11">
                                                        <path fill="{{ $theme_color }}" d="M9 7.02L9.7 11 6 9.12 2.3 11 3 7.02 0 4.2l4.14-.58L6 0l1.86 3.62L12 4.2z"></path>
                                                    </svg>
                                                </span>
                                            </span>
                                            <!-- <span class="rating"><b>{{ $row->avg_ratting }}</b>/ -->
                                            <!-- 5</span><span class="count">({{ $row->rattings ?? 0 }})</span> -->
                                        </div>
                                        @if($row->can_you_deliver == "Collection only")
                                        <p>{{$row->can_you_deliver}}</p>
                                        @else
                                         <p>Delivery only</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
               @endforeach
           @endif
        </div>
    </div>
</div>


@if(count($locations) > 0)

<div class="best-rated-restaturants whowe pt-50" id="howitworks">
   <div class="container">
      <div class="row mb-20">
         <div class="col-lg-12">
            <h1 class="text-center" id="best_restaurant_title" style="margin-bottom:10px !important;">How It Works</h1>
            <p class="san-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam a tincidunt sem. Donec et erat magna. Etiam porta fringilla velit, vitae sodales massa malesuada at. Phasellus luctus sem eu quam mattis tincidunt. Etiam tristique maximus dolor fermentum malesuada.</p>
         </div>
      </div>
      <div class="row" id="best_rated">
         <div class="col-lg-3 mb-30" style="background-color: #fff6f6;box-shadow: 0px 0px 10px 3px #fff6f6;">
            <img src="{{ asset('uploads/01.png') }}">
            <h3 class="whwetit"><span>1</span></h3>
            <h3 class="whwetit">Choose caterer</h3>
            <p class="whwedisc">Search and Choose your caterers </p>
         </div>
         <div class="col-lg-3 mb-30" style="background-color: #fff6f6;box-shadow: 0px 0px 10px 3px #fff6f6;">
            <img src="{{ asset('uploads/02.png') }}">
            <h3 class="whwetit"><span>2</span></h3>
            <h3 class="whwetit">Select Items</h3>
            <p class="whwedisc">Select list of menus from the caterers</p>
         </div>
         <div class="col-lg-3 mb-30" style="background-color: #fff6f6;box-shadow: 0px 0px 10px 3px #fff6f6;">
            <img src="{{ asset('uploads/03.png') }}">
            <h3 class="whwetit"><span>3</span></h3>
            <h3 class="whwetit">Make Payment</h3>
            <p class="whwedisc">Complete the caterer handling Fees</p>
         </div>
         <div class="col-lg-3 mb-30" style="background-color: #fff6f6;box-shadow: 0px 0px 10px 3px #fff6f6;">
            <img src="{{ asset('uploads/04.png') }}">
            <h3 class="whwetit"><span>4</span></h3>
            <h3 class="whwetit">Contact Caterer</h3>
            <p class="whwedisc">We will connect the caterers </p>
         </div>
      </div>
   </div>
</div>
<div class="best-rated-restaturants partner pt-50" id="partner">
   <img class="lazy" src="{{ asset('uploads/handshake.png') }}" style="position:absolute; right:20%; opacity:0.4;  " />
   <div class="container">
      <div class="row mb-20">
         <div class="col-lg-12">
         </div>
      </div>
      <div class="row" id="best_rated">
         <div class="col-lg-6 mb-30">
            <img src="{{ asset('uploads/join-with-us.png') }}" >
         </div>
         <div class="col-lg-6 mb-30  " style="margin-top:60px;">
            <p class="whoweband">Bring out the best in you</p>
            <h2 class="whowehead">Partner With Us</h2>
            <p class="whowedesc"> We welcome all the <span style="color:#ef7a70;">home cooks</span> and
               the passionate caterers to join us!
            </p>
            <a class="btn btn-primary home-joinus" href="{{ route('signup') }}" role="button">Join Us</a>
         </div>
      </div>
   </div>
</div>


<div class="best-rated-restaturants testi pt-50" id="testi">
   <div class="container">
      <div class="row mb-20">
         <div class="col-lg-12">
         </div>
      </div>
      <div class="row" id="best_rated">
         <div class="col-lg-8 mb-30  " style="margin-top:30px;">
            <p class="whoweband">Testimonials</p>
            <h2 class="whowehead">What Our <span>Customers</span> Say</h2>
            <div class="col-lg-12  pt-5 pb-5 bg-light text-dark" style="margin-top:30px;">
               <div id="client-testimonial-carousel" class="carousel slide" data-ride="carousel" style="height:200px;">
                  <div class="carousel-inner" role="listbox">
                     <div class="carousel-item active text-center p-4">
                        <blockquote class="blockquote text-center">
                           <p class="mb-4"><i class="fa fa-quote-left"></i> Everybody is a genius. But if you judge a fish by its ability to climb a tree, it will live its whole life believing that it is stupid.
                           </p>
                           <footer class="blockquote-footer">Albert Einstein <cite title="Source Title">genius</cite></footer>
                           <!-- Client review stars -->
                           <!-- "fas fa-star" for a full star, "far fa-star" for an empty star, "far fa-star-half-alt" for a half star. -->
                           <p class="client-review-stars">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star-half-alt"></i>
                              <i class="far fa-star"></i>
                           </p>
                        </blockquote>
                     </div>
                     <div class="carousel-item text-center p-4">
                        <blockquote class="blockquote text-center">
                           <p class="mb-4"><i class="fa fa-quote-left"></i> Imagination is more important than knowledge. Knowledge is limited. Imagination encircles the world.
                           </p>
                           <footer class="blockquote-footer">Albert Einstein <cite title="Source Title">genius</cite></footer>
                           <!-- Client review stars -->
                           <!-- "fas fa-star" for a full star, "far fa-star" for an empty star, "far fa-star-half-alt" for a half star. -->
                           <p class="client-review-stars">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                           </p>
                        </blockquote>
                     </div>
                     <div class="carousel-item text-center p-4">
                        <blockquote class="blockquote text-center">
                           <p class="mb-4"><i class="fa fa-quote-left"></i> A person who never made a mistake never tried anything new.
                           </p>
                           <footer class="blockquote-footer">Albert Einstein <cite title="Source Title">genius</cite></footer>
                           <!-- Client review stars -->
                           <!-- "fas fa-star" for a full star, "far fa-star" for an empty star, "far fa-star-half-alt" for a half star. -->
                           <p class="client-review-stars">
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                              <i class="fas fa-star"></i>
                           </p>
                        </blockquote>
                     </div>
                  </div>
                  <ol class="carousel-indicators">
                     <li data-target="#client-testimonial-carousel" data-slide-to="0" class="active"></li>
                     <li data-target="#client-testimonial-carousel" data-slide-to="1"></li>
                     <li data-target="#client-testimonial-carousel" data-slide-to="2"></li>
                  </ol>
               </div>
            </div>
         </div>
         <div class="col-lg-4 mb-30">
            <img src="{{ asset('uploads/chef01.png') }}">
         </div>
      </div>
   </div>
</div>




<div class="best-rated-restaturants partner pt-50" id="order">
    <div class="container">
        <div class="row mb-20">
            <div class="col-lg-12 text-center">
                <img src="{{ asset('uploads/fav-food.png') }}" class="img-fluid">

            </div>
        </div>

    </div>
</div>

<!-- all place area start -->
<div class="all-place-area pt-70" id="city_area">
    <div class="container">
        <div class="row pb-30">
            <div class="col-lg-12">
                <h3 id="find_city_title">{{ content('city_area','find_city_title') }}</h3>
            </div>
        </div>
        <div class="row">
            @foreach($locations as $key=> $row)
             <div class="col-lg-3 mb-30">
                <div class="single-place">
                    <a href="{{ route('area',$row['slug']) }}">
                        <img class="lazy" src="{{ asset('uploads/lazyload-250x186.png') }}" data-src="{{ asset($row['preview']) }}" alt="{{ $row['title'] }}">
                        <div class="single-place-content">
                            <h1>{{ Str::limit($row['title'],1,' ') }}</h1>
                            <div class="name_city_content d-flex">
                                 <h4>{{ $row['title'] }}</h4>
                                <a class="ml-auto" href="{{ route('area',$row['slug']) }}"><svg class="svg-stroke-container"
                                        xmlns="http://www.w3.org/2000/svg" width="20" height="18"
                                        viewBox="0 0 20 18">
                                        <g fill="none" fill-rule="evenodd" stroke="#FFFFFF" stroke-width="2"
                                            transform="translate(1 1)" stroke-linecap="round">
                                            <path d="M0,8 L17.5,8"></path>
                                            <polyline points="4.338 13.628 15.628 13.628 15.628 2.338"
                                                stroke-linejoin="round" transform="rotate(-45 9.983 7.983)">
                                            </polyline>
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<div class="best-rated-restaturants blog pt-50" id="blog">
   <div class="container">
      <div class="row mb-20">
         <div class="col-lg-12">
            <h1 class="text-center" id="best_restaurant_title">Latest <span>Articles</span></h1>
         </div>
      </div>
      <div class="row" id="best_rated">
         <div class="col-lg-4 mb-30 text-center">
            <img src="{{ asset('uploads/b01.jpg') }}">
            <h3 class="whwetit">Choose caterer</h3>
            <p class="whwedisc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
            <a class="btn btn-primary " href="#" role="button">Read More</a>
         </div>
         <div class="col-lg-4 mb-30 text-center">
            <img src="{{ asset('uploads/b02.jpg') }}">
            <h3 class="whwetit">Select Items</h3>
            <p class="whwedisc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <a class="btn btn-primary" href="#" role="button">Read More</a>
         </div>
         <div class="col-lg-4 mb-30 text-center">
            <img src="{{ asset('uploads/b03.jpg') }}">
            <h3 class="whwetit">Make Payment</h3>
            <p class="whwedisc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <a class="btn btn-primary" href="#" role="button">Read More</a>
         </div>
      </div>
   </div>
</div>

<!-- all place area end -->
@endif


@endsection

@push('js')
<script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key={{ env('PLACE_KEY') }}"></script>
<script src="{{ theme_asset('khana/public/js/store/home.js') }}"></script>
<script src="{{ theme_asset('khana/public/js/jquery.unveil.js') }}"></script>

@endpush
