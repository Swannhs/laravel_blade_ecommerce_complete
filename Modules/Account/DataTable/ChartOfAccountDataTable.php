<?php

namespace Modules\Account\DataTable;

use Modules\Account\Entities\ChartOfAccount;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ChartOfAccountDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('name', function ($chartOfAccount){
                $default_for = '';
                if ($chartOfAccount->default_for){
                    $default_for = '<span class="badge_1 ml-1">'.__('list.'.$chartOfAccount->default_for).'</span>';
                }
                return $chartOfAccount->name . $default_for;
            })
            ->editColumn('parent_id', function ($chartOfAccount){
                return $this->parentTree('', $chartOfAccount);

            })
            ->editColumn('type', function ($chartOfAccount){
                return __('list.'.$chartOfAccount->type);

            })
            ->addColumn('balance', function ($chartOfAccount){
                return amountFormat($chartOfAccount->balance);
            })
            ->addColumn('action', function($model){
                return view('account::chart_of_account.action', compact('model'));
            })

            ->editColumn('status', function($model){
                return populate_status($model->status);
            })
            ->rawColumns(['status', 'action', 'name']);
    }

    protected function parentTree($parent, $model){
        if ($model) {
           if ($model->parent){
                $parent .= $model->parent->name;
                if ($model->parent->parent) {
                    $parent .= '->';
                }

                return $this->parentTree($parent, $model->parent);

            }
        }

        return $parent;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ChartOfAccount $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('chart-of-account-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("Blfrtip")
            ->orderBy(1)
            ->responsive(1)
            ->language([
                'search' => "<i class='ti-search'></i>",
                'searchPlaceholder' => __('common.quick_search'),
                'paginate' => [
                    'next' => "<i class='ti-arrow-right'></i>",
                    'previous' => "<i class='ti-arrow-left'></i>"
                ]
            ])
            ->tabIndex(1)
            ->footerCallback('function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // converting to interger to find total
            var parseFloat = function ( i ) {
                return typeof i === "string" ?
                    i.replace(/[^\d.-]/g, "")*1 :
                    typeof i === "number" ?
                        i : 0;
            };
            // computing column Total of the complete result
            var total = api
                .column( 5 , { page: "current"})
                .data()
                .reduce( function (a, b) {
                console.log(parseFloat(a),parseFloat(b))
                    return parseFloat(a) + parseFloat(b);
                }, 0 );

            // Update footer by showing the total with the reference of the column index
        $(api.column(0).footer() ).html("'.trans('common.total').'");
            $(api.column( 5 ).footer() ).html(amountFormat(total));
        }')
            ->buttons(
                Button::make('copyHtml5'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            Column::computed('id')->data('DT_RowIndex')->title(__('common.sl'))->width(10),

            Column::make('type')->title(__('account.Type')),
            Column::make('name')->title(__('account.Name')),
            Column::make('code')->title(__('account.Code')),
            Column::make('parent_id')->title(__('account.Parent Account')),
            Column::make('balance')->title(__('account.Balance'))->orderable(false)->addClass('text-center'),
            Column::make('status')->title(__('common.status')),

            Column::computed('action')
                ->title(__('common.action'))
                ->exportable(false)
                ->printable(false)
                ->width(150),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Chart_Of_Accounts_' . date('YmdHis');
    }
}
