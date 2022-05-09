@if (auth()->check() || session()->has('billing_address'))
<form action="{{route('frontend.order_payment')}}" method="POST" id="razor_form" class="razor_form d-none">
    <input type="hidden" name="method" value="RazorPay">
    <input type="hidden" name="amount" value="{{ $grandtotal * 100 }}">


    <button type="submit" class="btn_1 order_submit_btn">{{ __('defaultTheme.process_to_payment') }}</button>
    @csrf
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZOR_KEY') }}"
        data-amount="{{ $grandtotal * 100 }}" data-name="{{str_replace('_', ' ',config('app.name') ) }}"
        data-description="Order Total" data-image="{{asset(asset_path(app('general_setting')->favicon))}}"
        data-prefill.name="{{ (auth()->check()) ? auth()->user()->username : session()->get('billing_address')['name'] }}"
        data-prefill.email="{{ (auth()->check()) ? auth()->user()->email : session()->get('billing_address')['email'] }}"
        data-theme.color="#ff7529">
    </script>
</form>
@endif
