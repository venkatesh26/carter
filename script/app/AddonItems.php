<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddonItems extends Model
{

	protected $table="addon_items";
    public $timestamps = false;
	// public function packages()
	// {
	// 	return $this->hasMany(Package::class,'p_id','id');
	// }

	// public function childrenCategories()
	// {
	// 	return $this->hasMany(Category::class,'p_id','id')->with('categories');
	// }
}
