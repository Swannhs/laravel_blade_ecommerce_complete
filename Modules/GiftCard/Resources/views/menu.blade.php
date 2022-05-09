@if(permissionCheck('gift_card_manage'))
    @php
        $gift_card = false;
        if(strpos(request()->getUri(),'giftcard') != false)
        {
            $gift_card = true;
        }
    @endphp
    <li class="{{ $gift_card ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,11)->position }}" data-status="{{ menuManagerCheck(1,11)->status }}">
        <a href="javascript:void(0);" class="has-arrow" aria-expanded="{{ $gift_card ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-gift"></span>
            </div>
            <div class="nav_title">
                <span>{{__('common.gift_card')}}</span>
            </div>
        </a>
        <ul class="mm-collapse">
            @if (permissionCheck('admin.giftcard.get-data') && menuManagerCheck(2,11,'admin.giftcard.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,11,'admin.giftcard.index')->position }}">
                    <a href="{{route('admin.giftcard.index')}}" @if (strpos(request()->getUri(),'giftcard') != false) class="active" @endif>{{__('common.gift_card_list')}}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
