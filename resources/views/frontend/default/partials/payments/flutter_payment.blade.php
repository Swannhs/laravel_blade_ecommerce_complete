@if (auth()->check() || session()->has('billing_address'))
    <div class="modal fade" id="flutterModal" tabindex="-1" role="dialog" aria-labelledby="flutterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('payment_gatways.flutter_wave_payment') }}</h5>
                </div>
                <div class="modal-body">
                    <section class="send_query bg-white contact_form">
                        <form id="contactForm" enctype="multipart/form-data" action="{{route('frontend.order_payment')}}" class="p-0" method="POST">
                            @csrf
                            <input type="hidden" name="method" value="flutterwave">
                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <label for="name" class="mb-2">{{ __('common.name') }}<span>*</span></label>
                                    <input type="text" required class="primary_input4 form-control mb_20" placeholder="{{ __('common.name') }}" name="name" value="{{(auth()->check()) ? auth()->user()->first_name : session()->get('billing_address')['name']}}">
                                    <span class="invalid-feedback" role="alert" id="name"></span>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <label for="name" class="mb-2">{{ __('common.email') }}<span>*</span></label>
                                    <input type="email" required name="email" class="primary_input4 form-control mb_20" placeholder="{{ __('common.email') }}" value="{{(auth()->check()) ? auth()->user()->email : session()->get('billing_address')['email']}}">
                                    <span class="invalid-feedback" role="alert" id="email"></span>
                                </div>
                            </div>
                            <div class="row mb-20">
                                <div class="col-xl-6 col-md-6">
                                    <label for="name" class="mb-2">{{ __('common.mobile') }}<span>*</span></label>
                                    <input type="text" required class="primary_input4 form-control mb_20" placeholder="{{ __('common.mobile') }}" name="phone" value="{{@old('phone')}}">
                                    <span class="invalid-feedback" role="alert" id="phone"></span>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <label for="name" class="mb-2">{{ __('common.amount') }}<span>*</span></label>
                                    <input type="number" min="0" step="{{step_decimal()}}" value="{{ $grandtotal }}" id="amount" name="amount" class="primary_input4 form-control mb_20">
                                    <span class="invalid-feedback" role="alert" id="name"></span>
                                </div>
                            </div>
                            <input type="hidden" name="purpose" value="order checkout">
                            <div class="send_query_btn d-flex justify-content-between mt-4">
                                <button type="button" class="btn_1" data-dismiss="modal">{{ __('common.cancel') }}</button>
                                <button class="btn_1" type="submit">{{ __('wallet.continue_to_pay') }}</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endif