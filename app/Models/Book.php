<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Book extends Model
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'name', 'slug', 'descriptions', 'photo', 'date','books_category_id','user_id'
    ];

    public function books_category():BelongsTo
    {
        return $this->belongsTo(Books_category::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media():HasMany
    {
        return $this->hasMany(Media::class);
    }

}