<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'birhdate', 'city', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the profile's image.
     */
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
