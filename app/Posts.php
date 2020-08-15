<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['category_id', 'subcategory_id', 'post_title', 'tags', 'body'];
}
