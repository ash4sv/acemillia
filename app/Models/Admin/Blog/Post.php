<?php

namespace App\Models\Admin\Blog;

use App\Models\Admin;
use App\Services\QueryScopes;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'admin_id',
        'post_category_id',
        'title',
        'slug',
        'body',
        'banner',
        'status',
    ];

    protected $guarded = [
        'admin_id',
        'post_category_id',
        'title',
        'slug',
        'body',
        'banner',
        'status',
    ];

    public static function newFactory()
    {
        return PostFactory::new();
    }

    public function scopeDraft($query)
    {
        return QueryScopes::scopeDraft($query);
    }

    public function scopeActive($query)
    {
        return QueryScopes::scopeActive($query);
    }

    public function scopeInactive($query)
    {
        return QueryScopes::scopeInactive($query);
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id', 'id');
    }

    public function tags()
    {
        return $this->morphToMany(PostTag::class, 'model', 'post_tag_relations');
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
