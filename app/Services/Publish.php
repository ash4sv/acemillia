<?php

namespace App\Services;

class Publish
{
    /**
     * Generate the publish button.
     *
     * @param string|null $status
     * @return string
     */
    public static function publishBtn($status = null)
    {
        $status = ucfirst($status) ?? 'Draft';

        // Define button colors based on status
        $colorClass = [
            'Draft' => 'btn-warning',
            'Active' => 'btn-success',
            'Inactive' => 'btn-secondary'
        ];

        $btnClass = $colorClass[$status] ?? 'btn-warning'; // Default to Draft if not found

        return <<<HTML
        <label for="publish" class="form-label">Publish</label>
        <div class="btn-publish-set">
            <div class="btn-group">
                <button type="button" class="btn {$btnClass} w-px-150">
                    {$status}
                </button>
                <button type="button" class="btn {$btnClass} dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                    <li><a class="dropdown-item" href="#">Draft</a></li>
                    <li><a class="dropdown-item" href="#">Active</a></li>
                    <li><a class="dropdown-item" href="#">Inactive</a></li>
                </ul>
            </div>
        </div>
        <input type="hidden" name="publish" id="publish-status" value="{$status}">
        HTML;
    }
}
