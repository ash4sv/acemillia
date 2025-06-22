<?php

namespace App\Services\DataTable;

use Yajra\DataTables\Html\Button;

class DataTableParameter
{
    public static function createBtn(
        string $title,
        string $url,
        string $scrollable    = '',
        string $centered      = '',
        string $optional_size = '',
        string $fullscreen_mode = ''
    ): array {
        return [
            'text' => $title,
            'className' => 'btn btn-primary mb-3 mb-md-0 waves-effect waves-light',
            'attr'      => [
                'data-bs-toggle'               => 'modal',
                'data-bs-target'               => '#basicModal',
                // Only add "true" if explicitly provided as "true", otherwise default to empty.
                'data-modal-dialog-scrollable' => $scrollable === 'true' ? 'true' : '',
                'data-modal-dialog-centered'   => $centered === 'true' ? 'true' : '',
                // For optional size and fullscreen mode, default to an empty string.
                'data-modal-optional-size'     => $optional_size ?: '',
                'data-modal-fullscreen-mode'   => $fullscreen_mode ?: '',
                'data-create-url'              => $url,
                'data-create-title'            => $title,
            ],
        ];
    }

    public static function dangerBtn(string $id, string $label, string $url): array
    {
        return [
            'text' => $label,
            'className' => 'btn btn-danger mb-3 mb-md-0 waves-effect waves-light',
            'attr' => [
                'tabindex' => -1,
                'id' => $id,
                'data-bulk-delete-url' => $url,
            ],
        ];
    }

    // Method to configure the table with default settings
    public static function configTable(): array
    {
        return [
            'order'      => [0, 'desc'],
            'responsive' => true,
            'lengthMenu' => [50, 100, 200, 500],
            'dom'        => '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        ];
    }

    // Method to provide built-in buttons like reload, excel, etc.
    public static function defaultButtons(): array
    {
        return [
            Button::make('reload'),
            Button::make('excel'),
            Button::make('csv'),
            Button::make('pdf'),
            Button::make('print'),
            Button::make('reset'),
        ];
    }

    // Method to generate the export collection button
    public static function exportCollectionBtn(): array
    {
        return [
            'extend' => 'collection',
            'text' => '<i class="fa fa-download"></i> Export',
            'className' => 'btn btn-label-primary dropdown-toggle mb-3 mb-md-0 waves-effect waves-light',
            'buttons' => [
                ['extend' => 'excel', 'text' => 'Export to Excel'],
                ['extend' => 'csv', 'text' => 'Export to CSV'],
                ['extend' => 'pdf', 'text' => 'Export to PDF'],
                ['extend' => 'print', 'text' => 'Print'],
            ],
        ];
    }

}
