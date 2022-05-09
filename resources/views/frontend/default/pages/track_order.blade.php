@extends('frontend.default.layouts.app')

@section('content')

@include('frontend.default.partials._breadcrumb')
<section class="dashboard_part bg-white padding_top padding_bottom">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-xl-8">
                <form action="{{ route('frontend.order.track_find') }}" method="post">
                    @csrf
                    <div class="delivery_details_wrapper">
                        <div class="delivery_details_top text-center mb-3">
                            <h3>{{ __('defaultTheme.track_your_order') }}</h3>
                            <p>{{ __('defaultTheme.enter_your_order_tracking_number_and_your_secret_id') }}</p>
                        </div>
                        <div class="delivery_details_box mb-4">
                            <div class="order_texts row">
                                <div class="col-12">
                                    <label for="Shop">{{ __('defaultTheme.order_tracking_number') }}<span
                                            class="text-red">*</span> </label>
                                    <input class="form-control" type="text" id="order_number" name="order_number"
                                        value="{{old('order_number')}}"
                                        placeholder="{{ __('defaultTheme.order_tracking_number') }}">
                                    @error('order_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @guest
                            @if(app('general_setting')->track_order_by_secret_id)
                                <div class="delivery_details_box mb-4">
                                    <div class="order_texts row">
                                        <div class="col-12">
                                            <label for="Shop">{{ __('defaultTheme.secret_id_only_for_guest_user') }}<span
                                                    class="text-red">*</span> </label>
                                            <input required class="form-control" type="text" id="guest_id" name="secret_id"
                                                placeholder="{{ __('defaultTheme.secret_id_only_for_guest_user') }}"
                                                value="{{old('secret_id')}}">
                                            @error('secret_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endguest
                        

                        <div class="continue_shoping text-center">
                            <button type="submit" class="btn_1">{{ __('common.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection
