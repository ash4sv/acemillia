<?php

namespace App\DataTables\Admin;

use App\Models\Shop\SpecialOffer;
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

class SpecialOfferAdminDataTable extends DataTable
{
    protected string $route = 'admin.shop.special-offer.';
    protected string $permission = 'admin-systems-management-';

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($offer) {
                return EloquentDataTableBtnElement::button([
                    'show-btn'   => [ $this->permission . 'read', true, $offer->name, route($this->route . 'show', $offer->id) ],
                    'edit-btn'   => [ $this->permission . 'update', true, 'Edit Category', route($this->route . 'edit', $offer->id) ],
                    'delete-btn' => [ $this->permission . 'delete', true, route($this->route . 'destroy', $offer->id) ]
                ]);
            })
            ->addColumn('updated_at', function ($offer) {
                return $offer->updated_at->format('d-m-y, h:i A');
            })
            ->addColumn('product', function ($offer) {
                return $offer->product->name;
            })
            ->rawColumns(['updated_at', 'action', 'product'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SpecialOffer $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('special-offer-admin-table')
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
                                DataTableParameter::createBtn('Create Special Offer', route($this->route . 'create')),
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
            Column::computed('product'),
            Column::computed('updated_at')->className('w-px-200'),
            Column::computed('action')->title('Action')->className('w-px-150'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SpecialOfferAdmin_' . date('YmdHis');
    }
}
