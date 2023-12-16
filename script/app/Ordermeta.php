<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordermeta extends Model
{
    protected $table="order_meta";

    public function products()
    {
    	return $this->hasOne('App\Terms','id','term_id')->select('id','title','type');
    }

    public function packages()
    {
    	return $this->hasOne('App\Package','id','term_id')->select('id','name');
    }
    
    public function orderItems()
    {
    	return $this->hasMany('App\OrderDetails' ,'order_id','order_id');
    }
}
