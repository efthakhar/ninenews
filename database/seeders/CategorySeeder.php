<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder {
	public $categories = [
		[
			'id'                 => 1,
			'parent_category_id' => NULL,
			'name'               => 'sports',
			'slug'               => 'sports',
			'lang'               => 'en',
			'post_type'          => 'article'
		],
		[
			'id'                 => 2,
			'parent_category_id' => 1,
			'name'               => 'cricket',
			'slug'               => 'cricket',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 3,
			'parent_category_id' => 2,
			'name'               => 'ctg area cricket',
			'slug'               => 'ctg-area-cricket',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 4,
			'parent_category_id' => NULL,
			'name'               => 'business',
			'slug'               => 'business',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 5,
			'parent_category_id' => NULL,
			'name'               => 'World News',
			'slug'               => 'world-news',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 6,
			'parent_category_id' => 5,
			'name'               => 'Europe News',
			'slug'               => 'europe-news',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 7,
			'parent_category_id' => 6,
			'name'               => 'Spain News',
			'slug'               => 'spain-news',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 8,
			'parent_category_id' => NULL,
			'name'               => 'Politics',
			'slug'               => 'politics',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 9,
			'parent_category_id' => 8,
			'name'               => 'GEO-Politics',
			'slug'               => 'geo-politics',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 10,
			'parent_category_id' => 8,
			'name'               => 'Local Politics',
			'slug'               => 'local-politics',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 11,
			'parent_category_id' => NULL,
			'name'               => 'Study',
			'slug'               => 'study',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
		[
			'id'                 => 12,
			'parent_category_id' => 11,
			'name'               => 'Study Abroad',
			'slug'               => 'study-abroad',
			'lang'               => 'en',
			'post_type'          => 'article',
		],
	];

	public function run(): void {
		Category::truncate();

		foreach ($this->categories as $category) {
			Category::create($category);
		}

	}
}

// php artisan db:seed --class=CategorySeeder