<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    /**
     * Static method for retrieving list of posts
     *
     * @param $request Request
     * @param $search_user array, list of user ids
     * @param $locale string, language locale
     *
     * @return $query QueryBuilder
     */
    public static function getPostList(
      Request $request, array $search_user, $locale
    )
    {
        $query = self::with('images')->with('user')
            ->where(function($query) use ($request){
                if($request->q){
                    $query = $query->orWhere('content', 'ilike', "%$request->q%")
                        ->orWhere('tree_location', 'ilike', "%$request->q%");
                }
            });

        if(count($search_user) > 0){
            $query = $query->orWhereIn('user_id', $search_user);
        }

        $query = $query->where('language', '=', $locale)
            ->where('deleted_at', '=', null);

        return $query->orderBy('created_at', 'desc');
    }
}
