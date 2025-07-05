<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    protected $fillable = [
        'title',
        'content', 
    ];

}
