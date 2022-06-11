<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'image', 'slug'];

    public function Categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function Tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
