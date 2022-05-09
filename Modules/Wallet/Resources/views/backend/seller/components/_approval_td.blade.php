@if ($transaction->status == 1)
    <span class="badge_1">{{__('common.approved')}}</span>
@else
    <span class="badge_4">{{__('common.pending')}}</span>
@endif
