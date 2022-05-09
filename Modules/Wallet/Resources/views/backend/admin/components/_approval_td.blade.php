@if ($transaction->status == 1)
    <span>{{__('common.approved')}}</span>
@else
    <label class="switch_toggle" for="active_checkbox{{ $transaction->id }}">
        <input type="checkbox" id="active_checkbox{{ $transaction->id }}" @if ($transaction->status == 1) checked @endif value="{{ $transaction->id }}" @if (permissionCheck('wallet_charge.update_status')) data-id="{{ $transaction->id }}" class="update_status" @else disabled @endif>
        <div class="slider round"></div>
    </label>
@endif
