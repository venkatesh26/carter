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

class StoreController extends controller
{
	protected $vendor_id;

	public function show($slug)
	{


		$User = new User();
		$store=$User->select('id','role_id','plan_id','avatar','first_name','last_name','email','phone','business_name','business_disp_name','business_logo_file','business_desc','business_address_1','business_address_2','business_town','business_country','business_postal_code','registered_fsa','registered_fsa_file','hygiene_certificate','hygiene_certificate_file','hygiene_rating','cuisine','others_specifiy','can_you_deliver','guests_max','guests_min','min_order','min_order_amount','extra_serivices','specialities','status')->where('business_name_url',$slug)->get()->toArray();
		// echo '<pre>';print_r($store);exit;


		$store1=User::with('info','gallery','preview','avg_ratting','delivery','pickup','shopcategory','location','shopday','role','vendor_reviews','ratting','badge','usersaas')->where('slug',$slug)->first();
		if (empty($store)) {
			abort(404);
		}
		$user_id = $store[0]['id'];

		$auth_id=Auth::id();
        $category = new Category();
        $package = new Package();
        $packageItem = new PackageItem();

        //$categories = $category->select('id', 'name')->where('user_id',$auth_id)->get()->toArray();
        // 'category_id',"no_of_items"
        $packages = $package->select('id', 'name', 'description', 'price', 'halal_status', 'status', 'approved')->where('user_id',$user_id)->get()->toArray();

        // $packageItems = [];
		$package_arr = array();
        if (isset($packages) && count($packages) > 0) {
            // $packageIds = array_column($packages, "id");
            // $packageItems = $packageItem->select('id', 'package_id', 'name', 'description', 'spicy')
			// 							->where('user_id',$user_id)
			// 							->whereIn('package_id', $packageIds)
			// 							->where('deleted', 0)
			// 							->get()
			// 							->toArray();
			foreach($packages as $package_row){
				$temp = array();
				$temp = $package_row;
				// echo '<pre>';print_r($package_row);exit;
				$package_id = $package_row['id'];
				$packageItems = $packageItem->select('id', 'package_id', 'name', 'description', 'spicy', 'mild', 'hot', 'extra_hot', 'none')
											->where('user_id',$user_id)
											->where('package_id', $package_id)
											->where('deleted', 0)
											->get()
											->toArray();
				$temp['package_items'] = $packageItems;
				$package_arr[] = $temp;
			}
        }
		// echo 'User Details <pre>';print_r($store);//exit;
		// echo "<br>";
		// echo 'Package Details <pre>';print_r($package_arr);exit;
        // return view('plugin::package.index',compact('packages','auth_id'));

		// print_r($store);

		// $des=json_decode($store->info->content);

		// $rattings = User::where('business_name_url',$slug)->with('five_ratting','four_ratting','three_ratting','two_ratting','one_ratting')->first();

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
		if($store1->vendor_reviews()->count() != 0)
		{
			$five_rattings = $five_calculate / $store1->vendor_reviews()->count();
		}else{
			$five_rattings = 0;
		}


		$four_calculate = (100 * $rattings->four_ratting()->count());
		if($store1->vendor_reviews()->count() != 0)
		{
			$four_rattings = $four_calculate / $store1->vendor_reviews()->count();
		}else{
			$four_rattings = 0;
		}

		$three_calculate = (100 * $rattings->three_ratting()->count());
		if($store1->vendor_reviews()->count() != 0)
		{
			$three_rattings = $three_calculate / $store1->vendor_reviews()->count();
		}else{
			$three_rattings = 0;
		}


		$two_calculate = (100 * $rattings->two_ratting()->count());
		if($store1->vendor_reviews()->count() != 0)
		{
			$two_rattings = $two_calculate / $store1->vendor_reviews()->count();
		}else{
			$two_rattings = 0;
		}


		$one_calculate = (100 * $rattings->one_ratting()->count());
		if($store1->vendor_reviews()->count() != 0)
		{
			$one_rattings = $one_calculate / $store1->vendor_reviews()->count();
		}else{
			$one_rattings = 0;
		}


		Session::put('restaurant_cart',[
			'count' => Cart::instance('cart_'.$store->slug)->count(),
			'business_name_url' => $store->slug
		]);

		Session::put('restaurant_id',[
			'id' => $store->id,
			'name' => $store->name
		]);

		if($store && $store->role_id == 3 && $store->status == 'approved' || $store->status == 'offline') {
			// $galleries = explode(",", $store->gallery->content);
			// return view('theme::store.index',compact('store','galleries','five_rattings','four_rattings','three_rattings','two_rattings','one_rattings'));
			return view('theme::store.index',compact('store','five_rattings','four_rattings','three_rattings','two_rattings','one_rattings','packages','auth_id', 'packageItems', 'package_arr'));
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

