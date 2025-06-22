<?php

namespace App\DataTables\Merchant;

use App\Models\Merchant\WalletTransaction;
use App\Services\DataTable\DataTableParameter;
use App\Services\DataTable\EloquentDataTableBtnElement;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WalletTransactionMerchantDataTable extends DataTable
{
    protected string $route = 'admin.widget.';
    protected string $permission = 'admin-systems-management-';
    protected array $dataModalConfig = [
        'scrollable'      => 'false',
        'centered'        => 'false',
        'optional_size'   => 'modal-lg',
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
            ->addColumn('type', function ($row) {
                return ucfirst(str_replace('_', ' ', strtolower($row->type->value)));
            })
            ->addColumn('amount', function ($row) {
                $amount = number_format(abs($row->amount), 2);
                return $row->amount >= 0
                    ? "<span class='text-success'>+RM $amount</span>"
                    : "<span class='text-danger'>-RM $amount</span>";
            })
            ->addColumn('updated_at', fn($row) => $row->updated_at->format('d F Y  - H:i'))
            ->rawColumns(['amount', 'updated_at', 'type'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WalletTransaction $model): QueryBuilder
    {
        $merchant = Auth::guard('merchant')->user();
        return $model->where('merchant_id', $merchant->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('wallet-transaction-merchant-table')
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
                                /*Button::make('reload'),*/
                                /*DataTableParameter::createBtn(
                                    'Create Widget',
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
            Column::computed('updated_at')->className('w-px-200'),
            Column::computed('type'),
            Column::computed('amount'),
            Column::computed('remarks'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'WalletTransactionMerchant_' . date('YmdHis');
    }
}
