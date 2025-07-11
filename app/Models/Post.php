<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];  // Allow mass assignment
}
