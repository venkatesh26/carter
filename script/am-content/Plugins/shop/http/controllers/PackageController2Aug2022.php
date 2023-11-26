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
            $packageItems = $packageItem->select('id', 'package_id', 'name', 'description', 'mild', 'hot', 'extra_hot')->whereIn('package_id', $packageIds)->get()->toArray();
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

        $authId = Auth::id();

        foreach($request->category_name as $k => $postVal) {
            $categoryName = $request["category_name"][$k];
            $noOfItems = $request["no_of_items"][$k];
            $categoryItems = $request["item"][$k];
            $row = Category::where('name', '=', $categoryName)->where('user_id', "=", $authId)->first();
            if (empty($row)) {
                $row = new Category;
                $row->name = $categoryName;
                $row->slug = Str::slug($categoryName);
                $row->type = 1;
                $row->status = 0;
                $row->user_id = $authId;
                $row->save();
            } else {
                $row->name = $categoryName;
                $row->slug = Str::slug($categoryName);
                $row->type = 1;
                $row->status = 0;
                $row->user_id = $authId;
                $row->save();
            }

            $categoryId = $row->id;

            if (!empty($categoryId)) {

                $row = Package::where('name', '=', $request->name)->where('user_id', "=", $authId)->first();
                if (empty($row)) {
                    $row = new Package;
                    $row->user_id = $authId;
                    $row->name = $request->name;
                    $row->description = $request->description;
                    $row->price = $request->price;
                    $row->status = $request->status;
                    $row->save();
                } else {
                    $row->user_id = $authId;
                    $row->name = $request->name;
                    $row->description = $request->description;
                    $row->price = $request->price;
                    $row->status = $request->status;
                    $row->save();
                }

                $packageId = $row->id;

                if ($packageId && $categoryId) {

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
                                $row->save();
                            } else {
                                $row->package_id = $packageId;
                                $row->package_category_id = $packageCategoryId;
                                $row->name = $pItems[$k];
                                $row->description = $pDescription[$k];
                                $row->mild = (isset($pSpicy[$k]) && $pSpicy[$k] == "mild") ? 1 : 0 ;
                                $row->hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "hot") ? 1 : 0 ;
                                $row->extra_hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "extra_hot") ? 1 : 0 ;
                                $row->deleted = 0;
                                $row->save();
                            }
                             
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
            $packageItems = $packageItem->select('id', 'package_id', 'package_category_id', 'name', 'description', 'mild', 'hot', 'extra_hot')->where('user_id',$auth_id)->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
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

        $packages = $package->select('id', 'name', 'description', 'price')->where('id',$id)->where('user_id',$auth_id)->get()->toArray();
        $packageCategories = [];
        $packageItems = [];
        if (count($packages) > 0) {
            $packageIds = array_column($packages, "id");
            $packageCategories = $packageCategory->select('id', 'package_id', 'category_id', 'no_of_items')->where('user_id',$auth_id)->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
            $packageItems = $packageItem->select('id', 'package_id', 'package_category_id', 'name', 'description', 'mild', 'hot', 'extra_hot')->where('user_id',$auth_id)->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
        }
        return view('plugin::package.edit',compact('id', 'categories', 'packages', 'packageCategories', 'packageItems'));
        
    }

    public function update(Request $request, $id)
    {
        $authId = Auth::id();

        foreach($request->category_name as $k => $postVal) {
            $categoryName = $request["category_name"][$k];
            $noOfItems = $request["no_of_items"][$k];
            $categoryItems = $request["item"][$k];
            $row = Category::where('name', '=', $categoryName)->where('user_id', "=", $authId)->first();
            if (empty($row)) {
                $row = new Category;
                $row->name = $categoryName;
                $row->slug = Str::slug($categoryName);
                $row->type = 1;
                $row->status = 0;
                $row->user_id = $authId;
                $row->save();
            } else {
                $row->name = $categoryName;
                $row->slug = Str::slug($categoryName);
                $row->type = 1;
                $row->status = 0;
                $row->user_id = $authId;
                $row->save();
            }

            $categoryId = $row->id;

            if (!empty($categoryId)) {

                $row = Package::where('id', '=', $id)->first();
                if (!empty($row)) {
                    $row->user_id = $authId;
                    $row->name = $request->name;
                    $row->description = $request->description;
                    $row->price = $request->price;
                    $row->status = $request->status;
                    $row->save();
                }

                $packageId = $row->id;

                if ($packageId && $categoryId) {

                    PackageCategory::where('user_id', $authId)->where('package_id', "=", $packageId)->where('category_id', "=", $categoryId)->update(['deleted' => 1]);
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
                        $row->user_id = $authId;
                        $row->deleted = 0;
                        $row->save();
                    }
                }

                $packageCategoryId = $row->id;

                if ($packageId && $packageCategoryId) {
                    PackageItem::where('user_id', $authId)->where('package_id', "=", $packageId)->where('package_category_id', "=", $packageCategoryId)->update(['deleted' => 1]);
                    $pItems = $categoryItems["name"];
                    $pDescription = $categoryItems["description"];
                    $pSpicy = $categoryItems["spicy"];
                    foreach ($pItems as $k => $item) {
                        if (!empty($pItems[$k])) {
                            $row = PackageItem::where('user_id', $authId)->where('package_id', "=", $packageId)->where('package_category_id', "=", $packageCategoryId)->where('name', "=", $pItems[$k])->first();
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
                                $row->save();
                            } else {
                                $row->package_id = $packageId;
                                $row->package_category_id = $packageCategoryId;
                                $row->name = $pItems[$k];
                                $row->description = $pDescription[$k];
                                $row->mild = (isset($pSpicy[$k]) && $pSpicy[$k] == "mild") ? 1 : 0 ;
                                $row->hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "hot") ? 1 : 0 ;
                                $row->extra_hot = (isset($pSpicy[$k]) && $pSpicy[$k] == "extra_hot") ? 1 : 0 ;
                                $row->deleted = 0;
                                $row->save();
                            }
                             
                        }      
                    }
                }
            }
        }
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
}