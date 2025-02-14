<?php

namespace App\Services\DataTable;

class EloquentDataTableBtnElement
{
    /**
     * Generate DataTable action buttons.
     *
     * @param array $config
     * @return string
     */
    public static function button(array $config): string
    {
        $html = '';

        if (self::isButtonEnabled($config, 'show-btn')) {
            $html .= self::generateButton(
                'btn-warning me-1',
                'ti ti-eye',
                $config['show-btn'][2] ?? 'Show', // Title
                $config['show-btn'][3] ?? '#',    // URL
                'Show'
            );
        }

        if (self::isButtonEnabled($config, 'edit-btn')) {
            $html .= self::generateButton(
                'btn-info me-1',
                'ti ti-pencil',
                $config['edit-btn'][2] ?? 'Edit', // Title
                $config['edit-btn'][3] ?? '#',    // URL
                'Edit'
            );
        }

        if (self::isButtonEnabled($config, 'delete-btn')) {
            $html .= self::generateDeleteButton(
                'btn-danger me-1',
                'ti ti-trash',
                $config['delete-btn'][2] ?? '#'
            );
        }

        return $html;
    }

    /**
     * Check if a button is enabled and valid in the config,
     * including an optional permission check.
     *
     * @param array $config
     * @param string $key
     * @return bool
     */
    private static function isButtonEnabled(array $config, string $key): bool
    {
        $permission = $config[$key][0] ?? null;

        return isset($config[$key]) &&
               $config[$key][1] === true && // Button enabled
               ($permission === null || auth()->user()->can($permission)); // Permission check if provided
    }

    /**
     * Generate an action button HTML.
     *
     * @param string $btnClass
     * @param string $iconClass
     * @param string $title
     * @param string $url
     * @param string $type
     * @return string
     */
    private static function generateButton(
        string $btnClass,
        string $iconClass,
        string $title,
        string $url,
        string $type
    ): string {
        return <<<HTML
        <a href="#"
           class="btn btn-icon btn-sm {$btnClass}"
           data-bs-toggle="modal"
           data-bs-target="#basicModal"
           data-create-url="{$url}"
           data-create-title="{$title}">
           <i class="{$iconClass}"></i>
        </a>
        HTML;
    }

    /**
     * Generate a delete button HTML.
     *
     * @param string $btnClass
     * @param string $iconClass
     * @param string $url
     * @return string
     */
    private static function generateDeleteButton(
        string $btnClass,
        string $iconClass,
        string $url
    ): string {
        return <<<HTML
        <a href="{$url}"
           class="btn btn-icon btn-sm {$btnClass}"
           data-confirm-delete="true">
           <i class="{$iconClass}"></i>
        </a>
        HTML;
    }
}
