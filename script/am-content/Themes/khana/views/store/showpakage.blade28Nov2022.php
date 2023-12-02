@extends('theme::layouts.app')

@push('css')
<!-- <link rel="stylesheet" href="{{ theme_asset('khana/public/css/bootstrap-datetimepicker.min.css') }}"> -->
<style>
	.owl-nav {
		display: none;
	}
	.single-menu{
		min-height: 100px;
		background-color: #EE5E53;
		color: #fff;
		border-radius: 15px;
		display: flex;
	    justify-content: center;
	    align-items: center;
	}
	.single-menu h4{
		color: #fff;
	}
	.online-food .single-category-food {
	    box-shadow: none;
	}
	.single-caters .store-info {
	        position: inherit;
	}
	.store-area.store_fixed {
	    padding-top: 100px;
	    overflow: hidden;
	}
	.cater-name-cont{
		position: absolute;
		margin-left: auto;
		margin-right: auto;
		left: 0;
		right: 0;
		text-align: center;
		top: 45%;
	}
	.cater-name-cont h2{
		color: #fff;
	}
	.single-cater-logo{
		width: 275px;
    	height: 275px;
    	position: absolute;
    	top: 50%;
	}

	.single-caters p{
		font-size: 16px;
	}
	.single-cater-info{

	}
	.certificates-btn{
	text-transform: CAPITALIZE;
    font-size: 17px;
    border-radius: 10px !important;
	}
	.breadcrumb-item a{
	    color: var(--theme-color);
	}
	#menuslist{
		padding: 30px;
    	background-color: #f9f9f9;
	}
	.main-course-cont{
		background-color: #fff;
    	padding: 15px;
	}

	.package-info-cont{
		border-bottom: 1px solid #b1b1b1;
	}
	.cart-list-items{
		background-color: #fff;
    	min-height: 100px;
    	padding: 20px;
    }
    .cart-list-item-cont{
    	background-color: #f9f9f9;
    	padding: 30px 20px;

    }
    .cart-list-items .titlecont{
    	border-bottom: 1px solid #b1b1b1;
    }
    .pick-info{
    	font-size: 16px;
    }

    .main-course-cont label {
    	font-size: 16px;
	}
	@media(max-width:767px){
		.single-cater-info .business_desc{
			text-align: center;
		}
		.store-banner-img .single-cater-banner {
		    height: 250px;
		}
		.single-cater-logo{
			width: 150px;
	    	height: 150px;
	    	    position: absolute;
	    	top: 40%;
		}
		.single-cater-breadcrumb {
		      margin-left: 40%;
		}
		#aboutfood .single-category-food {
		    padding-left: 20px;
		    padding-right: 20px;
		}
		#aboutfood  .single-category-main-content{
			padding-top: 0px;
		}
	}

</style>
@endpush

@section('content')
@php
$currency=\App\Options::where('key','currency_name')->select('value')->first();
@endphp

<!-- success-alert start -->
<div class="alert-message-area">
	<div class="alert-content">
		<h4 class="ale">{{ __('Your Settings Successfully Updated') }}</h4>
	</div>
</div>
<!-- success-alert end -->

<!-- error-alert start -->
<div class="error-message-area">
	<div class="error-content">
		<h4 class="error-msg"></h4>
	</div>
</div>
<!-- error-alert end -->

<!-- modal area start -->
<section>
	<div class="modal-area d-none">
		<div class="modal-main-content">

		</div>
	</div>
