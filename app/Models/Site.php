<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    
     protected $fillable = [
        'site_name',
		'site_url',
        'site_image',
        // 'password',
    ];


    public function product(){
        return $this->hasMany(Product::class,'site_id')->where('product_status','=','1');
    }
}
