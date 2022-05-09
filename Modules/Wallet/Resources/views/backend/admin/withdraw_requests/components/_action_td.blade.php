<a class="primary-btn radius_30px mr-10 fix-gr-bg link_btn getDetails" @if (permissionCheck('wallet.withdraw_requests.show')) data-id="{{ $transaction->id }} @endif">{{__('wallet.show_details')}}</a>
