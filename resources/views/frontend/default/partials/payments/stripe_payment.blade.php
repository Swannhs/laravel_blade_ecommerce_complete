@if (auth()->check() || session()->has('billing_address'))
    <form action="{{route('frontend.order_payment')}}" method="post" id="stripe_form" class="stripe_form d-none">
        <input type="hidden" name="method" value="Stripe">
        <input type="hidden" name="amount" value="{{$grandtotal}}">
        <button type="submit" class="btn_1 order_submit_btn">{{ __('defaultTheme.process_to_payment') }}</button>
        @csrf
        <script
            src="https://checkout.stripe.com/checkout.js"
            class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-name="Stripe Payment"
            data-image="{{asset(asset_path(app('general_setting')->favicon))}}"
            data-locale="auto"
            data-currency="usd">
        </script>
    </form>
@endif
