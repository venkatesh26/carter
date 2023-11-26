<?php 

namespace Amcoders\Plugin\product\http\controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Category;
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
use DB;
use Illuminate\Support\Facades\Storage;
/**
 * 
 */
class PackageController extends controller
{

	public function index(Request $request)
    {   
        
        // DB::enableQueryLog();
        // dd(DB::getQueryLog());

        $auth_id=Auth::id();
        $queryStauts = (int) $request->input('approved');

        if (empty($queryStauts)) {
            $queryStauts = 0;
        }
        $packages = Package::where('approved',$queryStauts)->with('packageItems')->latest()->paginate(20);
        return view('plugin::package.index',compact('packages','auth_id'));
        
    }

    public function approvePackage(Request $request)
    {   
        $status = Package::where('id', $request->id)->update(['approved' => $request->approve]);
        return response()->json(['status'=> $status]);
    }

    public function show(Request $request, $id)
    {
        $auth_id=Auth::id();

        $category = new Category();
        $package = new Package();
        $packageCategory = new PackageCategory();
        $packageItem = new PackageItem();

        $categories = $category->select('id', 'name')->get()->toArray();

        $packages = $package->select('id', 'name', 'description', 'price')->where('id',$id)->get()->toArray();
        $packageCategories = [];
        $packageItems = [];
        if (count($packages) > 0) {
            $packageIds = array_column($packages, "id");
            $packageCategories = $packageCategory->select('id', 'package_id', 'category_id', 'no_of_items')->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
            $packageItems = $packageItem->select('id', 'package_id', 'package_category_id', 'name', 'description', 'mild', 'hot', 'extra_hot')->whereIn('package_id', $packageIds)->where('deleted', 0)->get()->toArray();
        }
        return view('plugin::package.show',compact('id', 'categories', 'packages', 'packageCategories', 'packageItems'));
    }

    public function bulkAction(Request $request)
    {
        if ($request->status=='approve') {
            if ($request->ids) {

                foreach ($request->ids as $id) {
                    $post=Package::find($id);
                    $post->approved=1;
                    $post->save();   
                }
                    
            }
        }
        elseif ($request->status=='disapprove') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    $post=Package::find($id);
                    $post->approved=0;
                    $post->save();   
                }
                    
            }
        }
        elseif ($request->status=='decline') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    $post=Package::find($id);
                    $post->approved=2;
                    $post->save();   
                }
                    
            }
        }
        return response()->json('Success');

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