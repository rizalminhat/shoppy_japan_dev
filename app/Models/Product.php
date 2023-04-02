<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
		'product_img',
        'site_id',
        // 'password',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
