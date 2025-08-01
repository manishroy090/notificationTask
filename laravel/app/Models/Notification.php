<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
         'message',
         'processed',
         'user_id',
         'type'
    ];
}
