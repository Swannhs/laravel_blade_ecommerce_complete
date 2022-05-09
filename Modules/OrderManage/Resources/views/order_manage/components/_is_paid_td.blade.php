@if ($order->is_paid == 1)
    <h6><span class="badge_1">{{__('common.paid')}}</span></h6>
@else
    <h6><span class="badge_4">{{__('common.pending')}}</span></h6>
@endif
