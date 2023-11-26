<?php

namespace Amcoders\Plugin\shop\http\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Auth;
use App\Terms;
use App\Productmeta;
use App\AddonItems;
use Exception;

/**
 *
 */
class AddonProductController extends controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $auth_id = Auth::id();

            if ($request->src) {
                $posts = AddonItems::where('user_id', $auth_id)->where('title', 'LIKE', '%' . $request->src . '%')->latest()->paginate(20);
            } elseif ($request->st) {
                if ($request->st == 'trash') {
                    $posts = AddonItems::where('user_id', $auth_id)->where('deleted', 0)->latest()->paginate(20);
                    $status = $request->st;
                    return view('plugin::addon-product.index', compact('posts', 'auth_id', 'deleted'));
                } else {
                    $posts = AddonItems::where('user_id', $auth_id)->where('deleted', $request->st)->latest()->paginate(20);
                    $status = $request->st;
                    return view('plugin::addon-product.index', compact('posts', 'auth_id', 'deleted'));
                }
            } else {
                $posts = AddonItems::where('user_id', $auth_id)->latest()->where('deleted', '=', 0)->paginate(20);
            }
            $status = 1;


            $posts = AddonItems::where('deleted', '=', 0)->where('user_id', $auth_id)->latest()->paginate(20);
            return view('plugin::addon-product.index', compact('posts', 'auth_id', 'status'));
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plugin::addon-product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_id = Auth::id();
        $categoryItems = $request["item"];
        foreach ($categoryItems as $k => $val) {
            foreach ($val['name'] as $key => $addon_name) {
                $addon_price = $val['price'][$key];
                $addon_description = $val['description'][$key];
                $row = AddonItems::where('name', '=', $addon_name)->where('user_id', "=", $auth_id)->first();
                if (empty($row)) {
                    $row = new AddonItems;
                    $row->name = $addon_name;
                    $row->price = $addon_price;
                    $row->description = $addon_description;
                    $row->user_id = $auth_id;
                    $row->save();
                } else {
                    $row->name = $addon_name;
                    $row->price = $addon_price;
                    $row->description = $addon_description;
                    $row->user_id = $auth_id;
                    $row->save();
                }
            }
        }
        // return response()->json(['Addon Product Created']);
        $posts = AddonItems::where('user_id', $auth_id)->latest()->where('deleted', '=', 0)->paginate(20);
        $status = 1;
        return view('plugin::addon-product.index', compact('posts', 'auth_id', 'status'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $info = AddonItems::where('user_id', Auth::id())->find($id);
        // echo '<pre>';print_r($info);exit;
        return view('plugin::addon-product.edit', compact('info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $validatedData = $request->validate([
        //     'title' => 'required|max:100',

        // ]);
        // $post = AddonItems::find($id);
        // $post->price = $request->price;
        $auth_id = Auth::id();
        // $post->status = $request->status;
        // $post->save();


        $product = AddonItems::where('id', $id)->first();
        //print_r($request["item"]); die;
        $name = $request["item"][1]['name'][1];
        $price = $request["item"][1]['price'][1];
        $description = $request["item"][1]['description'][1];
        if (!empty($product)) {
            $product->name = $name;
            $product->price = $price;
            $product->description = $description;
            $product->modified_at = date('Y-m-d H:i:s');
            $product->save();
        }
        // return response()->json(['Product Updated']);
        $posts = AddonItems::where('user_id', $auth_id)->latest()->where('deleted', '=', 0)->paginate(20);
        $status = 1;
        return view('plugin::addon-product.index', compact('posts', 'auth_id', 'status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        if ($request->status == 'publish') {
            if ($request->ids) {

                foreach ($request->ids as $id) {
                    $post = Terms::find($id);
                    $post->status = 1;
                    $post->save();
                }
            }
        } elseif ($request->status == 'trash') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    $post = Terms::find($id);
                    $post->status = 0;
                    $post->save();
                }
            }
        } elseif ($request->status == 'delete') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    Terms::destroy($id);
                }
            }
        }
        return response()->json('Success');
    }
}
