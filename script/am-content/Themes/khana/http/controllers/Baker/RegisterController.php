<?php

namespace Amcoders\Theme\khana\http\controllers\Baker;
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
use App\Media;
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
            return view('theme::store.baker/register_step_1');
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
            // 'password' => 'required|confirmed',
            // 'delivery' => 'required',
            // 'pickup' => 'required',
            // 'phone_number_1' => 'required',
            // 'phone_number_2' => 'required',
            // 'email_address_1' => 'required',
            // 'email_address_2' => 'required',
            // 'description' => 'required'
        ]);

        if($validator->fails())
        {
            return back()->with('errors',$validator->errors()->all()[0]);
        }

        $badge = Terms::where('type',3)->where('status',1)->where('count',1)->first();

        $user = new User();
        $user->role_id = 5;
        $user->plan_id = 1;
        if (!empty($badge)) {
           $user->badge_id = $badge->id;
        }
        
        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);
        $user->dob = date("Y-m-d", strtotime($request->dob));
        // $user->gender = $request->gender;
        $user->phone = trim($request->phone);
        $user_name = $user->first_name." ".$user->last_name;

        $password = Hash::make($request->password);
        $user->password = $password;
        $user->c_password = $password;

        $user_slug=Str::slug($user_name);
        $user_slug_data = User::where('slug',$user_slug)->first();
        

        // echo "<pre>";
        // print_r($user_slug);
        // exit;

        if ($user_slug_data) {
            $slug= Str::slug($user_name).Str::random(5);
        }
        else{
            $slug=Str::slug($user_name);
        }

        $user->slug = $slug;

        // $user->password = Hash::make($request->password);
        
        $user->save();

        Auth::login($user);

        /*
        $usermeta_1 = new Usermeta();
        $usermeta_1->user_id = $user->id;
        $usermeta_1->type = 'delivery';
        $usermeta_1->content = $request->delivery;
        $usermeta_1->save();

        $usermeta_2 = new Usermeta();
        $usermeta_2->user_id = $user->id;
        $usermeta_2->type = 'pickup';
        $usermeta_2->content = $request->pickup;
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
        $usermeta_5->content = '{"description":"'.$request->description.'","phone1":"'.$request->phone_number_1.'","phone2":"'.$request->phone_number_2.'","email1":"'.$request->email_address_1.'","email2":"'.$request->email_address_2.'","address_line":null,"full_address":null}';
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
        */


        return redirect()->route('baker.register_step_2');
	}

	public function step_2()
	{
        // $location = Location::where('user_id',Auth::User()->id)->first();
        // if($location)
        // {
        //     return redirect()->route('store.dashboard');
        // }
        // $cities = Terms::where('type',2)->get();
        $data = [];
        $data["user"] = Auth::User();
		return view('theme::store.baker/register_step_2')->with($data);
	}

    public function step_2_store(Request $request)
    {

        // $user = Auth::User();
        // $location = new Location();
        // $location->user_id = $user->id;
        // $location->term_id = $request->city;
        // $location->latitude = $request->latitude;
        // $location->longitude = $request->longitude;
        // $location->role_id = 3;
        // $location->save();

        // $usermeta = Usermeta::where([
        //     ['user_id',$user->id],
        //     ['type','info']
        // ])->first();
        // $user_data = json_decode($usermeta->content);
        // $user_data->address_line = $request->address_line;
        // $user_data->full_address = $request->full_address;

        // $usermeta->content = json_encode($user_data);
        // $usermeta->save();

        /*
        $user_id = null;
        if ($request->has('id')) {
            $user_id = $request->input('id');
        }

        if (empty($user_id)){
            return redirect()->route('store.register');
        }*/
        // $data = [];
        $user = Auth::User();

        // $user = User::where([
        //     ['id',$user_id],
        // ])->first();

        // echo "<pre>";
        // print_r($user);
        // exit;
        
        
        $upload_path = 'uploads/register/';

        $business_logo_file = null;
        $file = $request->file('business_logo_file');
        if (isset($file)) {
            $curentdate = Carbon::now()->toDateString();
            $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $imagename);
            $business_logo_file = $upload_path.$imagename;

            /*$media = new Media();
            $media->user_id = $user_id;
            $media->name = $path.$imagename;
            $media->type = $logo_file->getClientOriginalExtension();
            $schemeurl=parse_url(url('/'));
            if ($schemeurl['scheme']=='https') {
               $url=substr(url('/'), 6);
            }
            else{
                 $url=substr(url('/'), 5);
            }
            $media->url = $url.'/'.$path.$imagename;
            $media->size = File::size('uploads/'.$imagename).'kib';
            $media->path = 'uploads/';
            $media->save();

            $user = Auth::User();
            $user->avatar = $url.'/'.$path.$imagename;
            $user->save();
            */

        }
        
        
        
        // var_dump($registered_fsa);
        // exit;

        // $password = Hash::make($request->password);
        $user->id = $user->id;
        $user->business_name = trim($request->business_name);
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
            
        
        // $user->hygiene_certificate_file = $hygiene_certificate_file;
        $user->hygiene_rating = trim($request->hygiene_rating);

        $user->save();
        
        // print_r($user);
        // exit;

        return redirect()->route('baker.register_step_3');


    }

    public function step_3()
    {
        $data = [];
        $data["user"] = Auth::User();
        return view('theme::store.baker/register_step_3')->with($data);
    }

    public function step_3_store(Request $request)
    {
        // $this->validate($request,[
        //     'cover_img' => 'required|image',
        //     'logo_img' => 'required|image'
        // ]);

        // $logo_file = $request->file('logo_img');
        // if (isset($logo_file)) {
        //     $curentdate = Carbon::now()->toDateString();
        //     $imagename =  $curentdate . '-' . uniqid() . '.' . $logo_file->getClientOriginalExtension();


        //     $path = 'uploads/';

        //     $logo_file->move($path, $imagename);

        //     $logo_file_name = $path.$imagename;


        //     $media = new Media();
        //     $media->user_id = Auth::User()->id;
        //     $media->name = $path.$imagename;
        //     $media->type = $logo_file->getClientOriginalExtension();
        //     $schemeurl=parse_url(url('/'));
        //     if ($schemeurl['scheme']=='https') {
        //        $url=substr(url('/'), 6);
        //     }
        //     else{
        //          $url=substr(url('/'), 5);
        //     }
        //     $media->url = $url.'/'.$path.$imagename;
        //     $media->size = File::size('uploads/'.$imagename).'kib';
        //     $media->path = 'uploads/';
        //     $media->save();

        //     $user = Auth::User();
        //     $user->avatar = $url.'/'.$path.$imagename;
        //     $user->save();

        // }else{
        //     $imagename = 'default.png';
        // }

        //  $cover_file = $request->file('cover_img');
        // if (isset($cover_file)) {
        //     $curentdate = Carbon::now()->toDateString();
        //     $imagename =  $curentdate . '-' . uniqid() . '.' . $cover_file->getClientOriginalExtension();


        //     $path = 'uploads/';

        //     $cover_file->move($path, $imagename);

        //     $cover_file_name = $path.$imagename;

        //     $main_cover_file_path = 'uploads/'. $imagename;

        //     $media = new Media();
        //     $media->user_id = Auth::User()->id;
        //     $media->name = $path.$imagename;
        //     $media->type = $cover_file->getClientOriginalExtension();
        //     $schemeurl=parse_url(url('/'));
        //     if ($schemeurl['scheme']=='https') {
        //        $url=substr(url('/'), 6);
        //     }
        //     else{
        //          $url=substr(url('/'), 5);
        //     }
        //     $media->url = $url.'/'.$path.$imagename;
        //     $media->size = File::size('uploads/'.$imagename).'kib';
        //     $media->path = 'uploads/';
        //     $media->save();

        //     $usermeta = Usermeta::where([
        //         ['type','preview'],
        //         ['user_id',Auth::User()->id]
        //     ])->first();
        //     $usermeta->content = $url.'/'.$path.$imagename;
        //     $usermeta->save();

        // }else{
        //     $imagename = 'default.png';
        // }

        /*$user_id = null;
        if ($request->has('id')) {
            $user_id = $request->input('id');
        }

        if (empty($user_id)){
            return redirect()->route('store.register');
        }

        $user = User::where([
            ['id',$user_id],
        ])->first();*/

        $user = Auth::User();

        // echo "<pre>";
        // print_r($request->all());
        // exit;
        
        $user->id = $user->id;
        $user->can_you_deliver = implode(",",$request->can_you_deliver);
        $user->specialities = implode(",",$request->specialities);

        $user->save();

        return redirect()->route('baker.register_step_4');
    }

    /*
    public function step_4()
    {
        return view('theme::store.baker/register_step_4');
    }
    */
    public function step_4(Request $request)
    {
        /*$user_id = null;
        if ($request->has('id')) {
            $user_id = $request->input('id');
        }

        if (empty($user_id)){
            return redirect()->route('store.register');
        }

        $user = User::where([
            ['id',$user_id],
        ])->first();

        Auth::login($user);*/

        return view('theme::store.baker.register_step_4');
    }
}
