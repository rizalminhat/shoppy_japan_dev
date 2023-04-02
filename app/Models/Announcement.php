<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'announce_type',
        'announce_name',
        'announce_description',
        'announce_status',
        'admin_id',
    ];
}
