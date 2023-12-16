<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table="order_details";
    // protected $fillable = [
    //     'order_id',
    // ];
    public function products()
    {
    	return $this->hasOne('App\Terms','id','product_id')->select('id','title','type');
    }

    public function packages()
    {
    	return $this->hasOne('App\Package','id','package_id')->select('id','name');
    }
}	
