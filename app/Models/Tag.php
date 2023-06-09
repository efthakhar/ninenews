<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Tag extends Model {
	use HasFactory;
	use Mediable;
	
	protected $fillable = [
		'name',
		'slug',
		'description',
		'meta_tag_description',
		'meta_tag_keywords',
		'lang',
		'post_type',
		'created_by',
		'updated_by',
		'tag_img_id',
	];
}
