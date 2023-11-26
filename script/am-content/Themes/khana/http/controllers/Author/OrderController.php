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
		// $info=Order::where('user_id',Auth::id())->with('orderlist','vendorinfo','riderinfo','coupon','orderlog','riderlog','liveorder')->find($order_id);
		// if (empty($info)) {
		// 	abort(404);
		// }
		$orderdetails = OrderDetails::where('order_id',$id)->get()->toArray();

		$info = Order::with('orderlist','vendorinfo','coupon','orderlog')->find($id);
		if (empty($info)) {
			abort(404);
		}
		return view('theme::author.orderdetails',compact('info', 'orderdetails'));
	}
}
