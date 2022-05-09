<div class="modal fade" id="FlutterWaveModal" tabindex="-1" role="dialog" aria-labelledby="FlutterWaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('payment_gatways.flutter_wave_payment') }}</h5>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <section class="send_query bg-white contact_form">
                    <form id="flatter_wave_form" action="{{route('my-wallet.store')}}" class="p-0" method="POST">
                        @csrf
                        <input type="hidden" name="method" value="flutterwave">
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">{{ __('common.name') }}<span class="text-danger">*</span></label>
                                <input type="text" class="primary_input4 form-control mb_20" placeholder="{{ __('common.name') }}" name="name" value="{{auth()->user()->first_name}}">
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">{{ __('common.email') }}<span class="text-danger">*</span></label>
                                <input type="email" name="email" class="primary_input4 form-control mb_20" placeholder="{{ __('common.email') }}" value="{{auth()->user()->email}}">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="row mb-20">
                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">{{ __('common.mobile') }}<span class="text-danger">*</span></label>
                                <input type="text" class="primary_input4 form-control mb_20" placeholder="{{ __('common.mobile') }}" name="phone" value="{{@old('phone')}}">
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <label for="name" class="mb-2">{{ __('common.amount') }}<span class="text-danger">*</span></label>
                                <input type="number" min="0" step="{{step_decimal()}}" value="{{ $recharge_amount }}" name="amount" class="primary_input4 form-control mb_20">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <input type="hidden" name="purpose" value="wallet recharge">
                        <div class="send_query_btn d-flex justify-content-between mt-4">
                            <button type="button" class="btn_1" data-dismiss="modal">{{ __('common.cancel') }}</button>
                            <button class="btn_1" type="submit" id="flatter_wave_submit_btn" disabled>{{ __('wallet.continue_to_recharge') }}</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
