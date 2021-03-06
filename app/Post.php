<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'cover_image', 'category_id'];

//creare la relazione tra categoria e post, un posta ha solo una categoria mentre una categoria può essere associata a molti post
    public function category() {

        return $this->belongsTo('App\Category');
    }
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
