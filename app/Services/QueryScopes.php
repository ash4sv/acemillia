<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class QueryScopes
{
    /**
     * Scope query to only published items.
     *
     * @param Builder $query
     * @return Builder
     */
    public static function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope query to only published items.
     *
     * @param Builder $query
     * @return Builder
     */
    public static function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope query to only published items.
     *
     * @param Builder $query
     * @return Builder
     */
    public static function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', 'inactive');
    }
}
