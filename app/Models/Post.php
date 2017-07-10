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

    /**
     * Make sure that tree location names are rendered as
     * "title" case
     */
    public function getTreeLocationAttribute($value)
    {
        return implode(array_map(function($value){
            return ucfirst(strtolower($value));
        }, explode(' ', $value)), ' ');
    }
}
