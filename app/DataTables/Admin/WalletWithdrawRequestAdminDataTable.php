<?php

namespace App\DataTables\Admin;

use App\Models\Merchant\WalletWithdrawRequest;
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

class WalletWithdrawRequestAdminDataTable extends DataTable
{
    protected string $route = 'admin.wallet-request.';
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
            ->addColumn('action', function ($item) {
                return EloquentDataTableBtnElement::button([
                    'show-btn'   => [
                        $this->permission . 'read',
                        true,
                        $item->name ?? 'Show',
                        route($this->route . 'show', $item->id),
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
                        $item->name ?? 'Edit',
                        route($this->route . 'edit', $item->id),
                        'modal' => [
                            'scrollable'      => $this->dataModalConfig['scrollable'],
                            'centered'        => $this->dataModalConfig['centered'],
                            'optional_size'   => $this->dataModalConfig['optional_size'],
                            'fullscreen_mode' => $this->dataModalConfig['fullscreen_mode'],
                        ],
                    ],
                    'delete-btn' => [ $this->permission . 'delete', true, route($this->route . 'destroy', $item->id) ]
                ]);
            })
            ->addColumn('updated_at', function ($item) {
                return $item->updated_at->format('d-m-y, h:i A');
            })
            ->addColumn('merchant', function ($item) {
                return $item->merchant->name;
            })
            ->addColumn('amount', function ($item) {
                return number_format($item->amount, 2);
            })
            ->addColumn('bank_info', function ($item) {
                return $item;
            })
            ->addColumn('status', function ($item) {
                return ucfirst($item->status->value);
            })
            ->addColumn('action_approve', function ($row) {
                if ($row->status->value === 'pending') {
                    $route = route('admin.wallet.withdraw.approval', $row->id);
                    return "<form class='mb-0' method='POST' action='{$route}'>" .
                        csrf_field() . method_field('PATCH') .
                        "<button class='btn btn-success mb-0'>Approve</button>" .
                        "</form>";
                }
                return '-';
            })
            ->rawColumns(['updated_at', 'action', 'merchant', 'amount', 'bank_info', 'status', 'action_approve'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WalletWithdrawRequest $model): QueryBuilder
    {
        return $model->newQuery()
            ->select(['id', 'merchant_id', 'amount', 'status', 'updated_at', 'amount', 'bank_name', 'bank_account_name', 'bank_account_number'])
            ->with(['merchant:id,name']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('wallet-withdraw-request-admin-table')
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
                                /*DataTableParameter::createBtn(
                                    'Create Group Product',
                                    route($this->route . 'create'),
                                    $this->dataModalConfig['scrollable'],
                                    $this->dataModalConfig['centered'],
                                    $this->dataModalConfig['optional_size'],
                                    $this->dataModalConfig['fullscreen_mode']
                                ),*/
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
            Column::computed('merchant')->title('Merchant'),
            Column::computed('amount')->title('Amount'),
            Column::computed('bank_info')->title('Bank Info'),
            Column::computed('status')->title('Status'),
            Column::computed('action_approve')->title('Approval')->className('w-px-200')
            /*Column::computed('action')->title('Action')->className('w-px-150'),*/
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'WalletWithdrawRequestAdmin_' . date('YmdHis');
    }
}
