<?php

namespace Amcoders\Theme\khana\http\controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Category;
use App\Terms;
use Auth;
use Session;
use Cart;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use App\Options;
use App\Package;
use App\PackageItem;
use App\AddonItems;

class StoreController extends controller
{
	protected $vendor_id;

	public function show($slug, Request $request)
	{

		$queryParams = $request->query();
		if(!$queryParams){
			// Delete Old Cart
			$cart = Cart::instance('multi_cart')->content();
	        $cart_items = json_decode($cart, true);
	        // echo "<pre>";
	        // print_r($cart_items);
	        if (isset($cart_items) && count($cart_items) > 0) {
	            foreach ($cart_items as $rowId => $items_row) {
	                Cart::instance('multi_cart')->remove($rowId);
	            }
	        }
    	}


		$store=User::with('info','gallery','preview','avg_ratting','delivery','pickup','shopcategory','location','shopday','role','vendor_reviews','ratting','badge','usersaas')->where('slug',$slug)->first();
		if (empty($store)) {
			abort(404);
		}

		$auth_id=Auth::id();
        $category = new Category();
        $package = new Package();
        $packageItem = new PackageItem();

        $user_id = $store->id;

        //$categories = $category->select('id', 'name')->where('user_id',$auth_id)->get()->toArray();
        // 'category_id',"no_of_items"
        $packages = $package->select('id', 'name', 'description', 'price', 'halal_status','slug')->where('user_id',$user_id)->get()->toArray();
        $packageItemsLIst = [];
		$packageItems = array();
        if (count($packages) > 0) {
			foreach($packages as $package_row){
				$temp = array();
				$temp = $package_row;
				$package_id = $package_row['id'];
				$packageItemsLIst = $packageItem->select('package_items.id', 'package_items.package_id', 'package_items.name', 'package_items.description', 'package_items.spicy','package_items.mild','package_items.hot','package_items.extra_hot','package_items.none','package_items.package_category_id','categories.name as category_name','package_categories.category_id','packages.name as package_name','packages.slug')
				->leftJoin('package_categories', 'package_categories.id', '=', 'package_items.package_category_id')
				->leftJoin('categories', 'categories.id', '=', 'package_categories.category_id')
				->leftJoin('packages', 'packages.id', '=', 'package_items.package_id')
				->where('package_items.package_id', $package_id)
				->where('package_items.deleted', 0)
				->where('package_categories.deleted', 0)
				->get()->toArray();
				$items_arr = array();
				if(isset($packageItemsLIst) && count($packageItemsLIst) > 0){
					foreach($packageItemsLIst as $package_item_rows){
						$items_arr[$package_item_rows['category_id']][] = $package_item_rows;
					}
				}
				$temp['package_items'] = $items_arr;
				$packageItems[] = $temp;
			}
        }
        // return view('plugin::package.index',compact('packages','auth_id'));

		// echo '<pre>';print_r($packageItems);exit;

		// $des=json_decode($store->info->content);

		$rattings = User::where('slug',$slug)->with('five_ratting','four_ratting','three_ratting','two_ratting','one_ratting')->first();


		// SEOMeta::setTitle($store->name);
  //       SEOMeta::setDescription($des->description);



  //       OpenGraph::setDescription($des->description);
  //       OpenGraph::setTitle($store->name);
  //       OpenGraph::setUrl(url()->current());

  //       OpenGraph::addImage($store->preview->content ?? $store->avatar);
  //       OpenGraph::addImage($store->avatar);
  //       OpenGraph::addImage(['url' => $store->preview->content ?? $store->avatar, 'size' => 300]);
  //       OpenGraph::addImage($store->preview->content ?? $store->avatar, ['height' => 300, 'width' => 300]);

  //       JsonLd::setTitle($store->name);
  //       JsonLd::setDescription($des->description);

  //       JsonLd::addImage($store->preview->content ?? $store->avatar);

		$five_calculate = (100 * $rattings->five_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$five_rattings = $five_calculate / $store->vendor_reviews()->count();
		}else{
			$five_rattings = 0;
		}


		$four_calculate = (100 * $rattings->four_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$four_rattings = $four_calculate / $store->vendor_reviews()->count();
		}else{
			$four_rattings = 0;
		}

		$three_calculate = (100 * $rattings->three_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$three_rattings = $three_calculate / $store->vendor_reviews()->count();
		}else{
			$three_rattings = 0;
		}


		$two_calculate = (100 * $rattings->two_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$two_rattings = $two_calculate / $store->vendor_reviews()->count();
		}else{
			$two_rattings = 0;
		}


		$one_calculate = (100 * $rattings->one_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$one_rattings = $one_calculate / $store->vendor_reviews()->count();
		}else{
			$one_rattings = 0;
		}


		Session::put('restaurant_cart',[
			'count' => Cart::instance('cart_'.$store->slug)->count(),
			'slug' => $store->slug
		]);

		Session::put('restaurant_id',[
			'id' => $store->id,
			'name' => $store->name
		]);
		
		$coupon_posts = Terms::where('type',10)->where('auth_id',$user_id)->where('status','1')->get()->toArray();

		if($store && $store->role_id == 3 && $store->status == 'approved' || $store->status == 'offline') {
			if($store->gallery){
				$galleries = explode(",", $store->gallery->content);
			}else{
				$galleries = array();
			}
			// return view('theme::store.index',compact('store','galleries','five_rattings','four_rattings','three_rattings','two_rattings','one_rattings'));

			return view('theme::store.index',compact('store','galleries','five_rattings','four_rattings','three_rattings','two_rattings','one_rattings','packages','auth_id', 'packageItems', 'coupon_posts'));
		}else{
			return abort(404);
		}
	}


