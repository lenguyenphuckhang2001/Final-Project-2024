<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'phonenumber_one',
        'phonenumber_two',
        'email_one',
        'email_two',
        'address',
        'map_embed_code'
    ];
}
