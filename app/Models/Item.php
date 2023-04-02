<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'item_url',
        'item_yenprice',
        'item_rmprice',
        'item_quantity',
        'item_currency',
        'item_user_id',
        'item_order_id',
        'item_subtotal',
        'item_services',
        'item_process',
        'item_no',
        'item_img',
        'item_desc',
        'created_by'
        
    
        
        // 'password',
    ];


    public function item(){
        return $this->hasMany(Item::class);
    }



	 public function order()
    {
        return $this->belongsTo(Order::class,'item_order_id');
    }

     public function user()
    {
        return $this->belongsTo(User::class,'item_user_id');
    }

	 public function itemStatus()
    {
        return $this->belongsTo(inf_item_status::class,'item_status_id', 'item_status_code');
        // return $this->belongsTo(Parent::class,'foreign_key','owner_key');
    }


   public function refund()
   {
    return $this->hasOne(Refund::class,'id','refund_id');
   }
}
