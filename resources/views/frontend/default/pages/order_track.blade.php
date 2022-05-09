@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{ __('defaultTheme.track') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  id track part here -->
<section class="id_track bg-white padding_top">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="id_track_iner ">
                    <h5>{{ __('defaultTheme.track_your_order') }}</h5>
                    <div class="col-auto">
                        <label for="order">{{ __('common.order_id') }}</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="order" placeholder="{{ __('common.order_id') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">{{ __('defaultTheme.track_order') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  id track part end -->

@endsection
