<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogTopic extends Model
{
    use HasFactory;

    function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'topic_id', 'id');
    }
}
