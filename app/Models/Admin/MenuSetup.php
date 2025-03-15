<?php

namespace App\Models\Admin;

use App\Models\Merchant;
use App\Models\Shop\Category;
use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuSetup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menu_setups';

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $guarded = [
        'name',
        'slug',
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

    public function categories()
    {
        return $this->morphToMany(Category::class, 'model', 'category_relations');
    }

    public function merchants()
    {
        return $this->hasMany(Merchant::class, 'menu_setup_id', 'id');
    }
}
