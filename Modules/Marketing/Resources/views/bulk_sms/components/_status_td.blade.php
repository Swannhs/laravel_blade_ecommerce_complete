@if ($message->is_send == 1)
    <span class="badge_1">{{ __('common.published') }}</span>
@else
    <span class="badge_2">{{ __('common.pending') }}</span>
@endif
