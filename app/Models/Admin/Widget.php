<?php

namespace App\Models\Admin;

use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Widget extends Model
{
    use SoftDeletes;

    protected $table = 'widgets';

    protected $fillable = [
        'name',
        'image',
        'url',
        'start_at',
        'end_at',
        'size',
        'status',
    ];

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'date',
        'end_at'   => 'date'
    ];

    protected $dates = [
        'start_at',
        'end_at'
    ];

    public function scopeDraft($query)
    {
        return QueryScopes::scopeDraft($query);
    }

    public function scopeInactive($query)
    {
        return QueryScopes::scopeInactive($query);
    }

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($widget) {
            $widget->checkAndUpdateStatus();
        });
    }

    /**
     * Check and update widget status based on end_at date.
     */
    public function checkAndUpdateStatus()
    {
        $now = Carbon::now();

        if ($this->end_at && $this->status === 'active') {
            if ($now->greaterThan($this->end_at)) {
                $this->status = 'inactive';
                $this->saveQuietly();

                // Clear size-based caches
                $formattedSize = $this->size ? str_replace(', ', 'x', $this->size) : 'default';

                cache()->forget("random_active_widget_{$formattedSize}");
                cache()->forget("random_active_widgets_4_{$formattedSize}");
            }
        }
    }

    /**
     * Scope for active widgets only, considering status and optional dates.
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();

        return $query->where('status', 'active')
            ->where(function ($query) use ($now) {
                $query->where(function ($q) {
                    $q->whereNull('start_at')
                        ->whereNull('end_at');
                })
                    ->orWhere(function ($q) use ($now) {
                        $q->where('start_at', '<=', $now)
                            ->where('end_at', '>=', $now);
                    });
            });
    }

    /**
     * Get one random active widget (cached for 10 min).
     *
     * @return Widget|null
     */
    public static function getRandomActive(array $size = null)
    {
        $sizeKey = $size ? implode('x', $size) : 'default';
        $cacheKey = "random_active_widget_{$sizeKey}";

        return cache()->remember($cacheKey, now()->addMinutes(10), function () use ($size) {
            $query = self::active();

            if ($size) {
                $query->where('size', implode(', ', $size)); // Match format "931, 480"
            }

            return $query->inRandomOrder()->first();
        });
    }

    /**
     * Get multiple random active widgets (cached for 10 min).
     *
     * @param int $count
     * @return \Illuminate\Support\Collection
     */
    public static function getMultipleRandomActive($count = 4, array $size = null)
    {
        $sizeKey = $size ? implode('x', $size) : 'default';
        $cacheKey = "random_active_widgets_{$count}_{$sizeKey}";

        return cache()->remember($cacheKey, now()->addMinutes(10), function () use ($count, $size) {
            $query = self::active();

            if ($size) {
                $query->where('size', implode(', ', $size)); // Match format "931, 480"
            }

            return $query->inRandomOrder()->limit($count)->get();
        });
    }
}
