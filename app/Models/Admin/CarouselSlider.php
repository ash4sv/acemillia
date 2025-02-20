<?php

namespace App\Models\Admin;

use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarouselSlider extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carousel_sliders';

    protected $fillable = [
        'image',
        'url',
        'status',
    ];

    protected $guarded = [
        'image',
        'url',
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
}
