<!doctype html>
<html class="no-js" lang="{{ App::getlocale() }}">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {!! SEO::generate() !!}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/FaviconFeb2022.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    @if(Session::has('lang_position'))
    @if(Session::get('lang_position') == 'RTL')
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/bootstrap-rtl.css') }}">
    @else
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/bootstrap.min.css') }}">
    @endif
    @else
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/bootstrap.min.css') }}">
    @endif
        <link rel="stylesheet" href="{{ theme_asset('khana/public/css/sancat.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto+Slab:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('khana/public/fonts/themify-icons/themify-icons.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Righteous&display=swap" rel="stylesheet">
    <link href="{{ theme_asset('khana/public/css/hc-offcanvas-nav.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/default.css') }}">

    @php
        $color = App\Options::where('key','color')->first();
        if(isset($color))
        {
            $theme_color = $color->value;
        }else{
            $theme_color = '#ff3252';
        }
    @endphp
    <style>
        :root{
            --theme-color: {{ $theme_color }};
        }

        // Tabs
// -------------------------

// Give the tabs something to sit on
.nav-tabs {
  border-bottom: 1px solid @nav-tabs-border-color;
  > li {
    float: left;
    // Make the list-items overlay the bottom border
    margin-bottom: -1px;

    // Actual tabs (as links)
    > a {
      margin-right: 2px;
      line-height: @line-height-base;
      border: 1px solid transparent;
      border-radius: @border-radius-base @border-radius-base 0 0;
      &:hover {
        border-color: @nav-tabs-link-hover-border-color @nav-tabs-link-hover-border-color @nav-tabs-border-color;
      }
    }

    // Active state, and its :hover to override normal :hover
    &.active > a {
      &,
      &:hover,
      &:focus {
        color: @nav-tabs-active-link-hover-color;
        cursor: default;
        background-color: @nav-tabs-active-link-hover-bg;
        border: 1px solid @nav-tabs-active-link-hover-border-color;
        border-bottom-color: transparent;
      }
    }
  }
  // pulling this in mainly for less shorthand
  &.nav-justified {
    .nav-justified();
    .nav-tabs-justified();
  }
}


    </style>
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/style.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/responsive.css') }}">
    @if(Session::has('lang_position'))
    @if(Session::get('lang_position') == 'RTL')
    <link rel="stylesheet" href="{{ theme_asset('khana/public/css/rtl.css') }}">
    @endif
    @endif
    @stack('css')

</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->


    <!-- header area start -->
    @include('theme::layouts.partials.header')
    <!-- header area end -->

    <!-- <div id="pjax-container"> -->
        @yield('content')
    <!-- </div> -->

    <!-- footer area start -->
    @include('theme::layouts.partials.footer')
    <!-- footer area end -->

    <!-- JS here -->
    <script src="{{ theme_asset('khana/public/js/vendor/jquery-3.5.1.min.js') }}"></script>
    @stack('js')
    <script src="{{ theme_asset('khana/public/js/store/store.js') }}"></script>
    <script src="{{ theme_asset('khana/public/js/store/cart.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ theme_asset('khana/public/js/popper.min.js') }}"></script>
    <script src="{{ theme_asset('khana/public/js/bootstrap.min.js') }}"></script>
    <script src="{{ theme_asset('khana/public/js/owl.carousel.min.js') }}"></script>
    <script src="{{ theme_asset('khana/public/js/hc-offcanvas-nav.js') }}"></script>
    <script src="{{ theme_asset('khana/public/js/simpler-sidebar.js') }}"></script>
    <script src="{{ theme_asset('khana/public/js/main.js') }}"></script>

<script type="text/javascript">

  $(function() {

      $('.home-joinus').on('click', function(e) {
          // e.preventDefault();
          setCookie("plan_id",$(this).data("planid"),10);
      });
  });

  function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

</script>

    <script>
$(document).ready(function(){

  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;

  $(".next").click(function(){

    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
      step: function(now) {
      // for making fielset appear animation
      opacity = 1 - now;

      current_fs.css({
      'display': 'none',
      'position': 'relative'
      });
      next_fs.css({'opacity': opacity});
      },
      duration: 600
    });
  });

  $(".previous").click(function(){

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
      step: function(now) {
      // for making fielset appear animation
      opacity = 1 - now;

      current_fs.css({
      'display': 'none',
      'position': 'relative'
      });
      previous_fs.css({'opacity': opacity});
      },
      duration: 600
      });
  });

  $('.radio-group .radio').click(function(){
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
  });

  $(".submit").click(function(){
    return false;
  });

  /*
  $(".menu-signup, .nav-item-wrapper .btn, .home-joinus").click(function(){
      // $("#preRegisterModal").modal("show");
  });
  */


});
</script>

@if (Route::currentRouteName() == 'restaurant.register' || Route::currentRouteName() == 'restaurant.register_step_3' || Route::currentRouteName() == 'baker.register' || Route::currentRouteName() == 'baker.register_step_2' || Route::currentRouteName() == 'baker.register_step_3')
<script src="{{ theme_asset('khana/public/js/jquery.validate.min.js') }}"></script>
<script src="{{ theme_asset('khana/public/js/additional-methods.min.js') }}"></script>
@endif
@if (Route::currentRouteName() == 'restaurant.register'  || Route::currentRouteName() == 'restaurant.register_step_3')
<script src="{{ theme_asset('khana/public/js/restaurant-registration.js') }}"></script>
@endif
@if (Route::currentRouteName() == 'baker.register' || Route::currentRouteName() == 'baker.register_step_2' || Route::currentRouteName() == 'baker.register_step_3')
<script src="{{ theme_asset('khana/public/js/baker-registration.js') }}"></script>
@endif
</body>

</html>
