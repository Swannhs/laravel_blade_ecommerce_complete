@if ($transaction->status == 0)
    <div class="dropdown CRM_dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ __('common.select') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
            <a class="dropdown-item edit_modal" data-value="{{ $transaction }}">{{__('common.edit')}}</a>
        </div>
    </div>
@else
    <p>{{__('common.approved')}}</p>
@endif