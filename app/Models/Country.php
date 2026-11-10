<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'cca2',
        'capital',
        'region',
        'population',
        'flag_url',
    ];
}