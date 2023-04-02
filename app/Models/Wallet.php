<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $table = 'sj_wallet_in';
	 protected $primaryKey = 'wallet_in_id';
	
     protected $fillable = [
         	'wallet_in_user_id',
			'wallet_in_refcode',
			'wallet_in_type',
			'wallet_in_amount',
			'wallet_in_date',
			'wallet_in_created',
			'wallet_in_createdby',
			'wallet_in_status'
    ];

}
