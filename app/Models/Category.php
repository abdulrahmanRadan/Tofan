<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'description', 'photo'
    ];

    public function video():HasMany
    {
        return $this->hasMany(Video::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}