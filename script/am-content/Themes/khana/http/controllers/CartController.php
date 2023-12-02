<?php

namespace Amcoders\Theme\khana\http\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\category;
use App\Terms;
use Cart;
use Session;
use Carbon\Carbon;
use App\Package;
use App\PackageItem;
use App\AddonItems;
use Exception;

/**
 *
 */
class CartController extends controller
{
    public function addon_add_to_cart(Request $request)
    {
        $single_product = Terms::with('price')->find($request->main_product);
        $cart = Cart::instance('cart_'.$request->store_slug)->add($single_product->id, $single_product->title, $request->qty_value, $single_product->price->price, 550, ['type'=>'Regular']);
        Cart::instance('cart_'.$request->store_slug)->setGlobalTax(total_tax());

        if ($request->addon) {
            foreach ($request->addon as $value) {
                $product = Terms::with('price')->find($value);
                Cart::instance('cart_'.$request->store_slug)->add($product->id, $product->title, 1, $product->price->price, 550, ['type'=>'Addon','note'=>$request->special_note]);
            }
        }


        Session::put('restaurant_cart', [
            'count' => Cart::instance('cart_'.$request->store_slug)->count(),
            'slug' => $request->store_slug
        ]);


        return response()->json('ok');
    }

    public function add_to_cart(Request $request)
    {
        $product = Terms::with('price')->where('slug', $request->slug)->first();
        $cart = Cart::instance('cart_'.$request->store_slug)->add($product->id, $product->title, 1, $product->price->price, 550, ['type'=>'Regular']);
        Cart::instance('cart_'.$request->store_slug)->setGlobalTax(total_tax());

        Session::put('restaurant_cart', [
            'count' => Cart::instance('cart_'.$request->store_slug)->count(),
            'slug' => $request->store_slug
        ]);

        return "ok";
    }

    public function update(Request $request)
    {
        Cart::instance('cart_'.$request->store_slug)->update($request->id, $request->data_value);
        Session::put('restaurant_cart', [
            'count' => Cart::instance('cart_'.$request->store_slug)->count(),
            'slug' => $request->store_slug
        ]);
        return "ok";
    }

    public function delete(Request $request)
    {
        Cart::instance('cart_'.$request->store_slug)->remove($request->id);
        Session::put('restaurant_cart', [
            'count' => Cart::instance('cart_'.$request->store_slug)->count(),
            'slug' => $request->store_slug
        ]);
        return "ok";
    }

    public function discount(Request $request)
    {
        $check=Terms::where('title', $request->code)->where('auth_id', Session::get('restaurant_id')['id'])->where('type', 10)->first();

        $mydate= Carbon::now()->toDateString();
        if (!empty($check)) {
            if ($check->slug >= $mydate) {
                $dicountPercent=$check->count;
                $total=Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->subtotal();

                Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->setGlobalDiscount($check->count);

                Session::put('coupon', [
                   'id' => $check->id,
                   'percent' => $check->count
                ]);
                $total=Cart::instance('cart_'.Session::get('restaurant_cart')['slug'])->subtotal();
                return response()->json(['message'=>'Coupon Successfully Applied','amount'=>$total]);
            } else {
                return response()->json(['error'=>'Coupon Expired',401]);
            }
        } else {
            return response()->json(['error'=>'Invalid Coupon',401]);
        }
    }

