<?php

namespace App\DataTables;

use App\Models\CustomerDataTable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTables extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', function($record) {
                return $record->created_at->format('d-m-Y');
            })

            ->editColumn('name', function($record){
                return $record->name ? ucwords($record->name) : '';
            })
            ->addColumn('action', function($record){
                $actionHtml = '';
                if(Gate::check('customer_edit'))
                {
                    $actionHtml .= '<a href="'.route('admin.customer.edit',$record->id).'" class="btn btn-outline-success btn-sm m-1" title="Edit"><i class="ri-edit-2-line"></i></a>';
                }
                if (Gate::check('customer_delete')) {
				    $actionHtml .= '<button type="button" class="btn btn-outline-danger btn-sm m-1 deleteCusBtn" data-href="'.route('admin.customer.destroy', $record->id).'" title="Delete"><i class="ri-delete-bin-line"></i></button>';
                }
                return $actionHtml;
            })
            ->setRowId('id')
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d-%m-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        // return $model->newQuery();
        $query = $model->whereHas('roles', function($query) {
            $query->whereIn('id', [
                config('constant.roles.customer'),
                config('constant.roles.staff')
            ]);
        });
        // dd(request()->all());
        if (request()->has('start_date') && request()->has('end_date')) {
            $query->whereBetween('created_at', [request('start_date'), request('end_date')]);
        }
       
        
        return $query->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $orderByColumn = 2;
        return $this->builder()
                    ->setTableId('customer-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy($orderByColumn)
                    ->selectStyleSingle()
                    ->lengthMenu([
                    [10, 25, 50, 100, /*-1*/],
                    [10, 25, 50, 100, /*'All'*/]
                ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [];

        $columns[] = Column::make('DT_RowIndex')->title('#')->orderable(false)->searchable(false);
       
        $columns[] = Column::make('name')->title('Name');
        $columns[] = Column::make('created_at')->title('Created At');
       
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Customer_' . date('YmdHis');
    }
}
