<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
	protected $casts = [
        'img' => 'json',
    ];

    protected $guarded = [];
}
