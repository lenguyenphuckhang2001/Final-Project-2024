<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{
    use HasFactory;

    protected $fillable = [
        'background',

        'title_first',
        'number_first',

        'title_second',
        'number_second',

        'title_third',
        'number_third',

        'title_fourth',
        'number_fourth',
    ];
}
