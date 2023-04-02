<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\inf_item_status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    
     protected $fillable = [
         'order_id',
		 'user_id',
		 'status_id'
		
		 
        // 'password',
    ];


    public function order(){
        return $this->hasMany(Order::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
        //1 order ada bnyk item, dimana item_order_id sbgi foreign key table items
    }

  public function courier()
  {
      return $this->belongsTo(Courier::class);
  }
   

  public function peritem()
  {
    return $this->hasMany(Item::class, 'item_order_id', 'id');
  }

}
