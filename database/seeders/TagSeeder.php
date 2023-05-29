<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{

    public $tags = [
        ['id'=> 1, 'name'=> 'braking', 'slug'=>'breaking'],
        ['id'=> 2, 'name'=> 'worldnews', 'slug'=>'worldnews'],
        ['id'=> 3, 'name'=> 'ctg-news', 'slug'=>'ctg-news'],
        ['id'=> 4, 'name'=> 'election', 'slug'=>'election'],
        ['id'=> 5, 'name'=> 'programming', 'slug'=>'programming'],
        ['id'=> 6, 'name'=> 'technology', 'slug'=>'technology'],
        ['id'=> 7, 'name'=> 'opinion', 'slug'=>'opinion'],
        ['id'=> 8, 'name'=> 'accident', 'slug'=>'accident'],
        ['id'=> 9, 'name'=> 'dhaka-north', 'slug'=>'dhaka-north'],
        ['id'=> 10, 'name'=> 'shylet', 'slug'=>'shylet'],
        ['id'=> 11, 'name'=> 'toruism', 'slug'=>'toruism'],
        ['id'=> 12, 'name'=> 'admission', 'slug'=>'admission'],
        ['id'=> 13, 'name'=> 'varsity-news', 'slug'=>'varsity-news'],
        ['id'=> 15, 'name'=> 'travel', 'slug'=>'travel'],
        ['id'=> 16, 'name'=> 'sports', 'slug'=>'sports'],
        ['id'=> 17, 'name'=> 'wordlcup', 'slug'=>'wordlcup'],
        ['id'=> 18, 'name'=> 'eid', 'slug'=>'eid'],
    ];

    public function run(): void
    {

        Tag::truncate();

        foreach ($this->tags as $tag) {
            Tag::create($tag);
        }
    }
}

//php artisan db:seed --class=TagSeeder