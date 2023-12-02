<?php

namespace Amcoders\Theme\khana\http\controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Terms;
use App\Location;
use App\Category;
use App\Options;
use Cart;
use Str;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
class AreaController extends controller
{
	protected $categories;

	public function index($slug)
	{
		 $info=Terms::where('slug',$slug)->where('status',1)->where('type',2)->with('excerpt','preview')->first();

		if (empty($info)) {
			abort(404);
		}
		 $mapinfo=json_decode($info->excerpt->content ?? '');

		$lat = (double)$mapinfo->latitude;
		$long = (double)$mapinfo->longitude;
		$zoom = (double)$mapinfo->zoom;

		

		SEOMeta::setTitle($info->title);
        SEOMeta::setDescription($info->title);
        SEOMeta::setCanonical($info->title);

        OpenGraph::setDescription($info->title);
        OpenGraph::setTitle($info->title);
        OpenGraph::setUrl(url()->current());


        TwitterCard::setTitle($info->title);
        TwitterCard::setSite($info->title);

        JsonLd::setTitle($info->title);
        JsonLd::setDescription($info->title);
        JsonLd::addImage($info->preview->content);


	    return view('theme::area.index',compact('info','slug','lat','long','zoom'));
	}

	public function areainfo(Request $request,$id)
	{

		//echo "id".$id;
		if (!$request->ajax()) {
			abort(404);
		}

		// echo "test";
		$info=Terms::where('status',1)->where('type',2)->with('excerpt')->find($id);
		$mapinfo=json_decode($info->excerpt->content);

		$lat = (double)$mapinfo->latitude;
		$long = (double)$mapinfo->longitude;
		$zoom = (double)$mapinfo->zoom;

		if (!empty($request->cats)) {

		 $posts=Location::join('user_category','user_category.user_id','locations.user_id')
		 	 ->where('locations.role_id',3)
		     ->where('locations.term_id',$id)
		     ->where('user_category.category_id',$request->cats)
		     ->wherehas('users')
		     ->with('users')
		     ->orderBy('locations.id',$request->order)
		     ->paginate(12);
		}
		else{
			$posts=Location::where('role_id',3)
			->where('term_id',$id)
			->wherehas('users')
			->with('users')
			->orderBy('id',$request->order)
			->paginate(12);
		}

		// print_r($posts);

	   $data['lat']=$lat;
	   $data['long']=$long;
	   $data['zoom']=$zoom;
	   $data['data']=$posts;


	   return response()->json($data);
	}

