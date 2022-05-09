@if (auth()->check() || session()->has('billing_address'))
    <form action="{{route('frontend.order_payment')}}" method="post" id="paystack_form" class="paystack_form d-none">
        @csrf
        <input type="hidden" name="email" value="{{(auth()->check()) ? auth()->user()->email : session()->get('billing_address')['email']}}"> {{-- required --}}
        <input type="hidden" name="orderID" value="{{md5(uniqid(rand(), true))}}">
        <input type="hidden" name="amount" value="{{ $grandtotal*100}}">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="currency" value="NGN">

        <input type="hidden" name="method" value="Paystack">

        <button type="submit" class="btn_1 order_submit_btn">{{ __('defaultTheme.process_to_payment') }}</button>

    </form>
@endif
