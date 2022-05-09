@extends('frontend.default.auth.layouts.app')

@section('content')
<section class="pricing_part padding_top bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section_tittle">
                    <h2>{{$content->pricingTitle}}</h2>
                    @php echo $content->pricingDescription; @endphp
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="price_truggle d-flex">
                    <p>{{__('defaultTheme.monthly')}}</p>
                    <label class="switch-toggle outer">
                        <input id="pricingToggle" type="checkbox" />
                        <div></div>
                    </label>
                    <p class="pl-18">{{__('defaultTheme.yearly')}}</p>
                </div>
            </div>

            @foreach($pricing_plans as $key => $item)
            <div class="col-lg-4 col-md-6">
                <div class="single_pricing_part {{$item->is_featured?'product_tricker':''}}">
                    @if($item->is_featured == 1)<span
                        class="product_tricker_text">{{__('defaultTheme.best value')}}</span> @endif
                    <div class="pricing_header">
                        <h5>{{$item->name}}</h5>
                        <div class="monthly_price_div">
                            <h2>{{single_price($item->monthly_cost)}}</h2>
                            <p>{{__('defaultTheme.per month')}}</p>
                        </div>
                        <div class="yearly_price_div d-none">
                            <h2>{{single_price($item->yearly_cost)}}</h2>
                            <p>{{__('defaultTheme.per year')}}</p>
                        </div>
                    </div>
                    <ul>
                        <li>
                            {{ __('defaultTheme.team_member') }}
                            : {{$item->team_size}}</li>
                        <li>{{__('defaultTheme.products')}} : {{$item->stock_limit}}</li>
                        <li>{{__('defaultTheme.transaction charge')}} : {{$item->transaction_fee}} % </li>
                    </ul>
                    <a class="btn_2 select_btn_price" data-id='{{ $item->id }}'>{{__('defaultTheme.choose plan')}}</a>
                </div>
            </div>
            @endforeach
            <form class="price_subscription_add d-none"
                action="{{ route('frontend.merchant-register-subscription-type') }}" method="get">

                <input type="hidden" id="id" name="id" value="">
                <input type="hidden" id="type" name="type" value="">
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            $('#pricingToggle').on('change', function(){
                this.value = this.checked ? 1 : 0;
                if(this.value == 1){
                    $('#type').val('yearly');
                    $('.monthly_price_div').addClass('d-none');
                    $('.yearly_price_div').removeClass('d-none');
                }
                if(this.value == 0){
                    $('#type').val('monthly');
                    $('.yearly_price_div').addClass('d-none');
                    $('.monthly_price_div').removeClass('d-none');
                }
            });
            $(document).on('click','.select_btn_price', function(){
                event.preventDefault();
                $('#id').val($(this).attr("data-id"));
                $('.price_subscription_add').submit();
            });
        });
    })(jQuery);
</script>
@endpush
