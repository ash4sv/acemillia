<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Blog\Post;
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

class PostAdminDataTable extends DataTable
{
    protected string $route = 'admin.blog.posts.';
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
            ->addColumn('action', function ($category) {
                return EloquentDataTableBtnElement::button([
                    'show-btn'   => [ $this->permission . 'read', true, $category->name, route($this->route . 'show', $category->id) ],
                    'edit-btn'   => [ $this->permission . 'update', true, 'Edit Post Tag', route($this->route . 'edit', $category->id) ],
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
    public function query(Post $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('post-admin-table')
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
                                DataTableParameter::createBtn('Create Post', route($this->route . 'create')),
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
            Column::make('title'),
            Column::computed('updated_at')->className('w-px-200'),
            Column::computed('action')->title('Action')->className('w-px-150'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PostAdmin_' . date('YmdHis');
    }
}
