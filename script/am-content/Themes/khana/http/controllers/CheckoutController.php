<?php

namespace Amcoders\Theme\khana\http\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Session;
use Cart;
use App\Order;
use App\Ordermeta;
use App\OrderDetails;
use App\Options;
use Auth;
use OneSignal;
use Amcoders\Plugin\Plugin;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Carbon\Carbon;


class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if(Session::has('restaurant_id') && Session::has('restaurant_cart'))
        {
            if(!Auth::check())
            {
                return redirect('user/login');
            }

            $resturent_info=User::with('resturentlocation','info')->find(Session::get('restaurant_id')['id']);
            $json=json_decode($resturent_info->info->content);


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

            return view('theme::checkout.index',compact('resturent_info','json','currency','ordertype','km_rate','credentials'));
        }else{
            return back();
        }

    }

    public function type(Request $request)
    {

    	if($request->id == 1)
    	{
    		Session::put('delivery_type',[
    			'type' => 1
    		]);
            return "delivery";
    	}

        if($request->id == 0)
        {
            Session::put('delivery_type',[
                'type' => 0
            ]);
            return "pickup";
        }


    }


    public function CreateOrder(Request $request)
    {

        $replace_total=str_replace(',', '', Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->subtotal());
        if (isset($request->shipping)) {
         if ($request->shipping != "undefined") {
            $shipping=$request->shipping;
          }
          else{
            $shipping=0;
          }
        }
        else{
            $shipping=0;
        }

        $order=new Order;
        if($request->payment_type == 'stripe')
        {
            $currency=Options::where('key','currency_name')->first();
            try {
                $charge = Stripe::charges()->create([
                    'amount' => $replace_total+$shipping,
                    'currency' => $currency->value,
                    'source' => $request->stripeToken,
                    'description' => 'New Order',
                    'receipt_email' => Auth::User()->email,
                    'metadata' => [
                        'quantity' => 1,
                    ],
                ]);


            } catch (Exception $e) {
                return back();
            }
        }

        if(!Auth::check())
        {
            Session::put('user_login',[
                'status' => true
            ]);
            if($request->ajax())
            {
                return "auth_error";
            }else{
                return redirect('user/login');
            }

        }



        $data['name']=$request->name;
        $data['phone']=$request->phone;
        $data['address']=$request->delivery_address;
        $data['latitude']=$request->latitude;
        $data['longitude']=$request->longitude;
        $data['note']=$request->order_note;
        if($request->payment_type == 'bank')
        {
            $data['image']=$image_path;
        }


        $order->user_id = Auth::id();
        $order->vendor_id = Session::get('restaurant_id')['id'];
        $order->payment_method = $request->payment_type;
        if($request->payment_type == 'cod')
        {
            $order->payment_status = 0;
        }else{
             $order->payment_status = 1;
        }

        if (Session::has('coupon')) {
           $order->coupon_id = Session::get('coupon')['id'];
        }

        if(Session::has('delivery_type'))
        {
            $order->order_type = Session::get('delivery_type')['type'];
        }else{
            $order->order_type = 1;
        }
        $order->total = $replace_total;
        if (!empty($request->shipping)) {
            $order->shipping = $shipping;
        }
        $order->discount = Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->discount();
        $order->data = json_encode($data);
        $order->save();

        foreach (Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->content() as $key => $row) {
            $ordermeta = new Ordermeta;
            $ordermeta->order_id = $order->id;
            $ordermeta->term_id  = $row->id;
            $ordermeta->qty  = $row->qty;
            $ordermeta->total  = $row->price;
            $ordermeta->save();


            $orderDetails = new OrderDetails();
            $orderDetails->order_id = $order->id;
            $orderDetails->product_id = $row->id;
            $orderDetails->product_name = $row->name;
            $orderDetails->qty = $row->qty;
            $orderDetails->amount = 0;
            $orderDetails->total_amount = 0;
            $orderDetails->save();
        }
        // $cart_details = Session::get('package_item_data');

        // print_r($cart_details);

        // foreach($cart_details as $key => $row) {
        //     $orderDetails = new OrderDetails();
        //     $orderDetails->order_id = $order->id;
        //     $orderDetails->product_id = $row->id;
        //     $orderDetails->product_name = $row->name;
        //     $orderDetails->qty = $row->qty;
        //     $orderDetails->amount = 0;
        //     $orderDetails->total_amount = 0;
        //     $orderDetails->save();
        // }
        // exit;
        if (Plugin::is_active('WebNotification')) {
            $vendors=\App\Onesignal::where('user_id',Session::get('restaurant_id')['id'])->latest()->take(2)->get();
            foreach ($vendors as $key => $row) {

                OneSignal::sendNotificationToUser("New Order",$row->player_id,url('/store/order/'.$order->id));
            }
       }

       Session::forget('restaurant_id');
       Session::forget('cart_'.Session::get('restaurant_cart')['slug']);
       Session::forget('cart');
       Session::forget('coupon');
       Session::forget('delivery_type');

        // $auth_id=Auth::id();
        // $info = Order::with('orderlist','vendorinfo','coupon')->where('vendor_id',$auth_id)->findorFail($order->id);
        // $customer_info=json_decode($info->data);
        // $vendor_info=json_decode($info->vendorinfo->info->content);
        // $orderdetails = OrderDetails::where('order_id',$order->id)->get()->toArray();

        // $pdf = \PDF::loadView('plugin::order.invoice',compact('info','customer_info','vendor_info','orderdetails'));

        // $pdf->save(storage_path('pdf/order/invoice'.$order->id.'.pdf'));

       if($request->payment_type == 'cod')
       {
            return "order Created";
       }else{
            return redirect('order/confirmation/'.$order->id);
       }

    }

    public function confirmation()
    {
        return view('theme::checkout.confirm');
    }
    public function confirmation1(Request $request,$id)
    {
        $auth_id=Auth::id();
        $info = Order::with('orderlist','vendorinfo','coupon')->findorFail($id);
        $customer_info=json_decode($info->data);
        $vendor_info=json_decode($info->vendorinfo->info->content);
        $orderdetails = OrderDetails::where('order_id',$id)->get()->toArray();
        $Ordermeta  =  Ordermeta::where('order_id',$id)->get()->toArray();
        // print_r($orderdetails);

        $data = [
            'info' => $info,
            'customer_info' => $customer_info,
            'vendor_info' => $vendor_info,
            'orderdetails' => $orderdetails,
            'ordermeta' => $Ordermeta
        ];
        // print_r($data);
        
        return view('theme::checkout.confirm', $data);
    }
}
