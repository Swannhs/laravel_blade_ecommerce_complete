<?php


namespace Modules\Account\Repositories;


use App\Traits\ImageStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Account\Entities\BankAccount;
use Modules\Account\Entities\ChartOfAccount;
use Modules\Account\Entities\Transaction;
use Modules\Invoice\Entities\Invoice;

class TransactionRepository
{
    use ImageStore;

    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * TransactionRepository constructor.
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function pluckAll($id)
    {
        $query = $this->transaction->select(DB::raw('CONCAT(name, " (", code, ")") AS full_name'), 'id')->where('status', 1)->get();
        if ($id) {
            $query = $query->except($id);
        }
        return $query->pluck('full_name', 'id')->prepend(__('chart_of_account.Add As A Parent Account'), null);
    }


    public function create($request)
    {
        return $this->transaction->forceCreate($this->formatRequest($request));
    }

    public function update($request, $id)
    {
        $transaction = $this->find($id);
        $transaction->forceFill($this->formatRequest($request, $transaction))->save();
        return $transaction->refresh();
    }

    /**
     * @throws \Throwable
     */
    public function find($id, array $with = [])
    {
        $transaction = $this->transaction->with($with)->find($id);
        throw_if(!$transaction, ValidationException::withMessages(['message' => __('chart_of_account.The requested chart of account is not found')]));

        return $transaction;
    }


    /**
     * @throws \Throwable
     */
    public function findByParam($param, array $with = [])
    {
        $transaction = $this->transaction->with($with)->where($param)->first();
        return $transaction;
    }

    private function formatRequest($request, $transaction = null): array
    {
        $formattedRequest = [
            'title' => gv($request, 'title'),
            'chart_of_account_id' => gv($request, 'chart_of_account_id'),
            'payment_method' => gv($request, 'payment_method', 'cash'),
            'amount' => gv($request, 'amount'),
            'transaction_date' => gv($request, 'transaction_date'),
            'description' => gv($request, 'description'),
            'morphable_id' => gv($request, 'morphable_id'),
            'morphable_type' => gv($request, 'morphable_type'),
        ];

        if (gv($request, 'payment_method', 'cash') == 'Bank') {
            $formattedRequest['bank_account_id'] = gv($request, 'bank_account_id');
        } else {
            $formattedRequest['bank_account_id'] = null;
        }

        if (gv($request, 'file')) {
            $formattedRequest['file'] = $this->saveImage(gv($request, 'file'));
        }

        if (!$transaction) {
            $formattedRequest['come_from'] = gv($request, 'come_from');
            $formattedRequest['type'] = gv($request, 'type', 'in');
        }

        return $formattedRequest;
    }

    public function delete($id)
    {
        $transaction = $this->deleteAble($id);
        return $transaction->delete();
    }

    private function deleteAble($id)
    {
        $transaction = $this->find($id);
        return $transaction;
    }

    public function getTotalAmountByParamFilterByDate(array $params, $start, $end)
    {
        $transaction = $this->transaction->where('type', $params['type'])->whereIn('come_from', $params['come_from']);

        if ($start) {
            $transaction = $transaction->where('transaction_date', '>=', $start);
        }
        if ($end) {
            $transaction = $transaction->where('transaction_date', '<=', $end);
        }

        return $transaction->sum('amount');
    }

    public function allTransactions($start, $end, $account_id = null, $bank_account_id = null)
    {
        $transaction = $this->transaction->with('account', 'bank');

        if ($start || $end) {
            $transaction = $transaction->whereBetween('transaction_date', [$start, $end]);
        }

        if ($account_id || $bank_account_id) {
            if ($account_id && $bank_account_id) {
                $transaction = $transaction->where(function ($query) use ($account_id, $bank_account_id) {
                    $query->orWhere('chart_of_account_id', $account_id)->orWhere('bank_account_id', $bank_account_id);
                });
            } else {
                if ($account_id) {
                    $transaction = $transaction->where('chart_of_account_id', $account_id);
                }


                if ($bank_account_id) {
                    $transaction = $transaction->where('bank_account_id', $bank_account_id);
                }
            }
        }


        return $transaction->get();
    }

    public function allTransactionsQuery($start, $end, $account_id = null, $bank_account_id = null)
    {
        $transaction = $this->transaction->with('account', 'bank');

        if ($start || $end) {
            $transaction = $transaction->whereBetween('transaction_date', [$start, $end]);
        }

        if ($account_id || $bank_account_id) {
            if ($account_id && $bank_account_id) {
                $transaction = $transaction->where(function ($query) use ($account_id, $bank_account_id) {
                    $query->orWhere('chart_of_account_id', $account_id)->orWhere('bank_account_id', $bank_account_id);
                });
            } else {
                if ($account_id) {
                    $transaction = $transaction->where('chart_of_account_id', $account_id);
                }


                if ($bank_account_id) {
                    $transaction = $transaction->where('bank_account_id', $bank_account_id);
                }
            }
        }
        return $transaction;
    }

