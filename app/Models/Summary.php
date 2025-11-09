<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'url',
        'summary',
    ];
}
