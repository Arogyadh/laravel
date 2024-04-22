<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'title',
    //     'company',
    //     'location',
    //     'website',
    //     'email',
    //     'tags',
    //     'description',
    // ];

    public static function filterByTag($tag, $search)
    {
        if ($tag) {
            return static::where('tags', 'like', '%' . $tag . '%');
        }
        if ($search) {
            return static::where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%');
        } else {
            return static::query(); // Return all listings if no tag is provided
        }
    }
}
