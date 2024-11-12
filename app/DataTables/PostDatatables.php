<?php

namespace App\DataTables;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PostDatatables extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    private $authUser;

    public function __construct()
    {
        // $this->authUser = auth()->user();
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // dd($query->with('posts')->get());
        return (new EloquentDataTable($query->orderBy('id','desc')->with(['user'])->select('posts.*')))
            ->addIndexColumn()
            ->editColumn('created_at', function($record) {
                return $record->created_at->format('d-m-Y');
            })
            ->editColumn('user_name', function($record){
                return $record->user->name ? ucwords($record->user->name) : 'No user';
            })
            ->editColumn('title', function($record){
                return $record->title ? ucwords($record->title) : 'No title';
            })
            ->addColumn('action', function($record){
                $actionHtml = '';
                if (Gate::check('post_view')) {
                    $actionHtml .= '<a href="'.route('admin.post.show',$record->id).'" class="btn btn-outline-info btn-sm m-1" title="Show"> <i class="ri-eye-line"></i> </a>';

                }
                if (Gate::check('post_edit')) {
                    $actionHtml .= '<a href="'.route('admin.post.edit',$record->id).'" class="btn btn-outline-success btn-sm m-1" title="Edit"><i class="ri-edit-2-line"></i></a>';
                }
                if (Gate::check('post_delete')) {
                    
                    $actionHtml .= '<button type="button" class="btn btn-outline-danger btn-sm m-1 deletePostBtn" data-href="'.route('admin.post.destroy', $record->id).'" title="Delete"><i class="ri-delete-bin-line"></i></button>';

                }
                return $actionHtml;
            })
            ->setRowId('id')
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d-%m-%Y') like ?", ["%$keyword%"]); //date_format when searching using date
            })   
            ->filterColumn('user_name', function($query, $keyword){
                $query->whereHas('user', function($q) use ($keyword) {
                    $q->where('name', 'like', "%$keyword%");  
                });
            })      
            ->orderColumn('user_name', function($query, $order) {
                $query->join('users', 'posts.user_id', '=', 'users.id')
                    ->orderBy('users.name', $order);  // Order by the 'users.name' column
            })
            ->rawColumns(['action']);
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
        $orderByColumn = 4;
        return $this->builder()
                    ->setTableId('post-table')
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
            
        $columns[] = Column::make('title')->title('Post Title');
        $columns[] = Column::make('user_name')->title('Name');
        $columns[] = Column::make('created_at')->title('Created At');
       
        $columns[] = Column::computed('action')->orderable(false)->exportable(false)->printable(false)->width(60)->addClass('text-center action-col');

        return $columns;
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Post_' . date('YmdHis');
    }
}
