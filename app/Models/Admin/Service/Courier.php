<?php

namespace App\Models\Admin\Service;

use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
    use SoftDeletes;

    protected $table = 'couriers';

    protected $fillable = [
        'shipping_provider_id',
        'image',
        'name',
        'service_code',
        'service_name',
        'delivery_time',
        'rate',
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
}