</section>
<!-- modal area end -->
<input type="hidden" id="gallery_url" value="{{ route('store.gallery') }}">
<!-- <section> -->
	<div class="store-area store_fixed single-caters">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 p-0">
					<div class="store-left-section">
						<div class="store-banner-img">
							<img class="single-cater-banner" src="{{ asset('uploads/order1.jpg') }}" alt="">
							<div class="cater-name-cont">
								<h2>{{ $store->business_disp_name }}</h2>

							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 p-0 mt-30">
					<div class="container ">
						<div class="row">
							<div class="col-lg-3 col-12 p-0">
								<img src="{{ asset($store->business_logo_file) }}" class="img-fluid single-cater-logo rounded-circle" alt="">
							</div>
							<div class="col-lg-9 col-12 p-0 single-cater-breadcrumb">
								<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
								  <ol class="breadcrumb">
								    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
								    <li class="breadcrumb-item active" aria-current="page">{{ $store->business_disp_name }}</li>
								  </ol>
								</nav>

							</div>
						</div>
					</div>
					<div class="container single-cater-info mt-20">
						<div class="row">
							<div class="col-lg-3 col-12 p-0">

							</div>
							<!-- <div class="col-lg-3 col-12 p-0">
								<img src="{{ asset($store->business_logo_file) }}" class="img-fluid single-cater-logo rounded-circle" alt="">
							</div> -->

							<div class="col-lg-9 p-0 mt-0">
								<div class="store-action {{ $store->status == 'offline' ? 'offline' : '' }}">
									<div class="store-inline-action">
										<nav>
											<ul class="nav nav-tabs">
												<li class="active"><a href="#menuslist" data-toggle="tab" class="active">{{ __('Menus') }}</a></li>
												<li><a href="#rating" data-toggle="tab">{{ __('Reviews') }}</a></li>
												<li><a href="#aboutfood" data-toggle="tab">{{ __('About Food') }}</a></li>
												<!-- <li><a class="restutant_info" onclick="restaurantsinfo('{{ $store->slug }}')" href="#info" data-toggle="tab">{{ __('Restaurant Info') }}</a></li> -->
												<input type="hidden" id="resturantinfo_url" value="{{ route('store.resturantinfo') }}">

											</ul>
										</nav>
									</div>
								</div>

								<div class="mt-40 mb-20">
									<div class="single-menu">
										@if($packages[0]['name'])
											<h4>{{ __($packages[0]['name']) }}</h4>
										@endif
									</div>
								</div>

							</div>



						</div>
					</div>
				</div>
			</div>
			<div class="container ">
				<div class="row">
					<div class="col-lg-9 mt-40">
						<div class="tab-content">
							<input type="hidden" id="add_to_cart_url" value="{{ route('add_to_cart') }}">
							<input type="hidden" id="cart_update" value="{{ route('cart.update') }}">
							<input type="hidden" id="cart_delete" value="{{ route('cart.delete') }}">
							<div class="online-food tab-pane fade in active show" id="menuslist">

									@if($packageItems[0])
										@foreach($packageItems[0]['package_details'] as $customPackage)
											<div class="row mb-20 main-course-cont">
												<div class="col-lg-12 col-12 mb-20">
													<div class="package-info-cont">

														<h4>{{$customPackage["category_name"]}} <span class="pick-info">(Pick any {{$customPackage['no_of_items']}} {{$customPackage['no_of_items']>1?"items":"item"}} from {{count($customPackage['items'])}} items)</span></h4>
													</div>
												</div>
												@foreach($customPackage['items'] as $items)
													<div class="col-lg-3 col-6 mb-20">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" value="{{$items['id']}}" id="items" name="{{$items['package_category_id']}}" data-maxitemselection="{{$customPackage['no_of_items']}}" />
														  	<label class="form-check-label" for="flexCheckDefault">{{$items['name']}}</label>
														</div>
													</div>
												@endforeach
											</div>
										@endforeach
									@endif

							</div>

							<div class="online-food tab-pane fade" id="aboutfood">
								<div class="single-category-food mb-50">
									<div class="single-category-main-content" style="text-align: justify;">
											@if($packages[0]['description'])
												<p style="line-height: 28px;">{{ __($packages[0]['description']) }}</p>
											@endif
									</div>
								</div>
							</div>


							<div class="online-food tab-pane fade" id="rating">
								<div class="single-category-food mb-50">
									<div class="single-category-main-content">
										<div class="row">
											<div class="col-lg-6">
												<h3>{{ __('Reviews') }}</h3>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="room-review pt-30">
													<div class="review-rate">
														<div class="row">
															<div class="col-lg-4">
																<div class="room-review-count text-center">
																	<p>
																		{{-- {{ number_format($store->avg_ratting->content,1) }} --}}

																	</p>
																</div>
															</div>
															<div class="col-lg-8">
																<div class="review-bar">
																	<div class="single-progress-bar">
																		<div class="progressbar-label">
																			<h5>{{ __('5 Star') }} <span class="f-right">{{ $five_rattings }}%</span></h5>
																			<div class="progress">
																				<div class="progress-bar w-{{ $five_rattings }}" role="progressbar" aria-valuenow="{{ $five_rattings }}" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																	<div class="single-progress-bar">
																		<div class="progressbar-label">
																			<h5>{{ __('4 Star') }} <span class="f-right">{{ $four_rattings }}%</span></h5>
																			<div class="progress">
																				<div class="progress-bar w-{{ $four_rattings }}" role="progressbar" aria-valuenow="{{ $four_rattings }}" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																	<div class="single-progress-bar">
																		<div class="progressbar-label">
																			<h5>{{ __('3 Star') }} <span class="f-right">{{ $three_rattings }}%</span></h5>
																			<div class="progress">
																				<div class="progress-bar w-{{ $three_rattings }}" role="progressbar" aria-valuenow="{{ $three_rattings }}" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																	<div class="single-progress-bar">
																		<div class="progressbar-label">
																			<h5>{{ __('2 Star') }}<span class="f-right">{{ $two_rattings }}%</span></h5>
																			<div class="progress">
																				<div class="progress-bar w-{{ $two_rattings }}" role="progressbar" aria-valuenow="{{ $two_rattings }}" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																	<div class="single-progress-bar">
																		<div class="progressbar-label">
																			<h5>{{ __('1 Star') }} <span class="f-right">{{ $one_rattings }}%</span></h5>
																			<div class="progress">
																				<div class="progress-bar w-{{ $one_rattings }}" role="progressbar" aria-valuenow="{{ $one_rattings }}" aria-valuemin="0" aria-valuemax="100"></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="review-all pt-30 pb-30">
														<div class="review-title pb-30">
															<h4>{{ __('All Reviews') }}</h4>
														</div>
														<div class="review-list">
															@foreach($store->vendor_reviews as $review)
															<div class="media">
																<img src="{{ asset(App\User::find($review->user_id)->avatar) }}" class="mr-3" alt="...">
																<div class="media-body">
																	<h5 class="mt-0 mb-10">{{ App\User::find($review->user_id)->name }} <span class="comment-date"> {{ $review->created_at->diffForHumans() }}</span>
																	</h5>
																	<div class="review-ratting">
																		@if($review->comment_meta->star_rate == 5)
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		@endif
																		@if($review->comment_meta->star_rate == 4)
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="far fa-star"></i>
																		@endif
																		@if($review->comment_meta->star_rate == 3)
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="far fa-star"></i>
																		<i class="far fa-star"></i>
																		@endif
																		@if($review->comment_meta->star_rate == 2)
																		<i class="fas fa-star"></i>
																		<i class="fas fa-star"></i>
																		<i class="far fa-star"></i>
																		<i class="far fa-star"></i>
																		<i class="far fa-star"></i>
																		@endif
																		@if($review->comment_meta->star_rate == 1)
																		<i class="fas fa-star"></i>
																		<i class="far fa-star"></i>
																		<i class="far fa-star"></i>
																		<i class="far fa-star"></i>
																		<i class="far fa-star"></i>
																		@endif
																	</div>
																	{{ $review->comment_meta->comment }}
																</div>
															</div>
															@endforeach
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 mt-40 cart-list-item-cont">
						<div class="cart-list-items">
							<div class="titlecont">
								<!-- <h4><i class="fa fa-shopping-cart"></i> Your Order</h4> -->
								<input type="button" class="btn btn-primary" id="add_cart_btn" name="add_cart_btn" value="Continue to payment" disabled>
								<table class="table d-none" id="amount_div">
									<tr>
										<td>Net Amount</td>
										<td>£ 4500</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>


				<!-- <div class="col-lg-3 p-0">
					<div class="store-right-section fixed">
						<div class="main_cart">
							<div class="delivery-main-content text-center">
								<form action="{{ route('checkout.index') }}" class="cartform">

								@if(Cart::instance('cart_'.$store->slug)->count() > 0)
								<div class="delivery-toogle-action">
									<span class="delivery-title">{{ __('Delivery') }}</span>
									<div class="custom-control custom-switch">
										<input type="checkbox" name="delivery_type" value="0" class="custom-control-input" id="uinque_id"> <label class="custom-control-label" for="uinque_id">{{ __('Pick Up') }}</label>
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
											<span>{{ __(strtoupper($currency->value)) }} {{ Cart::subtotal() }}</span>
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
							</form>
							</div>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	<!-- </div> -->
