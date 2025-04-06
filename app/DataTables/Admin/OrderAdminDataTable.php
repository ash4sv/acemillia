<?php

namespace App\DataTables\Admin;

use App\Models\Order\Order;
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

class OrderAdminDataTable extends DataTable
{
    protected string $route = 'admin.order.';
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
            ->addColumn('action', function ($item) {
                return EloquentDataTableBtnElement::button([
                    'show-btn'   => [ $this->permission . 'read', true, $item->name, route($this->route . 'show', $item->id) ],
                    'edit-btn'   => [ $this->permission . 'update', true, $item->name, route($this->route . 'edit', $item->id) ],
                    'delete-btn' => [ $this->permission . 'delete', true, route($this->route . 'destroy', $item->id) ]
                ]);
            })
            ->addColumn('updated_at', function ($item) {
                return $item->updated_at->format('d-m-y, h:i A');
            })
            ->addColumn('payment_status', function ($item){
                $status = $item->payment_status;
                $statusClass = [
                    'pending' => 'bg-label-warning',
                    'paid'    => 'bg-label-success',
                    'failed'  => 'bg-label-danger',
                ][$status] ?? 'bg-label-primary';
                $statusLabel = ucfirst($status);
                return '<div class="badge ' . $statusClass . ' "><span>' . $statusLabel . '</span></div>';
            })
            ->addColumn('status', function ($item){
                $status = $item->status;
                $statusClass = [
                    'processing' => 'bg-label-warning',
                    'completed'  => 'bg-label-success',
                    'cancelled'  => 'bg-label-danger',
                ][$status] ?? 'bg-label-primary';
                $statusLabel = ucfirst($status);
                return '<div class="badge ' . $statusClass . ' "><span>' . $statusLabel . '</span></div>';
            })
            ->rawColumns(['payment_status', 'status', 'updated_at', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('order-admin-table')
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
                                /*DataTableParameter::createBtn('Create Post', route($this->route . 'create')),*/
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
            Column::computed('uniq'),
            Column::computed('total_amount'),
            Column::computed('payment_status'),
            Column::computed('status'),
            Column::computed('updated_at')->className('w-px-200'),
            Column::computed('action')->title('Action')->className('w-px-150'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'OrderAdmin_' . date('YmdHis');
    }
}
