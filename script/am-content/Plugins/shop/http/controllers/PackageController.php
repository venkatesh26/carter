<?php

namespace Amcoders\Plugin\shop\http\controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Auth;
use App\Media;
use App\Terms;
use App\Meta;
use App\PostCategory;
use App\Productmeta;
use App\Addon;
use App\Shopday;
use App\Location;
use App\Usermeta;
use App\Usercategory;
use App\User;
use App\Onesignal;
use App\Options;
use App\Category;
use App\Package;
use App\PackageCategory;
use App\PackageItem;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Storage;
/**
 *
 */
class PackageController extends controller
{

    public function index(Request $request)
    {
        $auth_id=Auth::id();
        $packages = Package::with('packageItems')->where('user_id',$auth_id)->latest()->paginate(20);
        return view('plugin::package.index',compact('packages','auth_id'));

    }

    public function create()
    {
        $auth_id=Auth::id();
        $category = new Category();
        $package = new Package();
        $packageItem = new PackageItem();

        $categories = $category->select('id', 'name')->where('user_id',$auth_id)->get()->toArray();

        $packages = $package->select('id', 'name')->where('user_id',$auth_id)->get()->toArray();
        $packageItems = [];
        if (count($packages) > 0) {
            $packageIds = array_column($packages, "id");
            $packageItems = $packageItem->select('id', 'package_id', 'name', 'description', 'mild', 'hot', 'extra_hot', 'none')->whereIn('package_id', $packageIds)->get()->toArray();
        }
        return view('plugin::package.create',compact('categories', 'packages', 'packageItems'));
    }

    public function store(Request $request)
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'description' => 'required',
        //     'price' => 'numeric|min:1',
        //     'category_name' => 'required',
        //     'no_of_item' => 'numeric|min:1'
        // ]);
        $categoryCheck = new Category();

        $authId = Auth::id();

        $halal_value = isset($request->halal) ? 1 : 0;
        $package_name_url = $this->slugify(trim($request->name));

        $row = new Package;
        $row->user_id = $authId;
        $row->name = $request->name;
        $row->description = htmlentities($request->description);
        $row->price = $request->price;
        $row->halal_status = $halal_value;
        $row->slug = $package_name_url;
        $row->status = $request->status;
        $row->save();
        $packageId = $row->id;

