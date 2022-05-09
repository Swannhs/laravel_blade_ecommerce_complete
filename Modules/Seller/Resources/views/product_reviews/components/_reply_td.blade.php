@if ($review->reply)
<strong>{{ substr(@$review->reply->review, 0, 30) }} ....</strong>
<p>{{ date(app('general_setting')->dateFormat->format, strtotime(@$review->reply->created_at)) }}</p>
@else
@if (permissionCheck('seller.product-reviews.reply'))
<a href="" class="primary-btn radius_30px mr-10 fix-gr-bg text-white reply_btn" data-id="{{ $review->id }}">{{__('review.reply')}}</a>
@else
<a href="javascript:void(0)"
    class="primary-btn radius_30px mr-10 fix-gr-bg text-white">{{ __('common.disabled') }}</a>
@endif
@endif
