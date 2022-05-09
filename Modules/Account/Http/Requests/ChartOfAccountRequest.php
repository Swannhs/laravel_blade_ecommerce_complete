<?php

namespace Modules\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChartOfAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->chart_of_account) {
            return [
                'name' => ['required', 'string', 'max:191', 'unique:chart_of_accounts,name,' . $this->chart_of_account],
                'code' => ['sometimes', 'nullable', 'string', 'max:191', 'unique:chart_of_accounts,code,' . $this->chart_of_account],
                'description' => ['sometimes', 'nullable', 'string'],
                'opening_balance' => ['sometimes', 'nullable', 'numeric'],
                'default_for' => [
                    'sometimes', 'nullable', 'string',
                    Rule::in(get_account_var('list')['account_default_for']),
                ],
                'status' => ['sometimes', 'boolean'],
            ];
        }

        return [
            'parent_id' => [
                'sometimes', 'nullable', 'integer',
                Rule::exists('chart_of_accounts', 'id')->where(function ($query) {
                    return $query->where('status', 1);
                })
            ],
            'name' => ['required', 'string', 'max:191', 'unique:chart_of_accounts,name,' . $this->chart_of_account],
            'code' => ['sometimes', 'nullable', 'string', 'max:191', 'unique:chart_of_accounts,code,' . $this->chart_of_account],
            'type' => [
                Rule::requiredIf(!$this->parent_id),
                Rule::in(get_account_var('list')['account_type']),
                'string', 'max:191'
            ],
            'description' => ['sometimes', 'nullable', 'string'],
            'opening_balance' => ['sometimes', 'nullable', 'numeric'],

            'default_for' => [
                'sometimes', 'nullable', 'string',
                Rule::in(get_account_var('list')['account_default_for']),
            ],
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
            'parent_id' => trans('account.Parent Account'),
            'name' => trans('account.Name'),
            'code' => trans('account.Code'),
            'type' => trans('account.Type'),
            'opening_balance' => trans('account.Opening Balance'),
            'description' => trans('common.Description'),
            'default_for' => trans('account.Default for'),
            'status' => trans('common.Status'),
        ];
    }
}
