<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Refund extends Model
{
    use HasFactory;


    protected $fillable = [
        'refund_refno',
		'refund_amount',
        'refund_date',
		'refund_time',
    ];


    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'refund_user_id','id');
    }

}
