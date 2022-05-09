@if ($activity->type == 0)
    <span class="badge_4">{{ __('common.error') }}</span>
@elseif ($activity->type == 1)
    <span class="badge_1">{{ __('common.success') }}</span>
@elseif ($activity->type == 2)
    <span class="badge_3">{{ __('common.warning') }}</span>
@else
    <span class="badge_2">{{ __('common.info') }}</span>
@endif
