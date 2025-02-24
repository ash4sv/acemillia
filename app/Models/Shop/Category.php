<?php

namespace App\Models\Shop;

use App\Models\Admin\MenuSetup;
use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'merchant_id',
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'status',
    ];

    protected $guarded = [
        'merchant_id',
        'name',
        'slug',
        'description',
        'icon',
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

public function menus()
    {
        return $this->morphedByMany(MenuSetup::class, 'model', 'category_relations');
    }

    public function sub_categories()
    {
        return $this->morphedByMany(SubCategory::class, 'model', 'category_relations');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'model', 'category_relations');
    }
}
