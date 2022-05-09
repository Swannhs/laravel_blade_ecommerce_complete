<?php

namespace Modules\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'bank_name' => ['required', 'string', 'max:191'],
            'branch_name' => ['required', 'string', 'max:191'],
            'account_name' => ['required', 'string', 'max:191'],
            'account_number' => ['required', 'string', 'max:191', 'unique:bank_accounts,account_number,' . $this->bank_account],
            'opening_balance' => ['sometimes', 'nullable', 'numeric'],
            'description' => ['sometimes', 'nullable', 'string', 'max:500'],
            'status' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'bank_name' => trans('bank_account.Bank Name'),
            'branch_name' => trans('bank_account.Branch Name'),
            'name' => trans('bank_account.Account Name'),
            'code' => trans('bank_account.Account Number'),
            'opening_balance' => trans('account.Opening Balance'),
            'description' => trans('common.Description'),
            'status' => trans('common.status'),
        ];
    }
}