	public function showpakages($slug, $packageslug)
	{

		$store=User::with('info','gallery','preview','avg_ratting','delivery','pickup','shopcategory','location','shopday','role','vendor_reviews','ratting','badge','usersaas')->where('slug',$slug)->first();
		if (empty($store)) {
			abort(404);
		}

		$auth_id=Auth::id();
        $category = new Category();
        $package = new Package();
        $packageItem = new PackageItem();
		$AddonItems = new AddonItems();

       $user_id = $store->id;
	   
        //$categories = $category->select('id', 'name')->where('user_id',$auth_id)->get()->toArray();
        // 'category_id',"no_of_items"
        $packages = $package->select('id', 'name', 'description', 'price', 'halal_status', 'slug')
		->where('user_id',$user_id)
		->where('slug',$packageslug)
		->get()->toArray();

		// echo $packageslug;
		// echo $package->select('id', 'name', 'description', 'price', 'halal_status', 'slug')->where('user_id',$user_id)
		// ->where('slug',$packageslug)->toSql();

        $packageItemsLIst = [];
		$packageItems = array();
        if (count($packages) > 0) {
			foreach($packages as $package_row){
				$temp = array();
				$temp = $package_row;
				$package_id = $package_row['id'];
				$packageItemsLIst = $packageItem->select('package_items.id', 'package_items.package_id', 'package_items.name', 'package_items.description', 'package_items.spicy','package_items.mild','package_items.hot','package_items.extra_hot','package_items.none','package_items.package_category_id','categories.name as category_name','package_categories.no_of_items','package_categories.category_id','packages.name as package_name','packages.name as price')
				->leftJoin('package_categories', 'package_categories.id', '=', 'package_items.package_category_id')
				->leftJoin('categories', 'categories.id', '=', 'package_categories.category_id')
				->leftJoin('packages', 'packages.id', '=', 'package_items.package_id')
				->where('package_items.package_id', $package_id)
				->where('package_items.deleted', 0)
				->where('package_categories.deleted', 0)
				->get()->toArray();
				$items_arr = array();
				if(isset($packageItemsLIst) && count($packageItemsLIst) > 0){
					foreach($packageItemsLIst as $package_item_rows){
						$temp['package_details'][$package_item_rows['category_id']]['category_name'] = $package_item_rows['category_name'];
						$temp['package_details'][$package_item_rows['category_id']]['no_of_items'] = $package_item_rows['no_of_items'];
						$temp['package_details'][$package_item_rows['category_id']]['items'][] = $package_item_rows;
					}
				}
				// $temp['package_items'] = $items_arr;
				$packageItems[] = $temp;
				// echo '<pre>';print_r($packageItems);exit;
			}
        }
        // return view('plugin::package.index',compact('packages','auth_id'));

		// $des=json_decode($store->info->content);

		$rattings = User::where('slug',$slug)->with('five_ratting','four_ratting','three_ratting','two_ratting','one_ratting')->first();


		// SEOMeta::setTitle($store->name);
  //       SEOMeta::setDescription($des->description);



  //       OpenGraph::setDescription($des->description);
  //       OpenGraph::setTitle($store->name);
  //       OpenGraph::setUrl(url()->current());

  //       OpenGraph::addImage($store->preview->content ?? $store->avatar);
  //       OpenGraph::addImage($store->avatar);
  //       OpenGraph::addImage(['url' => $store->preview->content ?? $store->avatar, 'size' => 300]);
  //       OpenGraph::addImage($store->preview->content ?? $store->avatar, ['height' => 300, 'width' => 300]);

  //       JsonLd::setTitle($store->name);
  //       JsonLd::setDescription($des->description);

  //       JsonLd::addImage($store->preview->content ?? $store->avatar);

  		$addon_items = $AddonItems->select('id','user_id','name','price')
		  ->where('user_id', $user_id)
		  ->where('deleted', 0)
		  ->get()->toArray();
		// echo '<pre>';print_r($addon_items);exit;


		$five_calculate = (100 * $rattings->five_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$five_rattings = $five_calculate / $store->vendor_reviews()->count();
		}else{
			$five_rattings = 0;
		}


		$four_calculate = (100 * $rattings->four_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$four_rattings = $four_calculate / $store->vendor_reviews()->count();
		}else{
			$four_rattings = 0;
		}

		$three_calculate = (100 * $rattings->three_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$three_rattings = $three_calculate / $store->vendor_reviews()->count();
		}else{
			$three_rattings = 0;
		}


		$two_calculate = (100 * $rattings->two_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$two_rattings = $two_calculate / $store->vendor_reviews()->count();
		}else{
			$two_rattings = 0;
		}


		$one_calculate = (100 * $rattings->one_ratting()->count());
		if($store->vendor_reviews()->count() != 0)
		{
			$one_rattings = $one_calculate / $store->vendor_reviews()->count();
		}else{
			$one_rattings = 0;
		}


		Session::put('restaurant_cart',[
			'count' => Cart::instance('cart_'.$store->slug)->count(),
			'slug' => $store->slug
		]);

		Session::put('restaurant_id',[
			'id' => $store->id,
			'name' => $store->name
		]);

		// echo '<pre>';print_r($packages);exit;
		// print_r($packageItems);

		if($store && $store->role_id == 3 && $store->status == 'approved' || $store->status == 'offline') {
			// $galleries = explode(",", $store->gallery->content);
			// return view('theme::store.index',compact('store','galleries','five_rattings','four_rattings','three_rattings','two_rattings','one_rattings'));
			return view('theme::store.showpakage',compact('store','five_rattings','four_rattings','three_rattings','two_rattings','one_rattings','packages','auth_id', 'packageItems', 'addon_items'));
		}else{
			return abort(404);
		}
	}


	public function store_data(Request $request,$slug)
	{
		$store = User::where('slug',$slug)->first();
		$this->vendor_id = $store->id;
		 $categories =Category::where('user_id',$store->id)->where('type',1)->with('products')->wherehas('products')->get();
		return view('theme::layouts.section.storeproduct',compact('categories','store'));

	}

	public function addon_product(Request $request)
	{
		$store = User::where('slug',$request->store_slug)->first();
		$product = Terms::with('price','addons','excerpt')->where('slug',$request->slug)->first();
		return view('theme::layouts.section.addonproduct',compact('product','store'));
	}

	public function resturantinfo(Request $request)
	{
		$store=User::with('info','shopcategory','location','shopday')->where('slug',$request->slug)->first();
		return view('theme::layouts.section.resturantinfo',compact('store'));
	}


}

