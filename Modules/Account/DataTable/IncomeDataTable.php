<?php

namespace Modules\Account\DataTable;

use Modules\Account\Entities\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IncomeDataTable extends DataTable
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
            ->editColumn('chart_of_account_id', function ($transaction){
               return "{$transaction->account->name}" ;
            })

            ->editColumn('payment_method', function ($transaction){
                if ($transaction->payment_method == 'bank'){
                    return __('list.'.$transaction->payment_method) . " ({$transaction->bank->bank_name})" ;
                }
                return __('list.'.$transaction->payment_method) ;
            })

            ->editColumn('amount', function ($transaction){
                return amountFormat($transaction->amount);
            })
            ->editColumn('transaction_date', function ($transaction){
                return dateFormat($transaction->transaction_date);
            })
            ->addColumn('action', function($model){
                return view('account::income.action', compact('model'));
            })


            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
    {
        return $model->where('come_from', 'income')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('income-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("Blfrtip")
            ->orderBy(1)
            ->responsive(1)
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
                .column( 4 , { page: "current"})
                .data()
                .reduce( function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0 );


            var currency_sym = $("#currency_sym").val();
            // Update footer by showing the total with the reference of the column index
        $(api.column(0).footer() ).html("'.trans('common.total').'");
            $(api.column( 4 ).footer() ).html(amountFormat(total));
        }')
            ->language([
                'search' => "<i class='ti-search'></i>",
                'searchPlaceholder' => __('common.quick_search'),
                'paginate' => [
                    'next' => "<i class='ti-arrow-right'></i>",
                    'previous' => "<i class='ti-arrow-left'></i>"
                ]
            ])
            ->tabIndex(1)
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
            Column::make('title')->title(__('common.title')),
            Column::make('chart_of_account_id')->title(__('chart_of_account.Income Account')),
            Column::make('payment_method')->title(__('chart_of_account.Payment Method')),
            Column::make('amount')->title(__('account.Amount')),
            Column::make('transaction_date')->title(__('common.date')),
            Column::computed('action')->title(__('common.action'))
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
        return 'Incomes_' . date('YmdHis');
    }
}
