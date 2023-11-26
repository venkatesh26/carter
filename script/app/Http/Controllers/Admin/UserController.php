<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $info = User::find(Auth::id());

        return view('admin.settings.my_settings', compact('info'));
    }
    public function genUpdate(Request $request)
    {
        $request->validate([
            'file' => 'image',
            'email' => 'required|max:100|email|unique:users,email,' . Auth::id(),
            'name' => 'required',
        ]);

        $info = User::find(Auth::id());
        if ($request->file) {

            $imageName = date('dmy') . time() . '.' . request()->file->getClientOriginalExtension();
            request()->file->move('uploads/', $imageName);
            $avatar = 'uploads/' . $imageName;

            if (file_exists($info->avatar)) {
                unlink($info->avatar);
            }
        } else {
            $avatar = $info->avatar;
        }

        $user = User::find(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $avatar;
        $user->save();



        return response()->json(['Update Success']);
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        $info = User::where('id', Auth::id())->first();

        $check = Hash::check($request->current, auth()->user()->password);

        if ($check == true) {
            User::where('id', Auth::id())->update(['password' => Hash::make($request->password)]);


            return response()->json(['Password Changed']);
        } else {

            return Response()->json(array(
                'message'   =>  "Enter Valid Password"
            ), 401);
        }
    }

    public function profile()
    {
        $info = User::find(Auth::id());
        // $user_slug_data = User::where('slug',$user_slug)->first();
        // echo '<pre>';print_r($info);exit;
        return view('admin.settings.my_profile', compact('info'));
    }

    public function updateprofile(Request $request)
    {
        try {
            $user = User::where('id', Auth::id())->first();
            
            // $user = new User();
            $user->first_name = trim($request->first_name);
            $user->last_name = trim($request->last_name);
            $user->dob = date("Y-m-d", strtotime($request->dob));
            // $user_name = $user->first_name." ".$user->last_name;

            $upload_path = 'uploads/register/';

            $business_logo_file = $user->business_logo_file;
            $file = $request->file('business_logo_file');
            
            if (isset($file)) {
                $curentdate = Carbon::now()->toDateString();                
                $imagename =  $curentdate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();                
                $file->move($upload_path, $imagename);                
                $business_logo_file = $upload_path.$imagename;
            }
            $user->business_disp_name = trim($request->business_disp_name);
            $user->business_logo_file = $business_logo_file;
            $user->business_desc = trim($request->business_desc);
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
                // $registered_fsa_file = null;
                $registered_fsa_file = $user->registered_fsa_file;
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
                // $hygiene_certificate_file = null;
                $hygiene_certificate_file = $user->hygiene_certificate_file;

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

            $updated = $user->save();
            if ($updated == true) {
                //return response()->json(['Profile Updated']);
                $info = User::find(Auth::id());
                return redirect('myprofile');

                // return redirect('myprofile');

            } else {
                 return redirect('myprofile');
                // return Response()->json(array(
                //     'message'   =>  "Enter Valid Password"
                // ), 401);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function view()
    {
        $info = User::find(Auth::id());
        return view('admin.settings.my_view', compact('info'));
    }
}
