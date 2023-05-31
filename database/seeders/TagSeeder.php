<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder {
	public $tags = [
		['id' => 1, 'name' => 'braking', 'slug' => 'breaking'],
		['id' => 2, 'name' => 'worldnews', 'slug' => 'worldnews'],
		['id' => 3, 'name' => 'ctg-news', 'slug' => 'ctg-news'],
		['id' => 4, 'name' => 'election', 'slug' => 'election'],
		['id' => 5, 'name' => 'programming', 'slug' => 'programming'],
		['id' => 6, 'name' => 'technology', 'slug' => 'technology'],
		['id' => 7, 'name' => 'opinion', 'slug' => 'opinion'],
		['id' => 8, 'name' => 'accident', 'slug' => 'accident'],
		['id' => 9, 'name' => 'dhaka-north', 'slug' => 'dhaka-north'],
		['id' => 10, 'name' => 'shylet', 'slug' => 'shylet'],
		['id' => 11, 'name' => 'toruism', 'slug' => 'toruism'],
		['id' => 12, 'name' => 'admission', 'slug' => 'admission'],
		['id' => 13, 'name' => 'varsity-news', 'slug' => 'varsity-news'],
		['id' => 15, 'name' => 'travel', 'slug' => 'travel'],
		['id' => 16, 'name' => 'sports', 'slug' => 'sports'],
		['id' => 17, 'name' => 'wordlcup', 'slug' => 'wordlcup'],
		['id' => 18, 'name' => 'eid', 'slug' => 'eid'],
		['id' => 19, 'name' => 'fashon', 'slug' => 'fashon'],
		['id' => 20, 'name' => 'local news', 'slug' => 'local-news'],
		['id' => 21, 'name' => 'economy', 'slug' => 'economy'],
		['id' => 22, 'name' => 'world-politics', 'slug' => 'world-politics'],
		['id' => 23, 'name' => 'health', 'slug' => 'health'],
		['id' => 24, 'name' => 'chatGPT', 'slug' => 'chatGPT'],
		['id' => 25, 'name' => 'artifitial-intelligence', 'slug' => 'artifitial-intelligence'],
		['id' => 26, 'name' => 'openai', 'slug' => 'openai'],
		['id' => 27, 'name' => 'cricket', 'slug' => 'cricket'],
		['id' => 28, 'name' => 'football', 'slug' => 'football'],
		['id' => 29, 'name' => 'hocky', 'slug' => 'hocky'],
		['id' => 30, 'name' => 'wild-news', 'slug' => 'wild-news'],
		['id' => 31, 'name' => 'study-abroad', 'slug' => 'study-abroad'],
		['id' => 32, 'name' => 'pc-problems', 'slug' => 'pc-problems'],
		['id' => 33, 'name' => 'latest-laptops', 'slug' => 'latest-laptops'],
	];

	public function run(): void {
		Tag::truncate();

		foreach ($this->tags as $tag) {
			Tag::create($tag);
		}
	}
}

// php artisan db:seed --class=TagSeeder
