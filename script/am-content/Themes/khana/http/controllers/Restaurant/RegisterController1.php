<?php

namespace Amcoders\Theme\khana\http\controllers\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Terms;
use App\User;
use App\Location;
use Auth;
use Hash;
use Illuminate\Support\Str;
use App\Usermeta;
use Carbon\Carbon;
use File;
use Cookie;
use App\Media;
use App\Options;
use Amcoders\Plugin\contactform\Contact;
use Session;
use Amcoders\Plugin\Plugin;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Amcoders\Plugin\Paymentgetway\http\controllers\StripeController;

/**
 *
 */
class RegisterController extends controller
{
	public function index()
	{
        if (Auth::check()) {
            return redirect()->route('store.dashboard');
        } else {
            $data = [];
            $data["user"] = Auth::User();
            return view('theme::store.register_step_1')->with($data);
        }
	}

	public function store(Request $request)
	{
		$validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'dob' => 'required',
            'phone' => 'required'
        ]);

        if($validator->fails())
        {
            return back()->with('errors',$validator->errors()->all()[0])->withInput($request->input());
        }

        $badge = Terms::where('type',3)->where('status',1)->where('count',1)->first();

        $user = new User();
        $user->role_id = 3;

        if(!isset($_COOKIE["plan_id"])) {
            $plan =Plan::where('status',1)->where('strip_plan_id',$_COOKIE["plan_id"])->first();
            $user->plan_id = $plan->id;
        }else{
            $user->plan_id = 2;
        }


        if (!empty($badge)) {
           $user->badge_id = $badge->id;
        }

        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);
        $user->dob = date("Y-m-d", strtotime($request->dob));
        $user->phone = trim($request->phone);
        $user_name = $user->first_name." ".$user->last_name;

        $password = Hash::make($request->password);
        $user->password = $password;
        $user->c_password = $password;

        $user_slug=Str::slug($user_name);
        $user_slug_data = User::where('slug',$user_slug)->first();

        $user->email_verified_at = date("Y-m-d H:i:s");

        if ($user_slug_data) {
            $slug= Str::slug($user_name).Str::random(5);
        }
        else{
            $slug=Str::slug($user_name);
        }

        $user->slug = $slug;

        $upload_path = 'uploads/register/';

        $business_logo_file = null;
        $file = $request->file('business_logo_file');
        if (isset($file)) {
            $curentdate = Carbon::now()->toDateString();
            $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $imagename);
            $business_logo_file = $upload_path.$imagename;

        }

        $user->id = $user->id;
        $user->role_id = trim($request->business_type);
        $user->business_name = trim($request->business_name);

        $business_name_url = $this->slugify(trim($request->business_name));
        $business_name_url_result_count = User::where('business_name_url',$business_name_url)->count();
        $business_url_count_append = '';
        if($business_name_url_result_count > 0){
            $business_url_count_append = '-'.$business_name_url_result_count;
        }
        $business_name_url = $business_name_url.$business_url_count_append;
        $user->business_name_url = trim($business_name_url);

        $user->slug = trim($business_name_url);

        $user->business_disp_name = trim($request->business_disp_name);
        $user->business_logo_file = $business_logo_file;
        $user->business_desc = trim($request->business_desc);
        // $user->password = $password;
        // $user->c_password = $password;
        $user->business_address_1 = trim($request->business_address_1);
        $user->business_address_2 = trim($request->business_address_2);
        $user->business_town = trim($request->business_town);
        $user->business_country = trim($request->business_country);
        $user->business_postal_code = trim($request->business_postal_code);
        $user->registered_fsa = $request->registered_fsa;
        $user->hygiene_certificate = $request->hygiene_certificate;

        $registered_fsa = (bool) $request->registered_fsa;
        $hygiene_certificate = (bool) $request->hygiene_certificate;

        if ($registered_fsa) {
            $registered_fsa_file = null;
            $file = $request->file('registered_fsa_file');
            if (isset($file)) {
                $curentdate = Carbon::now()->toDateString();
                $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($upload_path, $imagename);
                $registered_fsa_file = $upload_path.$imagename;
            }
            $user->registered_fsa_file = $registered_fsa_file;
        }

        if ($hygiene_certificate) {
            $hygiene_certificate_file = null;
            $file = $request->file('hygiene_certificate_file');
            if (isset($file)) {
                $curentdate = Carbon::now()->toDateString();
                $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($upload_path, $imagename);
                $hygiene_certificate_file = $upload_path.$imagename;
            }
            $user->hygiene_certificate_file = $hygiene_certificate_file;
        }

        $user->hygiene_rating = isset($request->hygiene_rating) ? trim($request->hygiene_rating) : NULL;

        $user->cuisine = isset($request->cuisine) ? trim($request->cuisine) : NULL;
        $user->others_specifiy = isset($request->others_specifiy) ? trim($request->others_specifiy) : NULL;
        $user->can_you_deliver = implode(",",$request->can_you_deliver);
        $user->guests_max = isset($request->guests_max) ? trim($request->guests_max) :NULL;
        $user->guests_min = isset($request->guests_min) ? trim($request->guests_min) : NULL;
        $user->min_order = isset($request->min_order) ? trim($request->min_order) : NULL;
        $user->min_order_amount = isset($request->min_order_amount) ? (int) trim($request->min_order_amount) : NULL;
        $user->extra_serivices = isset($request->extra_serivices) ? implode(",",$request->extra_serivices) : NULL;
        $user->specialities = isset($request->specialities) ? implode(",",$request->specialities) : NULL;


        $user->save();
        $cityFind = Terms::where('type',2)->where('title',$request->city)->first();

        if($cityFind){
            // $terms = Terms::where('type',2)->get();
            // $location = new Location();
            // $location->user_id = $user->id;
            // $location->term_id = $cityFind->id;
            // $location->latitude = $request->latitude;
            // $location->longitude = $request->longitude;
            // $location->save();
        }else{
            $userCity = Str::slug($request->city);

            $terms = new Terms();

            $terms->title = $request->city;
            $terms->slug = $userCity;
            $terms->lang  = "en";
            $terms->auth_id = 1;
            $terms->status = 1;
            $terms->type = 2;
            $terms->count = 0;
            $terms->save();
            $cityFind = Terms::where('type',2)->where('slug',$userCity)->first();

            $location = new Location();
            $location->user_id = $user->id;
            $location->term_id = $cityFind->id;
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->save();
        }
        return redirect()->route('restaurant.register_step_2');
	}

	public function step_2(Request $request)
	{
        $data = [];
        $data["user"] = Auth::User();

         // $resturent_info=User::with('resturentlocation','info')->find(Session::get('restaurant_id')['id']);
        // $resturent_info=User::with('resturentlocation','info')->find(1);
        $resturent_info = array();
        $resturent_info =json_encode( $resturent_info);
        $json=json_decode($resturent_info);
        $currency=Options::where('key','currency_name')->first();


        $ordertype=$request->delivery_type ?? 1;

        $km_rate=Options::where('key','km_rate')->first();
        $option=\App\Options::where('key','payment_settings')->first();
        if($option)
        {
            $credentials=json_decode($option->value);
        }else{
            $credentials = null;
        }

            // return view('theme::checkout.index',compact('resturent_info','json','currency','ordertype','km_rate','credentials'));

		return view('theme::store.stripe', compact('resturent_info','json','currency','ordertype','km_rate','credentials'));
	}

    public function step_2_store(Request $request)
    {
        return redirect('restaurant/register/stripe');
    }

    public function stripe_view()
    {
      return view('theme::store.stripe');
    }


    public function step_3_payment()
    {
        $data = [];
        $user = Auth::User();
        $data["user"] = Auth::User();
        // echo '<pre>';print_r($user->id);exit;
        /*$data["user_id"] = $user_id;
        if (!empty(Cookie::get('user_id'))) {
            $user = Auth::User();
            $data["user"] = $user;
        }*/

        print_r($data);
        //return view('theme::store.register_step_3')->with($data);
    }


    public function stripe(Request $request)
    {

        //if (Session::has('order_info')) {
           $data=Session::get('order_info');
           $data= [];
           $data['stripeToken']=$request->stripeToken;
          return StripeController::make_payment($data);
        //}

    }


    public function payment_success()
    {
        if (Session::has('payment_info')) {
            $payment_info=Session::get('payment_info');
            $order_id=$payment_info['ref_id'];
            $vendor_id=$payment_info['vendor_id'];
            $order=Order::find($order_id);
            $info=json_decode($order->data);
            $info->payment_id=$payment_info['payment_id'];
            $order->data=json_encode($info);
            $order->payment_status=1;
            $order->save();

            Session::forget('payment_info');
            Session::forget('order_info');

            if (Plugin::is_active('WebNotification')) {
                $vendors=\App\Onesignal::where('user_id',$order->vendor_id)->latest()->take(2)->get();
                foreach ($vendors as $key => $row) {
                    OneSignal::sendNotificationToUser("New Order",$row->player_id,url('/store/order/'.$order->id));
                }
            }
            return redirect('order/confirmation');
        }
        Session::forget('payment_info');
        Session::forget('order_info');

        abort(404);

    }

    public function step_3_store(Request $request)
    {


        $user = Auth::User();

        // echo "<pre>";
        // print_r($request->all());
        // exit;

        $user->id = $user->id;
        $user->cuisine = isset($request->cuisine) ? trim($request->cuisine) : NULL;
        $user->others_specifiy = isset($request->others_specifiy) ? trim($request->others_specifiy) : NULL;
        $user->can_you_deliver = implode(",",$request->can_you_deliver);
        $user->guests_max = isset($request->guests_max) ? trim($request->guests_max) :NULL;
        $user->guests_min = isset($request->guests_min) ? trim($request->guests_min) : NULL;
        $user->min_order = isset($request->min_order) ? trim($request->min_order) : NULL;
        $user->min_order_amount = isset($request->min_order_amount) ? (int) trim($request->min_order_amount) : NULL;
        $user->extra_serivices = isset($request->extra_serivices) ? implode(",",$request->extra_serivices) : NULL;
        $user->specialities = isset($request->specialities) ? implode(",",$request->specialities) : NULL;

        $user->save();

        return redirect()->route('restaurant.register_step_4');
    }


    public function step_4(Request $request)
    {
        /*$user_id = null;
        if ($request->has('id')) {
            $user_id = $request->input('id');
        }

        if (empty($user_id)){
            return redirect()->route('restaurant.register');
        }

        $user = User::where([
            ['id',$user_id],
        ])->first();

        Auth::login($user);*/

        return view('theme::store.register_step_4');
    }

    function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }


}
