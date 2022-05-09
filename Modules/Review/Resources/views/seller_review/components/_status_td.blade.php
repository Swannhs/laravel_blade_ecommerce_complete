@if($review->status == 1)
<span class="badge_1">{{__('common.approved')}}</span>
@elseif($review->status == 0)
<span class="badge_2">{{__('common.pending')}}</span>
@elseif($review->status == 1)
<span class="badge_1">{{__('common.declined')}}</span>
@endif