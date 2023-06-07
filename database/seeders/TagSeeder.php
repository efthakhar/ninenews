<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder {
	public $tags = [
		['id' => 1, 'name' => 'bangladesh', 'slug' => 'bangladesh','lang'=>'en','post_type'=>'article'],
		['id' => 2, 'name' => 'politics', 'slug' => 'politics','lang'=>'en','post_type'=>'article'],
		['id' => 3, 'name' => 'রাজনীতি', 'slug' => 'রাজনীতি','lang'=>'bn','post_type'=>'article'],
		['id' => 4, 'name' => 'সারাদেশ', 'slug' => 'সারাদেশ','lang'=>'bn','post_type'=>'article'],
		['id' => 5, 'name' => 'পড়ালেখা', 'slug' => 'পড়ালেখা','lang'=>'bn','post_type'=>'article'],
	];

	public function run(): void {
		Tag::truncate();

		foreach ($this->tags as $tag) {
			Tag::create($tag);
		}
	}
}

// php artisan db:seed --class=TagSeeder
