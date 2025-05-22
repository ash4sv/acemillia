<?php

namespace App\Models\Admin\Service;

use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingProvider extends Model
{
    use SoftDeletes;

    protected $table = 'shipping_providers';

    protected $fillable = [
        'name',
        'api_key',
        'api_secret',
        'demo_url',
        'live_url',
        'status',
    ];

    protected $guarded = [];

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

    public function couriers()
    {
        return $this->hasMany(Courier::class, 'shipping_provider_id', 'id');
    }
}
