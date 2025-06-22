<?php

namespace App\Models\Shop;

use App\Models\Merchant;
use App\Models\Order\OrderItem;
use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'merchant_id', 'name', 'slug', 'product_description', 'description', 'information', 'image', 'price', 'sku', 'weight', 'stock', 'stock_status', 'status',
    ];

    protected $guarded = [
        'merchant_id', 'name', 'slug', 'product_description', 'description', 'information', 'image', 'price', 'sku', 'weight', 'stock', 'stock_status', 'status',
    ];

    public function getPriceAttribute($price): string
    {
        $commissioned = $price * (1 + config('commission.rate') / 100);
        return 'RM' . number_format($commissioned, 2);
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
    public function scopePriceValue($query)
    {
        return $query->where('price', '>', 0);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'model', 'category_relations');
    }

    public function sub_categories()
    {
        return $this->morphToMany(SubCategory::class, 'model', 'sub_category_relations');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'model', 'tag_relations');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class, 'product_id', 'id');
    }

    public function orderItem()
    {
    return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    /**
     * Accessor to merge images from various relationships.
     *
     * This accessor will return a collection of image paths by merging:
     * - The main product image (if exists)
     * - Images from the product images relationship
     * - Option image paths and option values' image paths.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMergedImagesAttribute(): Collection
    {
        $mergedImages = collect();

        // 1. Add the main product image if it exists.
        if (!empty($this->image)) {
            $mergedImages->push($this->image);
        }

        // 2. Add images from the "images" relationship.
        // This assumes each related image model has a "path" attribute.
        foreach ($this->images as $img) {
            if (!empty($img->image_path)) {
                $mergedImages->push($img->image_path);
            }
        }

        // 3. Add images from product options and their values.
        // Make sure that the ProductOption model has a "values" relationship.
        foreach ($this->options as $option) {
            // Option image (if it exists)
            if (!empty($option->image_path)) {
                $mergedImages->push($option->image_path);
            }

            // Option values images
            // Assuming the ProductOption model has a "values" relationship.
            if (isset($option->values)) {
                foreach ($option->values as $value) {
                    if (!empty($value->image_path)) {
                        $mergedImages->push($value->image_path);
                    }
                }
            }
        }

        // Remove duplicates and reindex the collection.
        return $mergedImages->unique()->values();
    }

    /**
     * Accessor for the total stock.
     *
     * This accessor returns the sum of the product's own stock
     * and the stock of all its option values.
     *
     * @return int
     */
    public function getTotalStockAttribute(): int
    {
        // Start with the product's own stock
        $totalStock = $this->stock ?? 0;

        // Loop through each option and then its values to sum their stock.
        foreach ($this->options as $option) {
            // Ensure the "values" relationship is loaded to avoid extra queries.
            $values = $option->relationLoaded('values') ? $option->values : $option->values()->get();
            foreach ($values as $value) {
                $totalStock += $value->stock ?? 0;
            }
        }

        return $totalStock;
    }

    /**
     * Return the raw numeric value of 'price' (without "MYR" formatting).
     * This helps with calculations internally.
     *
     * If you store the price as a decimal in the database, you can
     * safely cast it to float here. Or just do (float) $this->attributes['price'].
     */
    public function getBasePriceNumericAttribute(): float
    {
        // "price" is stored in the DB, e.g. 100.00
        // If you have Eloquent casts, you could do: return $this->price;
        return (float) $this->getRawOriginal('price', 0);
    }

    /**
     * Accessor to return an array with [minPrice, maxPrice] for display purposes.
     *
     * Example usage in Blade:
     *   list($min, $max) = $product->min_max_price;
     *   // or $product->min_max_price[0], $product->min_max_price[1]
     */
    public function getMinMaxPriceAttribute(): array
    {
        // Start from the product's base numeric price
        $basePrice = $this->base_price_numeric;

        // For each option, find the lowest and highest "additional_price"
        // then keep adding them to a global min and max.
        $totalMinAddPrice = 0.0;
        $totalMaxAddPrice = 0.0;

        // Loop each ProductOption
        foreach ($this->options as $option) {
            // We'll find the min and max additional price among all values for this option
            $optionMin = null;
            $optionMax = 0.0;

            foreach ($option->values as $value) {
                $addPrice = (float) $value->additional_price;
                if (is_null($optionMin) || $addPrice < $optionMin) {
                    $optionMin = $addPrice;
                }
                if ($addPrice > $optionMax) {
                    $optionMax = $addPrice;
                }
            }

            // If an option doesn't have any values or you want to skip empty sets,
            // you can handle it (but presumably each option has at least one value).
            $optionMin = $optionMin ?? 0.0;

            $totalMinAddPrice += $optionMin;
            $totalMaxAddPrice += $optionMax;
        }

        $min = $basePrice + $totalMinAddPrice;
        $max = $basePrice + $totalMaxAddPrice;

        return [$min, $max];
    }

}
