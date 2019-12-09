<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $timestamps = true;

    public $fillable = ['title', 'release_year', 'description'];
}
