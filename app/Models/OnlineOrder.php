<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlineOrder extends Model
{
    use HasFactory;
	public $timestamps = false;
    protected $table = 'online_order';
	protected $primaryKey = "online_order_id";

	
     protected $fillable = [
         'online_order_reference',
			'online_order_type',
			'online_order_ssl',
			'online_order_token',
			'online_order_trans_code',
			'online_order_bank_code',
			'online_order_payer',
			'online_order_desc',
			'online_order_email',
			'online_order_amount',
			'online_order_status',
			'online_order_status_name',
			'online_user_id',
			'online_batch_code',
			'online_order_bank',
			'online_order_dateexec',
			'online_order_created',
			'online_order_mail'
		
		 
        // 'password',
    ];

}
