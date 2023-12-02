<?php

namespace Amcoders\Theme\khana\http\controllers\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Auth;
use App\OrderDetails;

class OrderController extends Controller
{
	public function details($id)
	{
		$id = decrypt($id);
		$orderdetails = OrderDetails::where('order_id',$id)->get()->toArray();
        $info = Order::with('orderlist', 'orderlistpack','vendorinfo','coupon','orderlog')->find($id);
/*        echo "<pre>";
        print_r($info->toArray());die;*/
		if (empty($info)) {
			abort(404);
		}
		return view('theme::author.orderdetails',compact('info', 'orderdetails'));
	}
}
