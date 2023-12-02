<header id="header">
    <div class="header-area {{ Request::is('store/*') ? 'header_fixed' : '' }}">
        <input type="hidden" id="header_close" value="{{ route('header.notify') }}">
        <div class="header-main-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="header-logo">
                            <a href="{{ url('/') }}" class="pjax"><img id="logo" src="{{ asset('uploads/final-1-Feb2022-PNG.png') }}" alt="{{ env('APP_NAME') }}"></a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="header-main-right-area">

                            <div class="main-menu f-right pt-2">
                                <div class="mobile-menu">
                                    <a class="toggle f-right" href="#" role="button" aria-controls="hc-nav-1"><i class="ti-menu"></i></a>
                                </div>
                                <nav id="main-nav">
                                    <ul>
                                        <li></li>
                                        {{ Menu('Header','submenu','','','right',true) }}

                                        @if(!Auth::check())
                                            <li class="d-block d-lg-none mt-1">
                                                <a href="#" target="_self">Login</a> <i class=""></i>
                                                <ul class="submenu">
                                                    <li class="" style="text-align: left;">
                                                        <a href="{{ route('user.login') }}" target="_self">Customer Login</a> <i class="empty"></i> 
                                                    </li>
                                                    <li class="" style="text-align: left;">
                                                        <a href="{{ route('login') }}" target="_self">Partner Login</a> <i class="empty"></i> 
                                                    </li>
                                                    <li class="" style="text-align: left;">
                                                        <a href="{{ route('signup') }}" target="_self">Partner Sign-up</a> <i class="empty"></i> 
                                                    </li>

                                                </ul>
                                            </li>

                                             <!-- <li class="d-block d-lg-none mt-1">
                                                <a href="{{ route('signup') }}" target="_self">Partner Sign-up</a> <i class=""></i>
                                            </li> -->
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    @if(Auth::check())
                    <div class="col-lg-4 ">
                        <div class="header-main-right-area" style='margin-top: 20px;'>
                            <div class="menu_profile">
                                <a href="#" class="f-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #2a2b44;">
                                    <!-- <img class="profile_img" src="{{ asset(Auth::User()->avatar) }}"> -->
                                {{ Auth::User()->first_name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('author.dashboard') }}" class="dropdown-item">{{ __('Dashboard') }}</a>
                                    <a href="{{ route('author.dashboard') }}" class="dropdown-item">{{ __('My Orders') }}</a>
                                    <a href="{{ route('author.dashboard') }}" class="dropdown-item">{{ __('Settings') }}</a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" class="dropdown-item">{{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                            <li class="mt-2 {{ !session::has('restaurant_cart') ? 'mr-0' : '' }}">
                                @if(Session::has('restaurant_cart'))
                                <a href="{{ route('cart.cartlist') }}" class="desktop_cart_icon">
                                    <div class="shopping-cart f-right">
                                    <span class="ti-shopping-cart"></span>
                                    @if(Session::has('restaurant_cart'))
                                    @if(Request::is('store/'.Session::get('restaurant_cart')['slug']) || Request::is('/') || Request::is('area*') || Request::is('checkout'))
                                    <div class="count_load">{{$cart_count = Cart::instance('multi_cart')->count()}}</div>
                                    @else
                                    <div class="count_load">{{$cart_count = Cart::instance('multi_cart')->count()}}</div>
                                    @endif
                                    @else
                                    <div class="count_load">{{$cart_count = Cart::instance('multi_cart')->count()}}</div>
                                    @endif
                                    </div>
                                </a>
                                <a id="toggle-sidebar-left" class="mobile_cart_icon" href="{{ route('cart.cartlist') }}">
                                    <div class="shopping-cart f-right">
                                    <span class="ti-shopping-cart"></span>
                                    @if(Session::has('restaurant_cart'))
                                    @if(Request::is('store/'.Session::get('restaurant_cart')['slug']) || Request::is('/') || Request::is('area*') || Request::is('checkout'))
                                    <div class="count_load">{{$cart_count = Cart::instance('multi_cart')->count()}}</div>
                                    @else
                                    <div class="count_load">{{$cart_count = Cart::instance('multi_cart')->count()}}</div>
                                    @endif
                                    @else
                                    <div class="count_load">{{$cart_count = Cart::instance('multi_cart')->count()}}</div>
                                    @endif
                                    </div>
                                </a>
                                @else
                                <a href="javascript:void(0)" id="toggle-sidebar-left">
                                    <div class="shopping-cart f-right">
                                    <span class="ti-shopping-cart"></span>
                                    <div class="count_load"></div>
                                    </div>
                                </a>
                                @endif
                            </li>

                        </div>
                    </div>
                    @else

                    <div class="col-lg-4 ">
                        <div class="header-main-right-area">
                            <div class="main-menu f-lelt1 " style="text-align: center;">
                                <nav class="hc-nav-original hc-nav-1">
                                    <ul class="d-flex1" style="display: inline-flex;">

                                        <li class="mt-2 {{ !session::has('restaurant_cart') ? 'mr-0' : '' }}">
                                            <?php
                                            $cart_details = Cart::instance('multi_cart')->content();

                                            ?>
                                        @if(Session::has('restaurant_cart'))
                                        <a href="{{ route('cart.cartlist') }}" class="desktop_cart_icon">
                                            <div class="shopping-cart f-right">
                                            <span class="ti-shopping-cart"></span>
                                            @if(Session::has('restaurant_cart'))
                                            <div class="count_load">{{count($cart_details)}}</div>
                                            @endif
                                            </div>
                                        </a>
                                        <a href="{{ route('cart.cartlist') }}" class="mobile_cart_icon" id="toggle-sidebar-left">
                                            <div class="shopping-cart f-right">
                                            <span class="ti-shopping-cart"></span>
                                            @if(Session::has('restaurant_cart'))
                                            <div class="count_load">{{count($cart_details)}}</div>
                                            @endif
                                            </div>
                                        </a>
                                        @else
                                        <a href="javascript:void(0)" id="toggle-sidebar-left">
                                            <div class="shopping-cart f-right">
                                            <span class="ti-shopping-cart"></span>
                                            <div class="count_load">{{count($cart_details)}}</div>
                                            </div>
                                        </a>
                                        @endif
                                    </li>

                                        <li class="mt-2">
                                            <a href="#" target="_self">Login</a> <i class=""></i>
                                            <ul class="submenu">
                                                <li class="" style="text-align: left;">
                                                    <a href="{{ route('user.login') }}" target="_self">Customer Login</a> <i class="empty"></i> 
                                                </li>
                                                <li class="" style="text-align: left;">
                                                    <a href="{{ route('login') }}" target="_self">Partner Login</a> <i class="empty"></i> 
                                                </li>
                                                <li class="" style="text-align: left;">
                                                    <a href="{{ route('signup') }}" target="_self">Partner Sign-up</a> <i class="empty"></i> 
                                                </li>

                                            </ul>
                                        </li>
                                        <!-- <li class="menu-signup">
                                            <a class="btn" href="{{ route('signup') }}">Partner Sign-up </a> <i class=""></i>
                                        </li> -->

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
 @php
 $currency=\App\Options::where('key','currency_name')->select('value')->first();
 @endphp
 <form action="{{ route('checkout.index') }}" class="cartform">
 <div class="sidebar d-none" id="sidebar-left">
  <div class="sidebar-wrapper">
    @if(Session::has('restaurant_cart'))
    @if(Session::has('cart'))
    <div class="main_cart_ok">
        <div class="delivery-main-content sidebar text-center">
            @if(Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->count() > 0)
            @php
            $store = App\User::where('slug',Session::get('restaurant_cart')['slug'])->with('pickup','delivery')->first();
            @endphp
            <div class="delivery-toogle-action">
                <span class="delivery-title">{{ __('Delivery') }}</span>
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="delivery_type" value="0" class="custom-control-input" id="hello_id"> <label class="custom-control-label" for="hello_id">{{ __('Pick Up') }}</label>
                    <input type="hidden" id="checkout_type" value="{{ route('checkout.type') }}">
                </div>
            </div>
            <input type="hidden" id="pickup_price" value="{{ $store->pickup->content }}">
            <input type="hidden" id="delivery_price" value="{{ $store->delivery->content }}">
            <div class="delivery-avg-time" id="dummy">
                <i class="fas fa-truck"></i> {{ $store->delivery->content }} {{ __('min') }}
            </div>
            <div class="delivery-order-form">
                <h5>{{ __('Your order') }} {{ $store->name }}</h5>
            </div>
            <div class="cart-product-list">
                @foreach(Cart::instance('cart_'.$store->slug)->content() as $cart)
                <div class="single-cart-product d-flex">
                    <div class="cart-product-title d-block">
                        <h5>{{ $cart->name }}</h5>
                        <p>{{ $cart->options->type }}</p>
                    </div>
                    <div class="cart-price-action d-block">
                        <span>{{ strtoupper($currency->value) }} {{ number_format($cart->price,2) }}</span>
                        <div class="cart-product-action d-flex">
                            @if($cart->qty > 1)
                            <a href="javascript:void(0)" class="right" onclick="limit_minus('{{ $cart->rowId }}','{{ $store->slug }}')"><span class="ti-minus"></span></a>
                            @else
                            <a href="javascript:void(0)" onclick="delete_cart('{{ $cart->rowId }}','{{ $store->slug }}')" class="right"><span class="fas fa-trash"></span></a>
                            @endif
                            <div class="qty">
                                <input type="text" id="total_limit{{ $cart->rowId }}" value="{{ $cart->qty }}">
                            </div>
                            <a href="javascript:void(0)" class="left" onclick="limit_plus('{{ $cart->rowId }}','{{ $store->slug }}')"><span class="ti-plus"></span></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="cart-product-another-information">
                <div class="single-information d-flex">
                    <span>{{ __('Subtotal') }}</span>
                    <div class="main-amount">
                        <span>{{ strtoupper($currency->value) }} {{ Cart::subtotal() }}</span>
                    </div>
                </div>
                <div>
                    <div class="checkout-btn">
                        <a href="javascript:void(0)" onclick="$('.cartform').submit()">{{ __('Checkout') }}</a>
                    </div>
                </div>
            </div>
            @else
            <h5 class="mt-20 mb-15">{{ __('No Item in your Cart') }}</h5>
            <p class="mb-15">{{ __("You haven't added anything in your cart yet! Start adding the products you like.") }}</p>
            <div class="cart-product-another-information">
                <div class="single-information d-flex">
                    <span>{{ __('Subtotal') }}</span>
                    <div class="main-amount">
                        <span>{{ strtoupper($currency->value) }} {{ Cart::subtotal() }}</span>
                    </div>
                </div>
                <div class="checkout-btn disabled">
                    <a href="#" class="disabled">{{ __('Checkout') }}</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="main_cart_ok">
        <div class="delivery-main-content sidebar text-center">
            <h5 class="mt-20 mb-15">{{ __('No Item in your Cart') }}</h5>
            <p class="mb-15">{{ __("You haven't added anything in your cart yet! Start adding the products you like.") }}</p>
            <div class="cart-product-another-information">
                <div class="single-information d-flex">
                    <span>{{ __('Subtotal') }}</span>
                    <div class="main-amount">
                        <span>{{ strtoupper($currency->value) }} {{ Cart::subtotal() }}</span>
                    </div>
                </div>
                <div class="checkout-btn disabled">
                    <a href="#" class="disabled">{{ __('Checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @else
    <div class="main_cart_ok">
        <div class="delivery-main-content sidebar text-center">
            <h5 class="mt-20 mb-15">{{ __('No Item in your Cart') }}</h5>
            <p class="mb-15">{{ __("You haven't added anything in your cart yet! Start adding the products you like.") }}</p>
            <div class="cart-product-another-information">
                <div class="single-information d-flex">
                    <span>{{ __('Subtotal') }}</span>
                    <div class="main-amount">
                        <span>{{ strtoupper($currency->value) }} {{ Cart::subtotal() }}</span>
                    </div>
                </div>
                <div class="checkout-btn disabled">
                    <a href="#" class="disabled">{{ __('Checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
</div>
</form>
<input type="hidden" id="cart_update" value="{{ route('cart.update') }}">
<input type="hidden" id="cart_delete" value="{{ route('cart.delete') }}">
</header>