    public function makeTransaction($title, $type, $method, $default_for, $chart_account_id, $description, $class, $amount, $date, $creator, $id = null, $bank_id = null)
    {
        if ($bank_id) {
            return Transaction::create([
                'bank_account_id' => $bank_id,
                'title' => $title,
                'type' => $type,
                'payment_method' => $method,
                'come_from' => $default_for,
                'description' => $description,
                'morphable_id' => $class->id,
                'morphable_type' => $title == 'Invoice' ? Invoice::class : get_class($class),
                'amount' => $amount,
                'transaction_date' => $date,
                'created_by' => $creator,
            ]);
        } else {
            $chart_account = ChartOfAccount::where('id', $chart_account_id)->first();

            if ($chart_account) {
                if ($id) {
                    return Transaction::whereHasMorph('morphable', get_class($class), function ($query) use ($id) {
                        $query->where('id', $id);
                    })->update([
                        'amount' => $amount,
                    ]);
                } else {
                    return Transaction::create([
                        'chart_of_account_id' => $chart_account->id,
                        'title' => $title,
                        'type' => $type,
                        'payment_method' => $method,
                        'come_from' => $default_for,
                        'description' => $description,
                        'morphable_id' => $class->id,
                        'morphable_type' => $title == 'Invoice' ? Invoice::class : get_class($class),
                        'amount' => $amount,
                        'transaction_date' => $date,
                        'created_by' => $creator,
                    ]);
                }
            } else
                return false;
        }
    }

    public function totalIncome($date)
    {
        if (empty($date)) {
            return $this->transaction::where('type', 'in')->sum('amount');
        } else
            return $this->transaction::where('type', 'in')->whereBetween('transaction_date', $date)->sum('amount');
    }

    public function totalExpense($date)
    {
        if (empty($date))
            return $this->transaction::where('type', 'out')->sum('amount');
        else
            return $this->transaction::where('type', 'out')->whereBetween('transaction_date', $date)->sum('amount');
    }

    public function transactions($date, $type)
    {
        $check = 0;
        if (empty($date)) {
            $expenses = $this->transaction::selectRaw("sum(amount) as amount,type,transaction_date,DAYNAME(transaction_date) as day_name,DAY(transaction_date) as day,
             DATE_FORMAT(transaction_date,'%b') as month_name,DATE_FORMAT(transaction_date,'%m') as month,YEAR(transaction_date) as year");
        } else {
            $expenses = $this->transaction::whereBetween('transaction_date', $date)->selectRaw("sum(amount) as amount,type,transaction_date,DAYNAME(transaction_date) as day_name,DAY(transaction_date) as day,
             DATE_FORMAT(transaction_date,'%b') as month_name,DATE_FORMAT(transaction_date,'%m') as month,YEAR(transaction_date) as year");
        }

        if ($type == 'month_name') {
            $expenses->groupBy('month')->orderBy('month', 'asc');
            $check = 1;
        }
        if ($type == 'year') {
            $expenses->groupBy('year')->orderBy('year', 'asc');
            $check = 1;
        } elseif ($check == 0) {
            $expenses->groupBy('day')->orderBy('day', 'asc');
        }

        return $expenses->get();
    }

    public function incomeByDate($date, $type)
    {
        if ($type == 'month_name') {
            return $this->transaction::where('type', 'in')->whereMonth('transaction_date', Carbon::parse($date))->whereYear('transaction_date', Carbon::parse($date))->sum('amount');
        }
        if ($type == 'year') {
            return $this->transaction::where('type', 'in')->whereYear('transaction_date', Carbon::parse($date))->sum('amount');
        }
        return $this->transaction::where('type', 'in')->whereDate('transaction_date', Carbon::parse($date))->sum('amount');
    }

    public function expenseByDate($date, $type)
    {
        if ($type == 'month_name') {
            return $this->transaction::where('type', 'out')->whereMonth('transaction_date', Carbon::parse($date))->whereYear('transaction_date', Carbon::parse($date))->sum('amount');
        }
        if ($type == 'year') {
            return $this->transaction::where('type', 'out')->whereYear('transaction_date', Carbon::parse($date))->sum('amount');
        }
        return $this->transaction::where('type', 'out')->whereDate('transaction_date', Carbon::parse($date))->sum('amount');
    }
}
