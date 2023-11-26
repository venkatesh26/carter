<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ env('APP_NAME') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/favicon.ico') }}">
  <!-- General CSS Files -->
 <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/fontawesome.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ theme_asset('khana/public/fonts/themify-icons/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ theme_asset('khana/public/css/style.css') }}">
  <!-- <link rel="stylesheet" href="{{ theme_asset('khana/public/css/responsive.css') }}"> -->
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
      h4 {
        font-family: 'Montserrat', sans-serif;
      }
      :root{
            --theme-color: {{ $theme_color }};
        }
      </style>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <h4 class="text-dark font-weight-normal">{{ __('Welcome to') }} <span class="font-weight-bold">{{ env('APP_NAME') }}</span></h4>
             <form method="POST" id="basicform" class="needs-validation" action="{{ route('login') }}">
                @csrf
              <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">{{ __('Password') }}</label>
                </div>
                <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                 @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                 @enderror
              </div>

               <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                  <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>
                </div>
              </div>
              <div class="form-group ">
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                   {{ __('Login') }}
                </button>
              </div>
              <div class="form-group register">
                <a href="{{ route('signup') }}" class="mt-3">
                  {{ __('Create an Account?') }}
                </a>
              </div>
              <div class="form-group text-right">
                 @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="float-left mt-3">
                  {{ __('Forgot Your Password?') }}
                </a>
                @endif

              </div>


            </form>


          </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{ asset('admin/login-bg.jpg') }}">

        </div>
      </div>
    </section>
  </div>

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

  <!-- General JS Scripts -->
  <script src="{{ asset('admin/assets/js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
</body>
</html>
<script>
  /*
  $(document).ready(function(){
    $(".register a").click(function(){
        $("#preRegisterModal").modal("show");
    });
  });
  */

  </script>




