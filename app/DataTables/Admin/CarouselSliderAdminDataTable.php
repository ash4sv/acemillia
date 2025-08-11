<?php

namespace App\DataTables\Admin;

use App\Models\Admin\CarouselSlider;
use App\Services\DataTable\DataTableParameter;
use App\Services\DataTable\EloquentDataTableBtnElement;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CarouselSliderAdminDataTable extends DataTable
{
    protected string $route = 'admin.carousel-slider.';
    protected string $permission = 'admin-systems-management-';
    protected array $dataModalConfig = [
        'scrollable'      => 'false',
        'centered'        => 'false',
        'optional_size'   => 'modal-xl',
        'fullscreen_mode' => ''
    ];

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                return EloquentDataTableBtnElement::button([
                    'show-btn'   => [
                        $this->permission . 'read',
                        true,
                        $category->name,
                        route($this->route . 'show', $category->id),
                        'modal' => [
                            'scrollable'      => $this->dataModalConfig['scrollable'],
                            'centered'        => $this->dataModalConfig['centered'],
                            'optional_size'   => $this->dataModalConfig['optional_size'],
                            'fullscreen_mode' => $this->dataModalConfig['fullscreen_mode'],
                        ],
                    ],
                    'edit-btn'   => [
                        $this->permission . 'update',
                        true,
                        'Edit Category',
                        route($this->route . 'edit', $category->id),
                        'modal' => [
                            'scrollable'      => $this->dataModalConfig['scrollable'],
                            'centered'        => $this->dataModalConfig['centered'],
                            'optional_size'   => $this->dataModalConfig['optional_size'],
                            'fullscreen_mode' => $this->dataModalConfig['fullscreen_mode'],
                        ],
                    ],
                    'delete-btn' => [ $this->permission . 'delete', true, route($this->route . 'destroy', $category->id) ]
                ]);
            })
            ->addColumn('updated_at', function ($admin) {
                return $admin->updated_at->format('d-m-y, h:i A');
            })
            ->rawColumns(['updated_at', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CarouselSlider $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('carousel-slider-admin-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons(array_merge(
                        DataTableParameter::defaultButtons(),
                    ))
                    ->parameters(array_merge(
                        DataTableParameter::configTable(),
                        [
                            'buttons'    => [
                                Button::make('reload'),
                                DataTableParameter::createBtn(
                                    'Create Carousel Slider',
                                    route($this->route . 'create'),
                                    $this->dataModalConfig['scrollable'],
                                    $this->dataModalConfig['centered'],
                                    $this->dataModalConfig['optional_size'],
                                    $this->dataModalConfig['fullscreen_mode']
                                ),
                            ],
                        ]
                    ));
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('No')->className('text-start w-px-50'),
            Column::make('image'),
            Column::computed('updated_at')->className('w-px-200'),
            Column::computed('action')->title('Action')->className('w-px-150'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CarouselSliderAdmin_' . date('YmdHis');
    }
}
