<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Plank\Mediable\Mediable;

class Category extends Model
{
    use HasFactory;
    use Mediable;
	
	protected $fillable = [
		'parent_category_id',
		'name',
		'slug',
		'description',
		'meta_tag_description',
		'meta_tag_keywords',
		'lang',
		'post_type',
		'created_by',
		'updated_by',
	];

    /**
     * Get the parent category that owns the sub-category
    */
    public function parent_category(): BelongsTo
    {
        return $this->belongsTo($this,'parent_category_id');
    }

    /**
     * Get the sub-categories for the blog post.
    */
    public function sub_categories(): HasMany
    {
        return $this->hasMany($this,'parent_category_id');
    }
}
