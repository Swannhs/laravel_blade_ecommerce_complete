<div class="time_div">
    <h5>{{ $review->is_anonymous == 1 ? 'Unknown Name' : $review->customer->first_name . ' ' . $review->customer->last_name }}</h5>
    <p>{{ date(app('general_setting')->dateFormat->format, strtotime($review->created_at)) }}</p>
</div>
