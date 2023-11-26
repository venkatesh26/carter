<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{

	protected $table="package_items";

	// public function packages()
	// {
	// 	return $this->hasMany(Package::class,'p_id','id');
	// }

	// public function childrenCategories()
	// {
	// 	return $this->hasMany(Category::class,'p_id','id')->with('categories');
	// }
}
