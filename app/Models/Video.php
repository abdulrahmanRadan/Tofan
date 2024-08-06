<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'description', 'date','is_visible'
    ];

    public function category() :BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}