<?php

namespace Modules\Account\DataTable;

use Modules\Account\Entities\BankAccount;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BankAccountDataTable extends DataTable
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
            ->addColumn('balance', function ($bankAccount){
                return amountFormat($bankAccount->balance);
            })
            ->addColumn('action', function($model){
                return view('account::bank_account.action', compact('model'));
            })

            ->editColumn('status', function($model){
                return populate_status($model->status);
            })

            ->rawColumns(['status', 'action']);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(BankAccount $model)
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
            ->setTableId('bank-account-table')
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
                .column( 5 , { page: "current"})
                .data()
                .reduce( function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0 );


            var currency_sym = $("#currency_sym").val();
            // Update footer by showing the total with the reference of the column index
        $(api.column(0).footer() ).html("'.trans('common.total').'");
            $(api.column( 5 ).footer() ).html(amountFormat(total));
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
            Column::make('bank_name')->title(__('bank_account.Bank Name')),
            Column::make('branch_name')->title(__('bank_account.Branch Name')),
            Column::make('account_name')->title(__('bank_account.Account Name')),
            Column::make('account_number')->title(__('bank_account.Account Number')),
            Column::make('balance')->title(__('account.Balance'))->orderable(false),
            Column::make('status')->title(__('common.status')),

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
        return 'Bank_Accounts_' . date('YmdHis');
    }
}
