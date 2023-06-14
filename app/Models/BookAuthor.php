<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookAuthor extends Model
{
    use HasFactory;
    
    protected $table = 'book_author';
    
    protected $fillable = [
        'book_id',
        'author_id',
    ];

    public $timestamps = false;
}