	public function show(Request $request,$id)
	{

		if (!$request->ajax()) {
			abort(404);
		}

		if ($id==0) {

			// $posts = Location::join('user_category','user_category.user_id','locations.user_id')
			// ->where('user_category.category_id',$request->cats)
			// ->wherehas('users')
			// ->with('users')
			// ->orderBy('locations.id',$request->order)
			// ->paginate(150);

			// $posts = Location::join('user_category','user_category.user_id','locations.user_id')
			// ->where('user_category.category_id',$request->cats)
			// ->orderBy('locations.id',$request->order)
			// ->paginate(150);
			
			//$posts = User::join('')->where('status', "approved")->where('role_id', 3)->paginate(150);

			$posts = User::with('info','gallery','preview','avg_ratting','delivery','pickup','shopcategory','location','shopday','role','vendor_reviews','ratting','badge','usersaas')->where('status', "approved")->where('role_id', 3)->paginate(150);


			//$posts = User::where('status', "approved")->where('role_id', 3)->with('usermeta')->paginate(150);

			$collection = $posts->getCollection();
			$postcode2["po2"]  = $request->postalcode;
			$postcode2["test"]  = array();

			

			$test = array();
			$filteredCollection = $collection->filter(function($value) use ($postcode2) {
			  	//echo $postcode2;

				// print_r($postcode2);
			    $postcode2New = str_replace(' ', '', $postcode2["po2"]);

			    $postcode1 = $value->business_postal_code;

			    // $postcode2["post1"][] = $postcode1;
			    // $postcode2["post2"][] = $postcode2New;

			    $result = array();

				if(!empty($postcode1)){
					$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$postcode1&destinations=$postcode2New&mode=bicycling&language=en-EN&sensor=false&key=AIzaSyDIcTJiRuUxY6RCsQ7s3ZLBdif-DbFt0xg";

					$postcode2["post3"][] = $url;
					$data = @file_get_contents($url);
					$result = json_decode($data, true);

					if($result["status"] == "OK"){
					    if(count($result['rows'])>0){
					    	if($result['rows'][0]['elements'][0]["status"] !="ZERO_RESULTS"){

						        $distance = $result['rows'][0]['elements'][0]['distance']['value'];
						        $distance = round($distance / 1000);

						        if($distance <= 40){
						        	return $value;
						        }
						    }
					    }
					}
				}
			});
			// print_r($filteredCollection);
			$posts->setCollection($filteredCollection);

			// print_r($postcode2);
			// $posts->getCollection()->transform(function ($value) use ($postcode2) {
			    
			//     global $postcode2;

			//     $postcode2 = str_replace(' ', '', $postcode2);

			//     $postcode1 = $value->business_postal_code;

			//     $result = array();

			// 	if(!empty($postcode1)){
			// 		echo $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$postcode1&destinations=$postcode2&mode=bicycling&language=en-EN&sensor=false&key=AIzaSyDIcTJiRuUxY6RCsQ7s3ZLBdif-DbFt0xg";

			// 		$data = @file_get_contents($url);

			// 		$result = json_decode($data, true);

			// 		// print_r($result);

			// 		if($result["status"] == "OK"){
			// 		    if(count($result['rows'])>0){
			// 		    	if($result['rows'][0]['elements'][0]["status"] !="ZERO_RESULTS"){

			// 			        $distance = $result['rows'][0]['elements'][0]['distance']['value'];
			// 			        $distance = round($distance / 1000);

			// 			        if($distance <= 40){
			// 			        	return $value;
			// 			        }
			// 			    }
			// 		    }
			// 		}
			// 	}
			// });
			return $posts;

			// $info=Options::where('key','default_map')->first();
			// $mapinfo=json_decode($info->value);
			// $lat = (double)$mapinfo->default_lat;
			// $long = (double)$mapinfo->default_long;
			// $zoom = (double)$mapinfo->default_zoom;



			// $data['lat']=$lat;
			// $data['long']=$long;
			// $data['zoom']=$zoom;
			// $data['data']=$posts;


			// return response()->json($data);
		}
		if (!empty($request->cats)) {
			// echo "test";


			$delivery = "";

			if($request->delivery && $request->delivery['del']){
				$delivery = $request->delivery['del'][0];
				// echo $delivery;

				if($delivery == 1){
					$posts=Location::join('user_category','user_category.user_id','locations.user_id')
				 	 ->where('locations.role_id',3)
				     ->where('locations.term_id',$id)
				     ->where('user_category.category_id',$request->cats)
				     // ->wherehas('users')
				     ->whereHas('users')
				     ->orderBy('locations.id',$request->order)
				     ->paginate(12);

				     // , function($query){
		       //          $query->where('can_you_deliver', '=', "Collection only");
		       //      }
				 //     $query = str_replace(array('?'), array('\'%s\''), $posts->toSql());
					// $query = vsprintf($query, $posts->getBindings());
					// dump($posts->toSql());

					// $result = $posts->get();

					return $posts;

				}else{
					return $posts=Location::join('user_category','user_category.user_id','locations.user_id')
				 	 ->where('locations.role_id',3)
				     ->where('locations.term_id',$id)
				     ->where('user_category.category_id',$request->cats)
				     ->whereHas('users')
				     // ->with('users')
				     ->orderBy('locations.id',$request->order)
				     ->paginate(12);
				     // , function($query){
		       //          $query->where('can_you_deliver', '!=', "Collection only");
		       //      }
				}
			}else{
				 return $posts=Location::join('user_category','user_category.user_id','locations.user_id')
				 	 ->where('locations.role_id',3)
				     ->where('locations.term_id',$id)
				     ->where('user_category.category_id',$request->cats)
				     ->wherehas('users')
				     ->with('users')
				     ->orderBy('locations.id',$request->order)
				     ->paginate(12);
			}

		}
		else{
		return $posts=Location::where('locations.role_id',3)

		->where('term_id',$id)
		->wherehas('users')
		->with('users')
		->orderBy('id',$request->order)
		->paginate(12);
		}

	}

	public function info($id)
	{
		 $info=Terms::where('id',$id)->where('status',1)->where('type',2)->with('excerpt','location')->first();
		 if(empty($info)){
		 	return [];
		 }
		 return $info;

	}

	public function resturents(Request $request)
	{
		if (!empty($request->postalcode)) {

			$slug = Str::slug($request->city);

			$info=Terms::where('slug',$slug)->where('status',1)->where('type',2)->with('excerpt','location')->first();

			$lat = $request->lat;
			$long = $request->long;
			$zoom = 10;

			$mapinfo=json_decode($info->excerpt->content ?? '');
			if (!empty($info)) {
				// $lat = (double)$mapinfo->latitude;
				// $long = (double)$mapinfo->longitude;
				// $zoom = (double)$mapinfo->zoom;
				// echo $this->haversineGreatCircleDistance($lat, $long, $long, $long, $earthRadius = 6371000);
			}
			return view('theme::area.index',compact('info','slug','lat','long','zoom'));
		}
		abort(404);
	}



	public function category($slug)
	{
		$category=Category::where('slug',$slug)->where('type',2)->first();
		if (empty($category)) {
			abort(404);
		}
		$info=Options::where('key','default_map')->first();
		$mapinfo=json_decode($info->value);

		$lat = (double)$mapinfo->default_lat;
		$long = (double)$mapinfo->default_long;
		$zoom = (double)$mapinfo->default_zoom;

		SEOMeta::setTitle($category->name);
        SEOMeta::setDescription($category->name);
        SEOMeta::setCanonical($category->name);

        OpenGraph::setDescription($category->name);
        OpenGraph::setTitle($category->name);
        OpenGraph::setUrl(url()->current());


        TwitterCard::setTitle($category->name);
        TwitterCard::setSite($category->name);

        JsonLd::setTitle($category->name);
        JsonLd::setDescription($category->name);
        JsonLd::addImage($category->avatar);

		return view('theme::area.index',compact('slug','lat','long','zoom','category'));
	}


	public function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000){
	  // convert from degrees to radians
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;

	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  return $angle * $earthRadius;
	}

}
