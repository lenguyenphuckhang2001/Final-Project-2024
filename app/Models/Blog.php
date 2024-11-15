<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory;

    function topic(): BelongsTo
    {
        return $this->belongsTo(BlogTopic::class, 'topic_id', 'id');
    }

    function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class, 'blog_id', 'id');
    }
}
