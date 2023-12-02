<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

	protected $table="packages";

	// protected $fillable = ['created_at']; 

	public function packageCategories()
	{
		return $this->hasMany(Category::class,'category_id','id');
	}

	public function packageItems()
	{
		return $this->hasMany(PackageItem::class,'package_id','id');
	}

	public function orderItems()
	{
		return $this->hasMany(OrderDetails::class,'package_id','id');
	}

	
	// public function posts()
	// {
    //    return $this->belongsToMany('App\Terms','post_category','category_id','term_id');
	// }

	// public  function products()
	// {
    //   return $this->belongsToMany('App\Terms','post_category','category_id','term_id')->with('price','preview','addons','excerpt')->where('status',1)->where('terms.type',6);
	// }

	

	// public function childrenCategories()
	// {
	// 	return $this->hasMany(Package::class,'package_id','id')->with('packageitems');
	// }


	// public function user()
	// {
	// 	return $this->hasOne('App\User','id','user_id');
	// }
}
