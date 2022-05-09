@if (permissionCheck('marketing_module'))
    @php
        $marketting_admin = false;
        if(request()->is('marketing/*'))
        {
            $marketting_admin = true;
        }
    @endphp
    <li class="{{ $marketting_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,10)->position }}" data-status="{{ menuManagerCheck(1,10)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $marketting_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-user"></span>
            </div>
            <div class="nav_title">
                <span>{{__('marketing.marketing')}}</span>
            </div>
        </a>
        <ul id="marketing_ul">
            @if (permissionCheck('marketing.flash-deals') && menuManagerCheck(2,10,'marketing.flash-deals')->status == 1)
                <li data-position="{{ menuManagerCheck(2,10,'marketing.flash-deals')->position }}">
                    <a href="{{ route('marketing.flash-deals') }}" @if (strpos(request()->getUri(),'flash-deals') != false) class="active" @endif>{{__('marketing.flash_deals')}}</a>
                </li>
            @endif
            @if (permissionCheck('marketing.coupon.get-data') && menuManagerCheck(2,10,'marketing.coupon.get-data')->status == 1)
                <li data-position="{{ menuManagerCheck(2,10,'marketing.coupon.get-data')->position }}">
                    <a href="{{route('marketing.coupon')}}" @if (strpos(request()->getUri(),'coupon') != false) class="active" @endif>{{__('marketing.coupons')}}</a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
                @if (permissionCheck('marketing.new-user-zone') && menuManagerCheck(2,10,'marketing.new-user-zone')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,10,'marketing.new-user-zone')->position }}">
                        <a href="{{ route('marketing.new-user-zone') }}" @if (strpos(request()->getUri(),'new-user-zone') != false) class="active" @endif>{{__('marketing.new_user_zone')}}</a>
                    </li>
                @endif
                @if (permissionCheck('marketing.news-letter') && menuManagerCheck(2,10,'marketing.news-letter.get-data')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,10,'marketing.news-letter.get-data')->position }}">
                        <a href="{{route('marketing.news-letter')}}" @if (strpos(request()->getUri(),'news-letter') != false) class="active" @endif>{{__('marketing.news_letters')}}</a>
                    </li>
                @endif
                @if (permissionCheck('marketing.bulk-sms.get-data') && menuManagerCheck(2,10,'marketing.bulk-sms.get-data')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,10,'marketing.bulk-sms.get-data')->position }}">
                        <a href="{{route('marketing.bulk-sms')}}" @if (strpos(request()->getUri(),'bulk-sms') != false) class="active" @endif>{{__('marketing.bulk_sms')}}</a>
                    </li>
                @endif
                @if (permissionCheck('marketing.subscriber.get-data') && menuManagerCheck(2,10,'marketing.subscriber.get-data')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,10,'marketing.subscriber.get-data')->position }}">
                        <a href="{{ route('marketing.subscriber') }}" @if (strpos(request()->getUri(),'subscriber') != false) class="active" @endif>{{__('marketing.subscribers')}}</a>
                    </li>
                @endif
                @if (permissionCheck('marketing.referral-code.get-data') && menuManagerCheck(2,10,'marketing.referral-code.get-data')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,10,'marketing.referral-code.get-data')->position }}">
                        <a href="{{route('marketing.referral-code')}}" @if (strpos(request()->getUri(),'referral-code') != false) class="active" @endif>{{__('marketing.referral_code_setup')}}</a>
                    </li>
                @endif
                @if (permissionCheck('marketing.configuration') && menuManagerCheck(2,10,'marketing.configuration')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,10,'marketing.configuration')->position }}">
                        <a href="{{route('marketing.configuration')}}" @if (strpos(request()->getUri(),'referral-code') != false) class="active" @endif>{{__('common.configuration')}}</a>
                    </li>
                @endif
            @endif
        </ul>
    </li>
@endif
