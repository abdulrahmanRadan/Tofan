<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Books_category extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'books_categories';
    protected $fillable = [
        'name', 'slug', 'description', 'photo'
    ];

    public function book():HasMany
    {
        return $this->hasMany(Book::class);
    }
    
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}