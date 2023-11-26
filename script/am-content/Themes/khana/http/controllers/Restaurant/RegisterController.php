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
use App\Usercategory;
use Carbon\Carbon;
use File;
use Cookie;
use App\Media;
use App\Options;
use Amcoders\Plugin\contactform\Contact;
use Session;
use Amcoders\Plugin\Plugin;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Userplan;
use App\Plan;
use App\Paymentlog;
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

        $plan = Plan::where('status',1)->where('strip_plan_id',$_COOKIE["plan_id"])->first();

        if (!empty($plan)) {
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

        $user->cuisine = 1;


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
            $location = new Location();
            $location->user_id = $user->id;
            $location->term_id = $cityFind->id;
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->save();
        }else{
            $userCity = Str::slug($request->city);

            $terms = new Terms();

            $terms->title = $request->city;
            $terms->slug = $userCity;
            $terms->lang  = "en";
            $terms->auth_id = $user->id;
            $terms->status = 1;
            $terms->type = 2;
            $terms->count = 1;

            $terms->save();
            $cityFind = Terms::where('type',2)->where('slug',$userCity)->first();


            $location = new Location();
            $location->user_id = $user->id;
            $location->term_id = $cityFind->id;
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->save();
        }

        if(count($request->cuisine)>0){
            foreach ($request->cuisine as $key => $value) {
                $Usercategory = new Usercategory();
                $Usercategory->user_id = $user->id;
                $Usercategory->category_id = $value;
                $Usercategory->save();
            }
        }

        $usermeta_1 = new Usermeta();
        $usermeta_1->user_id = $user->id;
        $usermeta_1->type = 'delivery';
        $usermeta_1->content = 21;
        $usermeta_1->save();

        $usermeta_2 = new Usermeta();
        $usermeta_2->user_id = $user->id;
        $usermeta_2->type = 'pickup';
        $usermeta_2->content = 21;
        $usermeta_2->save();

        $usermeta_3 = new Usermeta();
        $usermeta_3->user_id = $user->id;
        $usermeta_3->type = 'rattings';
        $usermeta_3->content = 0;
        $usermeta_3->save();

        $usermeta_4 = new Usermeta();
        $usermeta_4->user_id = $user->id;
        $usermeta_4->type = 'avg_rattings';
        $usermeta_4->content = 0;
        $usermeta_4->save();

        $usermeta_5 = new Usermeta();
        $usermeta_5->user_id = $user->id;
        $usermeta_5->type = 'info';

        $usermeta_5->content = '{"description":"'.$request->business_desc.'","phone1":"'.$request->phone.'","phone2":"'.$request->phone.'","email1":"'.$request->email.'","email2":"'.$request->email.'","address_line":"'.$request->business_address_1.'","full_address":"'.$request->business_address_1.$request->business_address_2.'"}';
        $usermeta_5->save();

        $usermeta_6 = new Usermeta();
        $usermeta_6->user_id = $user->id;
        $usermeta_6->type = 'gallery';
        $usermeta_6->content = null;
        $usermeta_6->save();

        $usermeta_7 = new Usermeta();
        $usermeta_7->user_id = $user->id;
        $usermeta_7->type = 'preview';
        $usermeta_7->content = null;
        $usermeta_7->save();
        Auth::login($user);
        Session::put('userId', $user->id);
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

        // $plan = Stripe::plans()->create([
        //         "currency" => "GBP",
        //         "interval" => "year",
        //         "product" => "prod_NcqR6oWsRUxJzv",
        //         "nickname" => "Yearly Plan",
        //         "amount" => 19.99,
        //     ]);

        // print_r( $plan);

        // echo "Year<br>";
        //    $plan = Stripe::plans()->create([
        //         "currency" => "GBP",
        //         "interval" => "month",
        //         "product" => "prod_NcqRyTv2TswolD",
        //         "nickname" => "Monthly Plan",
        //         "amount" => 0.99,
        //     ]);
        //     print_r( $plan);
        //             echo "Month<br>";
        //     // return view('theme::checkout.index',compact('resturent_info','json','currency','ordertype','km_rate','credentials'));
        //  $plans = Stripe::plans()->all();
        //    print_r($plans);

        // $customer = Stripe::PaymentMethods()->all();
        // print_r($customer);
		return view('theme::store.stripe', compact('resturent_info','json','currency','ordertype','km_rate','credentials'));
	}

    public function step_2_store(Request $request)
    {

        return redirect('restaurant/register/stripe');
    }

    public function stripe_view()
    {

        // $customer = Stripe::PaymentMethods()->all();
        // print_r($customer);
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


        // print_r($data);
        //return view('theme::store.register_step_3')->with($data);
    }


    public function stripe(Request $request)
    {

        $userId = Session::get('userId');
        $data["user"] =  Auth::User();
        if ($data["user"]->id) {

           $customer = Stripe::customers()->create(array(
               "description" => "CaterAnEvent Subscriptions",
               "source" => $request->stripeToken,  //Bank or Card token
               "email" => $data["user"]->email,
               "metadata" =>[],
               "address" => array(
                    "line1" => $data["user"]->business_address_1,
                    "line2" => $data["user"]->business_address_2,
                    "city" => $data["user"]->business_town,
                    "country" => "GB",
                    "postal_code" => $data["user"]->business_postal_code
                ),
               "shipping" =>array(
                "name" => $data["user"]->business_name,
                "phone" => $data["user"]->phone,
                "address" =>array(
                        "line1" => $data["user"]->business_address_1,
                        "line2" => $data["user"]->business_address_2,
                        "city" => $data["user"]->business_town,
                        "country" => "GB",
                        "postal_code" => $data["user"]->business_postal_code
                    )
                ),
               "name" => $data["user"]->business_name,
               "phone" => $data["user"]->phone
            ));

           // $plan = Stripe::plans()->create([
           //      "currency" => "GBP",
           //      "interval" => "year",
           //      "product" => "prod_N7PUkiGbnVsDeN",
           //      "nickname" => "Yearly Plan",
           //      "amount" => 19.99,
           //  ]);

           // $plan = Stripe::plans()->create([
           //      "currency" => "GBP",
           //      "interval" => "month",
           //      "product" => "prod_N6yk79EjQVevbR",
           //      "nickname" => "Monthly Plan",
           //      "amount" => 0.99,
           //  ]);

           // $plans = Stripe::plans()->all();
           // print_r($plans);

           $plan = Plan::where('status',1)->where('id',$data["user"]->plan_id)->first();

           // print_r($customer);

           // $paymentMethod = Stripe::PaymentMethod()->retrieve($customer["invoice_settings"]["default_payment_method"]);
           // $paymentMethod->attach([
           //      'customer' => $customer['id'],
           //  ]);

           // $customer1 = Stripe::customers()->update($customer['id'],[
           //      'invoice_settings' => [
           //          'default_payment_method' => "pm_1MrbRiJcAurJ4vdUP0LYXBld",
           //      ],
           //  ]);
           

           $charge = Stripe::subscriptions()->create($customer['id'], [
                'plan' => $plan->strip_plan_id
            ]);
           // $charge = Stripe::subscriptions()->create($customer['id'],

           //      ['items' => [
           //          [
           //              'plan' => $plan->strip_plan_id
           //          ],
           //      ],
           //      'off_session' => TRUE, //for use when the subscription renews
           //  ]);

            // print_r($charge);

            $Paymentlog = new Paymentlog();
            $Paymentlog->requestBody  = json_encode($customer);
            $Paymentlog->responseBody = json_encode($charge);
            $Paymentlog->save();

           if($charge["id"]){
                $plan=new Userplan();
                $plan->user_id =  $data["user"]->id;
                $plan->plan_id  = $data["user"]->plan_id;
                $plan->payment_method  = "custom";
                $plan->payment_status  = "Success";
                $plan->status  = "Success";
                $plan->amount  = Plan::find($data["user"]->plan_id)->s_price;
                $plan->save();

                $user = User::find($data["user"]->id);
                $user->status  = "approved";
                $user->paymentStatus = 1;
                $user->save();
                return redirect()->route('store.dashboard');
           }else{
            return redirect('error');
           }
        }

    }
    public function thankyou()
    {
        return view('theme::store.thankyou');
    }

    public function error()
    {
        return view('theme::store.error');
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
