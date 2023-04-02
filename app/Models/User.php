<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'phone',
        'email',
		'address1',
		'address2',
		'address3',
		'postcode',
		'city',
		'state',
		'country',
        'password',
		'tokken',
		'active',
		'user_notification',
		'user_announce',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
        //user_id is foreign_key
    }

    public function buyer()
    {
        return $this->hasMany(Order::class)->whereNotIn('status_id', [0]);
    }

    public function items()
    {
        return $this->hasMany(Item::class,'item_user_id');
    }
    
}
