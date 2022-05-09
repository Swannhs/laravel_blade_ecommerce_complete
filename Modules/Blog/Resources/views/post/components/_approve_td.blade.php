@if (is_admin_user(auth()->user()->role_id))
    <label class="switch_toggle" for="active_checkbox{{ $value->id }}">
        <input type="checkbox" id="active_checkbox{{ $value->id }}" @if ($value->is_approved == 1) checked disabled {{ $value->is_approved ? 'checked' : '' }}@endif class="approved" data-value="{{ $value }}" value="{{ $value->id }}">
        <div class="slider round"></div>
    </label>
@else
    <label class="switch_toggle disabled" for="active_checkbox{{ $value->id }}">
        <input type="checkbox" id="active_checkbox{{ $value->id }}" @if ($value->is_approved == 1) checked @endif value="{{ $value->id }}" disabled {{ $value->is_approved ? 'checked' : '' }}>
        <div class="slider round"></div>
    </label>
@endif