<!-- </section> -->
<!-- store area end -->

@if($store->status == 'offline')
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body offline">
        <div class="close-resturants">
        	<div class="row">
        		<div class="col-lg-11">
        			<h3>{{ $store->name }} {{ __('is now closed') }}</h3>
        		</div>
        		<div class="col-lg-1">
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true" class="ti-close"></span>
			        </button>
			    </div>
        	</div>

        	<p>{{ __('The restaurant is closed right now. Check out others that are open or take a look at the menu to plan for your next meal.') }}</p>
        	<a href="{{ url('/') }}">{{ __('go to homepage') }}</a>
        	<a class="tranparent" href="#" data-dismiss="modal" aria-label="Close">{{ __('Close') }}</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<input type="hidden" id="store_url" value="{{ route('store_data',$store->slug) }}">
<input type="hidden" id="addon_url" value="{{ route('addon_product') }}">
@endsection

@push('js')
<!--
<script src="{{ theme_asset('khana/public/js/bootstrap-datetimepicker.min.js') }}"></script>
-->
<script>
	"use strict";
    $(function () {
        $('input[type="checkbox"]').change(function() {
			var checkbox_group_name = $(this).attr("name");
			var total = $(this).find('input[name="'+checkbox_group_name+'"]:checked').length;
			var selected_count = 0;
			$("input[name='"+checkbox_group_name+"']:checked").each( function () {
				selected_count++;
			});
			var maxitemselection = $(this).attr("data-maxitemselection");
			$("input[name='"+checkbox_group_name+"']:not(:checked)").prop("disabled", false);
			if(parseInt(selected_count) >= parseInt(maxitemselection)){
				$("input[name='"+checkbox_group_name+"']:not(:checked)").prop("disabled", true);
			}

			var enable_submit_btn_flag = false;
			var category_ids = [];
			var category_selected_items_count = [];
			var matched_selection_arr = [];
			$('input[type="checkbox"]').each(function (index, obj) {
				var all_checkbox_group_name = obj.name;
				var all_category_total = $('input[name="'+all_checkbox_group_name+'"]:checked').length;
				var selected_count = 0;
				var categorymaxitemselection = $("input[name='"+all_checkbox_group_name+"'").attr("data-maxitemselection");
				if(jQuery.inArray(all_checkbox_group_name, category_ids) == -1){
					category_ids.push(obj.name);
					category_selected_items_count.push(all_category_total);
					if(parseInt(all_category_total) >= parseInt(categorymaxitemselection)){
						matched_selection_arr.push(obj.name);
					}
				}
			});
			if(category_ids.length == matched_selection_arr.length){
				$('#amount_div').removeClass('d-none');
				$('#add_cart_btn').attr('disabled',false);
			}else{
				$('#amount_div').addClass('d-none');
				$('#add_cart_btn').attr('disabled',true);
			}
		});
    })
</script>
@endpush
