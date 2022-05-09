@if (auth()->check() || session()->has('billing_address'))
    <form action="{{route('frontend.order_payment')}}" method="post" class="paypal_form_payment_23 d-none">
        @csrf
        <input type="hidden" name="method" value="Paypal">
        <input type="hidden" name="purpose" value="order_payment">
        <input type="hidden" name="amount" value="{{ $grandtotal }}">

        <button type="button" class="btn_1 order_submit_btn paypal_btn">{{ __('defaultTheme.process_to_payment') }}</button>
    </form>
@endif
