<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	use HasFactory;
	protected $fillable = [
		'name',
		'slug',
		'description',
		'meta_tag_description',
		'meta_tag_keywords',
		'created_by',
		'tag_img_id',
	];
}
