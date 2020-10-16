<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name','product_image','product_description','product_price','payment_link',
    ];
    public function purchases()
    {
        return $this->hasMany('App\Purchase');
    }
}