        foreach($request->category_name as $k => $postVal) {
            $categoryName = $request["category_name"][$k];
            $noOfItems = $request["no_of_items"][$k];
            $categoryItems = $request["item"][$k];
            
            $categoriesCount = $categoryCheck->select('id', 'name')->where('user_id',$authId)->get()->toArray();
            
            $cateSlug = (count($categoriesCount)>0)?(count($categoriesCount)+1):"";
            $row = new Category;
            $row->name = $categoryName;
            $row->slug = Str::slug($categoryName).$cateSlug;
            $row->type = 1;
            $row->status = 0;
            $row->user_id = $authId;
            $row->save();

            // if (empty($row)) {
            //     $row = new Category;
            //     $row->name = $categoryName;
            //     $row->slug = Str::slug($categoryName);
            //     $row->type = 1;
            //     $row->status = 0;
            //     $row->user_id = $authId;
            //     $row->save();
            // } else {
            //     $row->name = $categoryName;
            //     $row->slug = Str::slug($categoryName);
            //     $row->type = 1;
            //     $row->status = 0;
            //     $row->user_id = $authId;
            //     $row->save();
            // }

            $categoryId = $row->id;

            
            
            if (!empty($categoryId)) {
                $row = Package::where('name', '=', $request->name)->where('user_id', "=", $authId)->first();

                // if (empty($row)) {
                //     $row = new Package;
                //     $row->user_id = $authId;
                //     $row->name = $request->name;
                //     $row->description = htmlentities($request->description);
                //     $row->price = $request->price;
                //     $row->halal_status = $halal_value;
                //     $row->slug = $package_name_url;
                //     $row->status = $request->status;
                //     $row->save();
                // } else {
                //     $row->user_id = $authId;
                //     $row->name = $request->name;
                //     $row->description = htmlentities($request->description);
                //     $row->price = $request->price;
                //     $row->halal_status = $halal_value;
                //     $row->slug = $package_name_url;
                //     $row->status = $request->status;
                //     $row->save();
                // }

                

                if ($packageId && $categoryId) {

                    //  $row = new PackageCategory;
                    // $row->package_id = $packageId;
                    // $row->category_id = $categoryId;
                    // $row->no_of_items = $noOfItems;
                    // $row->user_id = $authId;
                    // $row->save();

                    $row = PackageCategory::where('user_id', '=', $authId)->where('package_id', "=", $packageId)->where('category_id', "=", $categoryId)->where('no_of_items', '=', $noOfItems)->first();
                    if (empty($row)) {
                        $row = new PackageCategory;
                        $row->package_id = $packageId;
                        $row->category_id = $categoryId;
                        $row->no_of_items = $noOfItems;
                        $row->user_id = $authId;
                        $row->save();
                    } else {
                        $row->package_id = $packageId;
                        $row->category_id = $categoryId;
                        $row->no_of_items = $noOfItems;
                        $row->deleted = 0;
                        $row->save();
                    }
                  
                }

                $packageCategoryId = $row->id;

                if ($packageId && $packageCategoryId) {
                    $pItems = $categoryItems["name"];
                    $pDescription = $categoryItems["description"];
                    $pSpicy = $categoryItems["spicy"];
                    foreach ($pItems as $k => $item) {
                        if (!empty($pItems[$k])) {
                            $row = PackageItem::where('user_id', '=', $authId)->where('package_id', "=", $packageId)->where('package_category_id', "=", $packageCategoryId)->where('name', "=", $pItems[$k])->first();
                            if (empty($row)) {
                                $row = new PackageItem;
                                $row->user_id = $authId;
                                $row->package_id = $packageId;
                                $row->package_category_id = $packageCategoryId;
                                $row->name = $pItems[$k];
                                $row->description = $pDescription[$k];
                                $row->mild = (isset($pSpicy[$k]) && $pSpicy[$k] == "mild") ? 1 : 0 ;
                                $row->hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "hot") ? 1 : 0 ;
                                $row->extra_hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "extra_hot") ? 1 : 0 ;
                                $row->none = (isset($pSpicy[$k]) && $pSpicy[$k] == "none") ? 1 : 0 ;
                                $row->save();

                                $post=new Terms;
                                $post->title= $pItems[$k];
                                $post->slug= Str::slug($pItems[$k]);;
                                $post->type=6;
                                $post->auth_id= $authId;
                                $post->status= 1;
                                $post->save();

                            } else {
                                $row->package_id = $packageId;
                                $row->package_category_id = $packageCategoryId;
                                $row->name = $pItems[$k];
                                $row->description = $pDescription[$k];
                                $row->mild = (isset($pSpicy[$k]) && $pSpicy[$k] == "mild") ? 1 : 0 ;
                                $row->hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "hot") ? 1 : 0 ;
                                $row->extra_hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "extra_hot") ? 1 : 0 ;
                                $row->none = (isset($pSpicy[$k]) && $pSpicy[$k] == "none") ? 1 : 0 ;
                                $row->deleted = 0;
                                $row->save();

                                $post=new Terms;
                                $post->status= 0;
                                $post->save();
                            }

                            // $row = new PackageItem;
                            // $row->user_id = $authId;
                            // $row->package_id = $packageId;
                            // $row->package_category_id = $packageCategoryId;
                            // $row->name = $pItems[$k];
                            // $row->description = $pDescription[$k];
                            // $row->mild = (isset($pSpicy[$k]) && $pSpicy[$k] == "mild") ? 1 : 0 ;
                            // $row->hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "hot") ? 1 : 0 ;
                            // $row->extra_hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "extra_hot") ? 1 : 0 ;
                            // $row->none = (isset($pSpicy[$k]) && $pSpicy[$k] == "none") ? 1 : 0 ;
                            // $row->save();

                            // $post=new Terms;
                            // $post->title= $pItems[$k];
                            // $post->slug= Str::slug($pItems[$k]);;
                            // $post->type=6;
                            // $post->auth_id= $authId;
                            // $post->status= 1;
                            // $post->save();

                        }
                    }
                }
            }
        }
        return redirect()->route('store.package.index');
    }

    public function show(Request $request, $id)
    {
        $auth_id=Auth::id();

        $category = new Category();
        $package = new Package();
        $packageCategory = new PackageCategory();
        $packageItem = new PackageItem();

        $categories = $category->select('id', 'name')->where('user_id',$auth_id)->get()->toArray();

        $packages = $package->select('id', 'name', 'description', 'price')->where('id',$id)->where('user_id',$auth_id)->get()->toArray();
        $packageCategories = [];
        $packageItems = [];
        if (count($packages) > 0) {
            $packageIds = array_column($packages, "id");
            $packageCategories = $packageCategory->select('id', 'package_id', 'category_id', 'no_of_items')->where('user_id',$auth_id)->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
            $packageItems = $packageItem->select('id', 'package_id', 'package_category_id', 'name', 'description', 'mild', 'hot', 'extra_hot', 'none')->where('user_id',$auth_id)->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
        }
        return view('plugin::package.show',compact('id', 'categories', 'packages', 'packageCategories', 'packageItems'));
    }

    public function edit(Request $request, $id)
    {

        $auth_id=Auth::id();

        $category = new Category();
        $package = new Package();
        $packageCategory = new PackageCategory();
        $packageItem = new PackageItem();

        $categories = $category->select('id', 'name')->where('user_id',$auth_id)->get()->toArray();

        $packages = $package->select('id', 'name', 'description', 'price', 'halal_status')->where('id',$id)->where('user_id',$auth_id)->get()->toArray();
        $packageCategories = [];
        $packageItems = [];
        if (count($packages) > 0) {
            $packageIds = array_column($packages, "id");
            $packageCategories = $packageCategory->select('id', 'package_id', 'category_id', 'no_of_items')->where('user_id',$auth_id)->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
            $packageItems = $packageItem->select('id', 'package_id', 'package_category_id', 'name', 'description', 'mild', 'hot', 'extra_hot', 'none')->where('user_id',$auth_id)->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();

            // print_r($packageCategories);
        }
        return view('plugin::package.edit',compact('id', 'categories', 'packages', 'packageCategories', 'packageItems'));

    }

    public function update(Request $request, $id)
    {
        $authId = Auth::id();

        $pcategory_name = $request->pcategory_name;
        $categoryCheck = new Category();
      
        $newItemsArr = array();

        // print_r($pcategory_name );
        // echo "<br><br>";
        // print_r($request->category_name);
        // echo "<br>";
        // exit;

        foreach($pcategory_name as $key=>$value1){
            PackageCategory::where('user_id', $authId)->where('package_id', "=", $id)->where('id', '=', $value1)->update(['deleted' => 0]);
        }
        foreach($request->category_name as $k => $postVal) {
            $categoryName = $request["category_name"][$k];
            $noOfItems = $request["no_of_items"][$k];
            $categoryItems = $request["item"][$k];
            $row = Category::where('id', '=', $k)->where('user_id', "=", $authId)->first();

            $categoriesCount = $categoryCheck->select('id', 'name')->where('user_id',$authId)->get()->toArray();
            $cateSlug = (count($categoriesCount)>0)?(count($categoriesCount)+1):"";

            if (empty($row)) {
                $row = new Category;
                $row->name = $categoryName;
                $row->slug = Str::slug($categoryName)."".$cateSlug;
                $row->type = 1;
                $row->status = 0;
                $row->user_id = $authId;
                $row->save();
            } else {
                $row->name = $categoryName;
                $row->slug = Str::slug($categoryName)."".$cateSlug;
                $row->type = 1;
                $row->status = 0;
                $row->user_id = $authId;
                $row->save();
            }

            $categoryId = $row->id;

            if (!empty($categoryId)) {
                $halal_value = isset($request->halal) ? 1 : 0;
                $row = Package::where('id', '=', $id)->first();
                if (!empty($row)) {
                    $row->user_id = $authId;
                    $row->name = $request->name;
                    $row->description = $request->description;
                    $row->price = $request->price;
                    $row->halal_status = $halal_value;
                    $row->status = $request->status;
                    $row->save();
                }

                $packageId = $row->id;

                if ($packageId && $categoryId) {

                    // echo $k."<br>";
                    // print_r($pcategory_name);
                    // exit;
                    PackageCategory::where('user_id', $authId)->where('package_id', "=", $packageId)->where('category_id', "=", $categoryId)->where('id', '=', $k)->update(['deleted' => 1]);
                    if(isset($pcategory_name[$k])){
                        $row = PackageCategory::where('user_id', '=', $authId)->where('package_id', "=", $packageId)->where('category_id', "=", $categoryId)->where('id', '=', $pcategory_name[$k])->first();
                    }else{
                        $row = "";
                    }

                    // print_r($row);
                    // echo "<br>";
                    // exit;
                    if (empty($row)) {
                        $row = new PackageCategory;
                        $row->package_id = $packageId;
                        $row->category_id = $categoryId;
                        $row->no_of_items = $noOfItems;
                        $row->user_id = $authId;
                        $row->save();
                    } else {
                        $row->package_id = $packageId;
                        $row->category_id = $categoryId;
                        $row->no_of_items = $noOfItems;
                        $row->user_id = $authId;
                        $row->deleted = 0;
                        $row->save();
                    }
                }

                $packageCategoryId = $row->id;

                $db_package_items_id = array();
                $package_items_row = PackageItem::where('user_id', $authId)->where('package_id', "=", $packageId)->where('deleted', "=", 0)->get();
                if(isset($package_items_row) && count($package_items_row) > 0){
                    foreach($package_items_row as $item_row){
                        $db_package_items_id[] = $item_row->id;
                    }
                }

                $ui_package_items_array = array();

            
                if ($packageId && $packageCategoryId) {
                    //$package_items_row = PackageItem::where('user_id', $authId)->where('package_id', "=", $packageId)->where('package_category_id', "=", $packageCategoryId)->update(['deleted' => 1]);
                    $pItems = $categoryItems["name"];
                    $pDescription = $categoryItems["description"];
                    $pSpicy = $categoryItems["spicy"];

                    $pItemId = isset($categoryItems["pItemId"])?$categoryItems["pItemId"]:array();

                    $ui_package_items_array = $pItemId;

                    $newItemsArr = array_merge($newItemsArr,$pItemId);
                   
                    // print_r($pItems);
                    //          echo "<br>";

                    foreach ($pItems as $k => $item) {

                        // if (!empty($pItems[$k])) {
                            
                            if(isset($pItemId[$k])){
                                $row = PackageItem::where('user_id', $authId)->where('package_id', "=", $packageId)->where('package_category_id', "=", $packageCategoryId)->where('id','=', $pItemId[$k])->first();
                            }else{
                                $row = "";
                            }
                          
                            if (empty($row)) {
                                $row = new PackageItem;
                                $row->user_id = $authId;
                                $row->package_id = (int)$packageId;
                                $row->package_category_id = $packageCategoryId;
                                $row->name = $pItems[$k];
                                $row->description = $pDescription[$k];
                                $row->mild = (isset($pSpicy[$k]) && $pSpicy[$k] == "mild") ? 1 : 0 ;
                                $row->hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "hot") ? 1 : 0 ;
                                $row->extra_hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "extra_hot") ? 1 : 0 ;
                                $row->none = (isset($pSpicy[$k]) && $pSpicy[$k] == "none") ? 1 : 0 ;
                                $row->deleted = 0;
                                $row->save();
                                $newItemsArr = array_merge($newItemsArr,array($row->id));
                            } else {
                                $row->package_id = (int)$packageId;
                                $row->package_category_id = $packageCategoryId;
                                $row->name = $pItems[$k];
                                $row->description = $pDescription[$k];
                                $row->mild = (isset($pSpicy[$k]) && $pSpicy[$k] == "mild") ? 1 : 0 ;
                                $row->hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "hot") ? 1 : 0 ;
                                $row->extra_hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "extra_hot") ? 1 : 0 ;
                                $row->none = (isset($pSpicy[$k]) && $pSpicy[$k] == "none") ? 1 : 0 ;
                                $row->deleted = 0;
                                $row->save();
                            }

                        // }
                    }
                }
            }
        }
        //delete removed items
        $removed_items_arr = array_diff($db_package_items_id,$newItemsArr);

        //  print_r($db_package_items_id);
        //  echo "<br>";
        //  print_r($newItemsArr);
        //  echo "<br>";
        // print_r($removed_items_arr);
        // echo "<br>";
        if(isset($removed_items_arr) && count($removed_items_arr) > 0){
            foreach($removed_items_arr as $package_item_id){
                PackageItem::where('user_id', $authId)->where('id', "=", $package_item_id)->update(['deleted' => 1]);
            }
        }
        // exit;
        return redirect()->route('store.package.index');
    }

    public function destroy(Request $request)
    {

        if ($request->status=='publish') {
            if ($request->ids) {

                foreach ($request->ids as $id) {
                    $post=Terms::find($id);
                    $post->status=1;
                    $post->save();
                }

            }
        }
        elseif ($request->status=='trash') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    $post=Terms::find($id);
                    $post->status=0;
                    $post->save();
                }

            }
        }
        elseif ($request->status=='delete') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                   Terms::destroy($id);

                }
            }
        }
        return response()->json('Success');

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

    public function deleteproductCat($id)
    {
        $authId = Auth::id();
        PackageCategory::where('user_id', $authId)->where('category_id', '=', $id)->update(['deleted' => 1]);
         return response()->json('Success');
    }
}
