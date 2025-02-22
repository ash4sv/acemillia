<?php

namespace App\Models\Admin\Blog;

use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTag extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'post_tags';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
    ];

    protected $guarded = [
        'name',
        'slug',
        'description',
        'image',
        'status',
    ];

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

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'model', 'post_tag_relations');
    }
}
