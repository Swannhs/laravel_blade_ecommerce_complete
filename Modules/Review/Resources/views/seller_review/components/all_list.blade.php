<div class="">
    
    <table class="table" id="allReviewTable">
        <thead>
            <tr>
                <th scope="col" width="5%">{{ __('common.sl') }}</th>
                <th scope="col" width="10%">@if(isModuleActive('MultiVendor')){{ __('common.seller') }}@else {{__('common.company_info')}} @endif</th>
                <th scope="col" width="15%">{{ __('review.rating') }}</th>
                <th scope="col" width="30%">{{ __('review.customer_feedback') }}</th>
                <th scope="col" width="10%">{{ __('common.status') }}</th>
                <th scope="col" width="15%">{{ __('review.customer_time') }}</th>
                <th scope="col" width="15%">{{ __('review.approve') }}<br>
                    
                </th>
            </tr>
        </thead>
        
    </table>
</div>
