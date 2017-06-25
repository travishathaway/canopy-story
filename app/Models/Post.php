<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Return the user relationship
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Return image relations
     */
    public function images()
    {
        return $this->hasMany('App\Models\PostImage');
    }
}
