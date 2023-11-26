<?php

namespace Amcoders\Theme\khana\http\controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Cart;
/**
 *
 */
class LoginController extends controller
{
	public function login()
	{
		if (Auth::check()) {

			$cart_count = Cart::instance('multi_cart')->count();
			if($cart_count>0){
				return redirect()->route('checkout.index');
			}else{
				return redirect()->route('login');
			}
		}else{
			return view('theme::login.index');
		}

	}
}
