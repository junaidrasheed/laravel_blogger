<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    public function likes()
    {
    	return $this->hasMany('App\Like');
    }

    public function comments()
    {
    	return $this->hasMany('App\Comment');
    }

    public function image()
    {
        return $this->morphOne('App\Image','imagemodel');
    }

}