    public function cartview(Request $request)
    {

        $restaurant = Session::get('restaurant_id');
        $restaurant_id = $restaurant['id'];
        $packages = $request->package_id;
        $addon_ids = $request->addon_ids;
        $selected_item_id = $request->selected_item_id_arr;

        $dataItems = array();

        if (isset($selected_item_id) && count($selected_item_id) > 0) {
            foreach ($selected_item_id as $pack_id) {
                $PackageItem = new PackageItem();
                $packages1 = $PackageItem->select('id', 'name')->where('id', $pack_id)->get()->toArray();
                // print_r($packages1 );

                if(!empty($packages1)){
                    $packageitem_id = $packages1[0]['id'];
                    $packageitem_name = $packages1[0]['name'];
                   $dataItems[] = array('id' => $packageitem_id, 'name' => $packageitem_name, 'qty'=>1, 'package_id'=>$packages[0]);
                }
            }
            Session::put('package_item_data', $dataItems);
        }

        if (isset($packages) && count($packages) > 0) {
            foreach ($packages as $pack_id) {
                $package = new Package();
                $packages = $package->select('id', 'name', 'description', 'price', 'halal_status', 'slug')->where('id', $pack_id)->get()->toArray();
                $package_id = $packages[0]['id'];
                $package_name = $packages[0]['name'];
                $package_price = $packages[0]['price'];
               
                Cart::instance('multi_cart')->add([
                    ['id' => $package_id, 'name' => $package_name, 'qty' => 1, 'price' => $package_price, 'weight' => 550]
                ]);
                Session::put('multi_cart_data', [
                    ['id' => $package_id, 'name' => $package_name, 'qty' => 1, 'price' => $package_price, 'weight' => 550]
                ]);
            }
        }
        // echo '<pre>';print_r($addon_ids);exit;
        if (isset($addon_ids) && count($addon_ids) > 0) {
            $AddonItems = new AddonItems();
            $addon_ids_text = implode(',', $addon_ids);
            $addon_items = $AddonItems->select('id', 'user_id', 'name', 'price')
              ->whereIn('id', $addon_ids)
              ->where('deleted', 0)
              ->get()->toArray();
            if (isset($addon_items) && count($addon_items) > 0) {
                foreach ($addon_items as $addon_row) {
                    $addon_id = $addon_row['id'];
                    $addon_name = $addon_row['name'];
                    $addon_price = $addon_row['price'];
                    Cart::instance('multi_cart')->add([
                        ['id' => $addon_id, 'name' => $addon_name, 'qty' => 1, 'price' => $addon_price, 'weight' => 550, 'options' => ['addon_id' => $addon_id]]
                    ]);
                    Session::put('multi_cart_data', [
                        ['id' => $addon_id, 'name' => $addon_name, 'qty' => 1, 'price' => $addon_price, 'weight' => 550, 'options' => ['addon_id' => $addon_id]]
                    ]);
                }
            }
        }

        Session::put('cart_details', [
            'selected_package_id' => $request->package_id,
            'selected_addon_ids' => $request->addon_ids
        ]);
        return true;
    }

    public function cartlist(Request $request)
    {
        $test = Session::get("multi_cart_data");

        $cart_details = Cart::instance('multi_cart')->content();

        // print_r($cart_details);

         // print_r(count($cart_details) );

        $package = new Package();
        $AddonItems = new AddonItems();

        $packages = array();
        if (isset($cart_details) && count($cart_details) > 0) {
            foreach ($cart_details as $row) {
                $row = (array) $row;
                $qty = $row['qty'];
                $options =  json_decode($row['options'], true);
                if (isset($options) && count($options) > 0) {
                    //addon
                    $addon_id = $options['addon_id'];
                    $addon_items = $AddonItems->select('id', 'user_id', 'name', 'price')
                    ->where('id', $addon_id)
                    ->where('deleted', 0)
                    ->get()->toArray();

                    $package_details = $addon_items;
                    $package_details[0]['qty'] = $row['qty'];
                    $package_details[0]['total_price'] = $row['qty'] * $package_details[0]['price'];
                } else {
                    //package
                    $package_details = $package->select('id', 'name', 'description', 'price', 'halal_status', 'slug')->where('id', $row['id'])->get()->toArray();
                    $package_details[0]['qty'] = $row['qty'];
                    $package_details[0]['total_price'] = $row['qty'] * $package_details[0]['price'];
                }
                $packages[] = $package_details;
            }
        }

        $package_count = count($packages);
        $addon_items = array();
        $addon_total_amount = 0;
        return view('theme::cartview.cartview', compact('cart_details', 'packages', 'addon_items', 'addon_total_amount', 'package_count'));
    }

    public function calculatecart(Request $request)
    {
        try {
            $package_id = $request->package_id;
            $type = $request->type;
            $qty_value = 0;
            if(isset($request->qty_value)){
                $qty_value = $request->qty_value;
            }            
            $cart = Cart::instance('multi_cart')->content();
            $cart_items = json_decode($cart, true);
            if (isset($cart_items) && count($cart_items) > 0) {
                foreach ($cart_items as $rowId => $items_row) {
                    if ($items_row['id'] == $package_id) {
                        if ($type == 'add') {
                            $new_qty = $items_row['qty'] + 1;
                            Cart::instance('multi_cart')->update($rowId, $new_qty); // Will update the name
                        } else if($type == 'sub' ) {
                            if ($items_row['qty'] > 1) {
                                $new_qty = $items_row['qty'] - 1;
                                Cart::instance('multi_cart')->update($rowId, $new_qty); // Will update the name
                            } else {
                                $new_qty = $items_row['qty'] - 1;
                                if ($new_qty <= 0) {
                                    Cart::instance('multi_cart')->remove($rowId);
                                }
                            }
                        } else if($type == 'remove'){ 
                            Cart::instance('multi_cart')->remove($rowId);
                        } else if($type == 'quantity_direct_change'){
                            $new_qty = $qty_value;
                            Cart::instance('multi_cart')->update($rowId, $new_qty); // Will update the name
                        }
                    }
                }
            }
            return true;
        } catch(Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
