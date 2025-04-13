<?php

namespace App\Models\User;

use App\Models\Shop\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Compare
{
    /* -----------------------------------------------------------------
     |  Settings
     | -----------------------------------------------------------------
     */
    public const MAX_ITEMS   = 5;
    public const TTL_SECONDS = 60 * 60 * 24;   // 24 h

    /* -----------------------------------------------------------------
     |  Error codes
     | -----------------------------------------------------------------
     */
    public const ERR_NONE              = 0;
    public const ERR_DUPLICATE         = 1;
    public const ERR_LIMIT_REACHED     = 2;
    public const ERR_CATEGORY_MISMATCH = 3;

    /** Holds the error code of the last operation. */
    protected static int $lastError = self::ERR_NONE;

    /* -----------------------------------------------------------------
     |  Public API
     | -----------------------------------------------------------------
     */

    /** Return an Eloquent collection WITH category + sub‑category eager‑loaded. */
    public static function all(): Collection
    {
        return Product::with(['categories', 'sub_categories'])
                      ->whereIn('id', self::ids())
                      ->get();
    }

    /**
     * Try to add a product.
     *
     * @return bool  true on success, false otherwise (see error())
     */
    public static function add(int $productId): bool
    {
        $ids = self::ids();

        // ----- duplicate check
        if ($ids->contains($productId)) {
            return self::fail(self::ERR_DUPLICATE);
        }

        // ----- limit check
        if ($ids->count() >= self::MAX_ITEMS) {
            return self::fail(self::ERR_LIMIT_REACHED);
        }

        // ----- category consistency check
        $newProduct = Product::with('categories:id')->find($productId);

        // If product has no category, treat as mismatch
        if (!$newProduct || $newProduct->categories->isEmpty()) {
            return self::fail(self::ERR_CATEGORY_MISMATCH);
        }

        // Compare against first product in the list (if any)
        if ($ids->isNotEmpty()) {
            $firstProduct = Product::with('categories:id')->find($ids->first());

            // Intersection must not be empty
            $shareCategory = $firstProduct
                && $firstProduct->categories
                                ->pluck('id')
                                ->intersect($newProduct->categories->pluck('id'))
                                ->isNotEmpty();

            if (! $shareCategory) {
                return self::fail(self::ERR_CATEGORY_MISMATCH);
            }
        }

        // ----- all good → store
        $ids->push($productId);
        self::store($ids);

        return self::success();
    }

    /** Remove a product. */
    public static function remove(int $productId): void
    {
        $ids = self::ids()->reject(fn ($id) => $id == $productId);
        self::store($ids);
    }

    /** Flush the list. */
    public static function clear(): void
    {
        Cache::forget(self::cacheKey());
    }

    /** Merge guest list into logged‑in user list (call after login). */
    public static function migrate(): void
    {
        if (! Auth::check()) {
            return;
        }

        $guestKey = self::cacheKey(true);
        $merged   = collect(Cache::get($guestKey, []))
                    ->merge(self::ids())
                    ->unique()
                    ->take(self::MAX_ITEMS);

        self::store($merged);
        Cache::forget($guestKey);
    }

    /** Retrieve error code from the last add() attempt. */
    public static function error(): int
    {
        return self::$lastError;
    }

    /* -----------------------------------------------------------------
     |  Internals
     | -----------------------------------------------------------------
     */

    private static function ids(): Collection
    {
        return collect(Cache::get(self::cacheKey(), []));
    }

    private static function store(Collection $ids): void
    {
        Cache::put(self::cacheKey(), $ids->values()->all(), self::TTL_SECONDS);
    }

    private static function cacheKey(bool $forceGuest = false): string
    {
        if (! $forceGuest && Auth::check()) {
            return 'compare_user_' . Auth::id();
        }

        return 'compare_guest_' . Str::slug(session()->getId());
    }

    /* ---- helpers ---------------------------------------------------- */

    private static function fail(int $code): bool
    {
        self::$lastError = $code;
        return false;
    }

    private static function success(): bool
    {
        self::$lastError = self::ERR_NONE;
        return true;
    }
}
