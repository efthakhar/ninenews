<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;


class Post extends Model
{
    use HasFactory;
    use Mediable;

    function category(){
        $this->hasOne(Category::class, 'category_id');
    }
}
