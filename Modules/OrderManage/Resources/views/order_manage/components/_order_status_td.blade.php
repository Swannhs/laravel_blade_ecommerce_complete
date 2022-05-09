@if ($order->is_confirmed == 1)
    <h6><span class="badge_1">{{__('common.confirmed')}}</span></h6>
@elseif ($order->is_confirmed == 2)
    <h6><span class="badge_4">{{__('common.declined')}}</span></h6>
@else
    <h6><span class="badge_4">{{__('common.pending')}}</span></h6>
@endif
