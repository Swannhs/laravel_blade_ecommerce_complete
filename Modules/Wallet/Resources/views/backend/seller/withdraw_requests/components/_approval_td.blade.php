@if ($transaction->status == 1)
    <span class="badge_1">{{__('common.approved')}}</span>
@elseif ($transaction->status == 2)
    <span class="badge_4">{{__('common.declined')}}</span>
@else
    <span class="badge_4">{{__('common.pending')}}</span>
@endif
