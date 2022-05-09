
    <div class="product_page_tittle d-flex justify-content-between">
        <h4 class="text-white mb-3" >{{@$coupon->coupon->title}}</h4>
    </div>
    <div class="coupon_box">
        <div class="coupon_box_left">
            <div class="coupon_box_left_inner">
                @if(@$coupon->coupon->discount_type == 1)
                    <h2>{{single_price(@$coupon->coupon->discount)}}</h2>
                @else
                    <h2>{{@$coupon->coupon->discount}} %</h2>
                @endif
                <div class="coupon_text">
                    <h3>{{__('defaultTheme.orders_over')}} {{single_price(@$coupon->coupon->minimum_shopping)}}</h3>

                    <p>{{date(app('general_setting')->dateFormat->format, strtotime(@$coupon->coupon->start_date))}} - {{date(app('general_setting')->dateFormat->format, strtotime(@$coupon->coupon->end_date))}}</p>
                </div>
            </div>
            <div class="sawtooth-left"></div>
        </div>
        <div class="coupon_box_right">

            @if(auth()->check())
                @if($coupon_store_check == 0)
                    <input type="hidden" id="coupon_id" value="{{@$coupon->coupon->id}}">
                    <a id="get_now_btn" class="btn_1">{{__('defaultTheme.get_now')}}</a>
                @else
                <a id="javascript:void(0);" class="btn_1" >{{__('defaultTheme.time_to_shop')}}</a>
                @endif

            @else
                <a href="{{url('/login')}}" class="btn_1">{{__('defaultTheme.get_now')}}</a>
            @endif
            <div class="sawtooth-right"></div>
        </div>
    </div>
