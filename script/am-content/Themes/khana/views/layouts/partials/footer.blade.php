{{-- @if(!Request::is('store/*')) --}}

<style type="text/css">

  @media(max-width:767px){

    .best-rated-restaturants.partner>img {
      display: none
    }
     .best-rated-restaturants.partner #best_rated img{
        width: 100%;
     }
  }

  .bootomcurve {
      position: relative;
      width: 100%;
      height: 18vh;
      display: flex;
      justify-content: center;
      align-items:center;
      overflow: hidden;
          background-color: #261f00;
    }

    .bootomcurve:after {
      content: '';
      position: absolute;
      top:0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(145deg, #fff, #fff);
      border-radius: 0 0 50% 50%/ 0 0 100% 100%;
      transform: scaleX(1);
    }
     div#blog {
      background-color: #fff !important;
  }
</style>

<div class="bootomcurve">

</div>
<!-- <div class="footer-curve__wrapper">
  <svg class="footer-curve__image" id="Ebene_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1600 100"> <defs> <path id="SVGID_1_" d="M0 101.3l1600-1.3V0H0z"></path> </defs> <clipPath id="SVGID_2_"> <use xlink:href="#SVGID_1_" overflow="visible"></use> </clipPath> <path d="M0 53.6V100h1600V0h-2.9c-237.2 59.2-570.9 96-940.6 96C417.1 96 192.8 80.6 0 53.6" clip-path="url(#SVGID_2_)" fill="#251e01"></path> </svg>
</div> -->

<footer id="footer">



    <div class="footer-area pt-70" >

        <div class="santopfooter justify-content-center overflow-hidden" style="padding-bottom:50px;">
            <div class="container">
                 <div class="col-md-3">
                 <img src="{{ asset('uploads/footer-logo.png') }}" style="margin-bottom:15px;">
                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>

                <ul class="social-icons">
 	<li><a href="#"><i class="fab fa-facebook-f"></i> </a></li>
 	<li><a href="#"><i class="fab fa-twitter"></i> </a></li>
 	<li><a href="#"><i class="fab fa-instagram"></i> </a></li>
 	<li><a href="#"><i class="fab fa-youtube"></i></a></li>
 	<li><a href="#"><i class="fab fa-linkedin"></i> </a></li>
</ul>

                 </div>
            <div class="col-md-3">
           <h3>About</h3>
           <ul>
               <li><a href="#">About us</a></li>
               <li><a href="#">About us</a></li>
               <li><a href="#">About us</a></li>
           </ul>
            </div>
            <div class="col-md-3">
            <h3>Company</h3>
            <ul>
               <li><a href="#">Partner With Us</a></li>
               <li><a href="#">Supplier FAQs</a></li>
               <li><a href="#">Customer FAQs</a></li>
           </ul>
            </div>
            <div class="col-md-3">
             <h3>Support</h3>
               <ul>
               <li><a href="#">My Account</a></li>
               <li><a href="#">Support Center</a></li>
               <li><a href="#">Contact Us</a></li>
           </ul>
              </div>
            </div>
        </div>


        <div class="footer-main-content text-center">




            <div class="footer-menu">
                <nav>
                    <ul>
                        <li>
                            <a href="{{ url('/') }}">{{ __('Home') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/#') }}">{{ __('Contact') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/#') }}">{{ __('Privacy Policy') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/#') }}">{{ __('Terms & Conditions') }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/#') }}">{{ __('Refund & Return Policy') }}</a>
                        </li>
                    </ul>
                </nav>


               <!--  <nav>
                    <ul>
                        <li>
                            <h4><a href="{{ url('/') }}">{{ __('Home') }}</a></h4>
                        </li>
                        <li>
                            <h4><a href="{{ url('/contact') }}">{{ __('Contact') }}</a></h4>
                        </li>
                        <li>
                            <h4><a href="{{ url('/page/privacy-policy') }}">{{ __('Privacy Policy') }}</a></h4>
                        </li>
                        <li>
                            <h4><a href="{{ url('/page/terms-and-conditions') }}">{{ __('Terms & Conditions') }}</a></h4>
                        </li>
                        <li>
                            <h4><a href="{{ url('/page/refund-return-policy') }}">{{ __('Refund & Return Policy') }}</a></h4>
                        </li>
                    </ul>
                </nav>  -->


            </div>
            <div class="footer-copyright">
               <!-- <p id="copyright_area">{{ content('footer','copyright_area') }}</p> -->
                 <p id="copyright_area">© Copyright 2022 Cater An Event. All rights reserved</p>
            </div>
        </div>
    </div>
</footer>

<div class="modal fade" id="preRegisterModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="preRegisterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body offline">
        <div class="close-resturants">
        	<div class="row">
        		<div class="col-lg-11">
                    <p>Do you want to...</p>
        		</div>
        		<div class="col-lg-1">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true" class="ti-close"></span>
			        </button>
			    </div>
        	</div>

        	<!---<p>Do you want to...</p>-->
        	<a href="{{ route('restaurant.register') }}">Register as Cater</a>
            <a href="{{ route('baker.register') }}">Register as Baker</a>
        	<!--<a href="#" data-dismiss="modal" aria-label="Close">{{ __('Close') }}</a>-->
        </div>
      </div>
    </div>
  </div>
</div>



{{-- @endif --}}
