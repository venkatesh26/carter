<?php
namespace Amcoders\Theme\khana\http\controllers;

include(__DIR__.'/src/Twilio/autoload.php');

use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Support\Str;
use Cart;
use App\Order;
use App\Ordermeta;
use App\OrderDetails;
use Session;
use OneSignal;
use Amcoders\Plugin\Plugin;
use Carbon\Carbon;
use Amcoders\Plugin\Paymentgetway\http\controllers\PaypalController;
use Amcoders\Plugin\Paymentgetway\http\controllers\StripeController;
use Amcoders\Plugin\Paymentgetway\http\controllers\ToyyibpayController;
use Amcoders\Plugin\Paymentgetway\http\controllers\InstamojoController;
use Amcoders\Plugin\Paymentgetway\http\controllers\RazorpayController;
use Illuminate\Support\Facades\Mail;
use Amcoders\Plugin\contactform\Mail\OrderMail;
// use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends controller
{
    public function store(Request $request)
    {

	$cart_details = Session::get('package_item_data');

        if(!Session::has('restaurant_id') && Session::has('restaurant_cart'))
        {
            $data=Session::get('order_info');
            Order::destroy($data['ref_id']);
            return redirect()->route('author.dashboard')->with('error', 'Order Failed!');
        }
        $replace_total=str_replace(',', '', Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->subtotal());
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|numeric',
            'payment_method' => 'required',
        ]);

        if($request->order_type == 1)
        {
            $request->validate([
                'delivery_address' => 'required'
            ]);
        }

        if (isset($request->shipping)) {
            if ($request->shipping != "undefined") {
                $shipping=  str_replace(",","",number_format($request->shipping,2));
            }
            else{
                $shipping = 0;
            }
        }
        else{
            $shipping = 0;
        }

        $order = new Order();
        $order->user_id = Auth::id();
        // $order->user_id = 1;
        $order->vendor_id = Session::get('restaurant_id')['id'];
        $order->payment_method = $request->payment_method;
        $order->payment_status = 0;
        if (Session::has('coupon')) {
            $order->coupon_id = Session::get('coupon')['id'];
        }

        $order->order_type = $request->order_type;


        $order->total = $replace_total;
        if (!empty($request->shipping)) {
            $order->shipping = $shipping;
        }
        $order->discount = Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->discount();

        $data['name']=$request->name;
        $data['phone']=$request->phone;
        $data['address']=$request->delivery_address;
        $data['latitude']=$request->latitude;
        $data['longitude']=$request->longitude;
        $data['note']=$request->note;
        $data['payment_id']=null;

        $data['b_first_name']=$request->b_first_name;
        $data['b_last_name']=$request->b_last_name;
        $data['b_c_name']=$request->b_c_name;
        $data['b_address']=$request->b_address;
        $data['b_email']= $request->b_email;
        $data['b_phone']=$request->b_phone;
        $data['event_date']=$request->event_date;
        $data['flatno']=$request->flatno;
        $data['apartmentno']=$request->apartmentno;


        $order->data = json_encode($data);

        $order->total = $replace_total;
        $order->save();

        $totalValue = 0;

         // $cart_details = Cart::instance('multi_cart')->content();

         // print_r($cart_details);
         // $Test = Session::get("restaurant_cart");
         // print_r($Test);

         $cart_details = Session::get('package_item_data');


        foreach($cart_details as $key => $row) {
            $orderDetails = new OrderDetails();
            $orderDetails->order_id = $order->id;
            $orderDetails->product_id = $row["id"];
            $orderDetails->product_name = $row["name"];
            $orderDetails->qty = $row["qty"];
            $orderDetails->amount = 0;
            $orderDetails->total_amount = 0;
            $orderDetails->package_id = $row["package_id"];
            $orderDetails->save();
        }

        foreach (Cart::instance('multi_cart')->content() as $key => $row) {

            $ordermeta = new Ordermeta;
            $ordermeta->order_id = $order->id;
            $ordermeta->term_id  = $row->id;
            $ordermeta->qty  = $row->qty;
            $ordermeta->total  = $row->price;
            $ordermeta->save();
            $totalValue += $row->price * $row->qty;
        }
        $order->total = $totalValue;
        $order->save();


        $data['amount']=$replace_total + $shipping;
        $data['currency']=currency_name();

        $currency=currency_name();
        $total=$replace_total + $shipping;

        $data['ref_id']=$order->id;
        $data['vendor_id']=$order->vendor_id;
        $data['amount']= str_replace(",","",number_format($total,2));

        $data['amount']= $totalValue;
        $data['email']=Auth::user()->email;
        $data['name']=Auth::user()->name;

        // $data['email']= "test@customer.in";
        // $data['name']= "GV";

        $data['phone']=$request->phone;
        $data['billName']="payment for order";
        $data['currency']=$currency;

        //$info = Order::with('orderlist','vendorinfo','coupon')->where('vendor_id',$order->vendor_id)->findorFail($order->id);
         
         $data['orderDetails']= Cart::instance('multi_cart')->content();;

         Session::put('order_info',$data);
        // }



       Session::forget('restaurant_id');
       Session::forget('cart_'.Session::get('restaurant_cart')['slug']);
       Session::forget('cart');
       Session::forget('coupon');
       Session::forget('delivery_type');



       // if ($request->payment_method=='paypal') {
       //     try {
       //          return PaypalController::make_payment($data);
       //     } catch (\Throwable $th) {
       //          $order->delete();
       //          return redirect()->route('author.dashboard')->with('error', 'Transaction Failed');
       //     }

       // }

       if ($request->payment_method=='stripe') {
            return redirect('payment-with/stripe');
       }

       // if ($request->payment_method=='toyyibpay') {
       // return ToyyibpayController::make_payment($data);

       // }

       // if ($request->payment_method=='razorpay') {

       //      return redirect('payment-with/razorpay');
       // }

       // if ($request->payment_method=='instamojo') {
       //      try {
       //          return InstamojoController::make_payment($data);
       //      } catch (\Throwable $th) {
       //          $order->delete();
       //          return redirect()->route('author.dashboard')->with('error', 'Transaction Failed');
       //      }
       // }
       return redirect('order/confirmation');
    }

    public function stripe_view()
    {
      return view('theme::checkout.payment.stripe');
    }

    public function razorpay_view()
    {
        if(Session::has('order_info'))
        {
            $data=Session::get('order_info');
            try {

                $response=RazorpayController::make_payment($data);
                return view('theme::checkout.payment.razorpay',compact('response'));
            } catch (\Throwable $th) {
                Order::destroy($data['ref_id']);
                return redirect()->route('author.dashboard')->with('error', 'Transaction Failed');
            }
        }
    }

    public function stripe(Request $request)
    {

        if (Session::has('order_info')) {
           $data=Session::get('order_info');
           $data['stripeToken']=$request->stripeToken;
          return StripeController::make_payment($data);
        }

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
            $auth_id=Auth::id();
            $info = Order::with('orderlist','vendorinfo','coupon')->where('vendor_id',$order->vendor_id)->findorFail($order->id);
            $customer_info=json_decode($info->data);
            $vendor_info=json_decode($info->vendorinfo->info->content);
            $orderdetails = OrderDetails::where('order_id',$order->id)->get()->toArray();

            $pdf = \PDF::loadView('plugin::order.invoice',compact('info','customer_info','vendor_info','orderdetails'));

            // $pdf->setPaper('A4', 'landscape');

            $pdf->save(storage_path('invoice'.$order->id.'.pdf'));

            $data = [
                'info' => $info,
                'customer_info' => $customer_info,
                'vendor_info' => $vendor_info,
                'orderdetails' => $orderdetails,
                'file' => url('/script/storage/invoice'.$order->id.'.pdf')
            ];
            // print_r($data);
            // exit;
            // echo "<br>";
            // print_r($customer_info->b_email);
            // echo "<br>";
            // exit;
            Mail::to($customer_info->b_email)->send(new OrderMail($data));
            Mail::to($vendor_info->email1)->send(new OrderMail($data));
            
            $sid    = "AC6224148441cdc67cfcd0bcfd41c020a1";
            $token  = "2fcd00a5123822969e28a89af7fa1d06";
            $twilio = new Client($sid, $token);

            $SmsContent = "Hello ".$info->vendorinfo->first_name.",\nYour have received new order.";
            $SmsContent .= "\nInvoice No: 100".$order->id;
            $SmsContent .= "\nOrder Link: ".url("store/order/".$order->id);


            // 447899357632
             // 
            $message = $twilio->messages
              ->create("+44".$vendor_info->phone1,
                       array(
                           "messagingServiceSid" => "MG04b2798791e0687a740192bae18bf795",
                           "body" =>$SmsContent
                       )
              );

             return redirect('order/confirmation/'.$order->id);
        }
        Session::forget('payment_info');
        Session::forget('order_info');

        abort(404);

    }

    public function payment_fail(Request $request)
    {
        if (Session::has('payment_info')) {
            $payment_info= Session::get('payment_info');
            $order_id=$payment_info['ref_id'];
            Order::destroy($order_id);
            Session::forget('payment_info');
        }
        if (Session::has('order_info')) {
            $data= Session::get('order_info');
            $order_id=$data['ref_id'];
            Order::destroy($order_id);
            Session::forget('order_info');
        }

        return redirect()->route('author.dashboard')->with('error', 'Transaction Failed');

    }
}
