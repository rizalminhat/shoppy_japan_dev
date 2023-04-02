<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announce extends Model
{
    use HasFactory;

     protected $fillable = [
        'announce_type',
        'announce_title',
        'announce_description',
        'announce_status',
        'admin_id',
    ];
}
