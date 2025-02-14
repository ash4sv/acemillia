<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugGenerator
{
    /**
     * Generate a unique slug for a given model and name.
     *
     * @param string $name
     * @param string $modelClass - Fully qualified class name (e.g., App\Models\BoothArea)
     * @param string|null $id - (Optional) If updating, exclude the current record from uniqueness check
     * @param string $column - The column to check for uniqueness (default: 'slug')
     * @return string
     */
    public static function generateUniqueSlug(string $name, string $modelClass, ?string $id = null, string $column = 'slug'): string
    {
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
            throw new \InvalidArgumentException("Invalid model class: {$modelClass}");
        }

        $slug = Str::slug($name);
        $baseSlug = $slug;
        $slugCounter = 1;

        // Ensure slug uniqueness
        while ($modelClass::withTrashed()
            ->where($column, $slug)
            ->when($id, fn($query) => $query->where('id', '!=', $id)) // Exclude current record when updating
            ->exists())
        {
            $slug = $baseSlug . '-' . $slugCounter;
            $slugCounter++;
        }

        return $slug;
    }
}
