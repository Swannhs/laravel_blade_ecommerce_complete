@if(permissionCheck('refund_manage'))
@php
    $refund_admin = false;
    if(request()->is('refund/*') && !request()->is('refund/my-refund-list'))
    {
        $refund_admin = true;
    }
@endphp
<li class="{{ $refund_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,15)->position }}" data-status="{{ menuManagerCheck(1,15)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $refund_admin ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-shopping-cart"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('refund.refund_manage') }}</span>
        </div>
    </a>
    <ul id="refund_manage_ul">
        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @if (permissionCheck('refund.total_refund_list') && menuManagerCheck(2,15,'refund.total_refund_list')->status == 1)
            <li data-position="{{ menuManagerCheck(2,15,'refund.total_refund_list')->position }}">
                
                <a href="{{route('refund.total_refund_list')}}" @if (strpos(request()->getUri(),'all-pending-refund-request') != false) class="active" @endif>{{ __('refund.pending_refund_requests') }}</a>
                
            </li>
            @endif
            @if (permissionCheck('refund.confirmed_refund_requests') && menuManagerCheck(2,15,'refund.confirmed_refund_requests')->status == 1)
            <li data-position="{{ menuManagerCheck(2,15,'refund.confirmed_refund_requests')->position }}">        
                <a href="{{route('refund.confirmed_refund_requests')}}" @if (strpos(request()->getUri(),'all-confirmed-refund-request') != false) class="active" @endif>{{ __('refund.confirmed_refund_requests') }}</a>
            </li>
            @endif        
        @endif

        @if(permissionCheck('refund.my_refund_list') && menuManagerCheck(2,15,'refund.my_refund_list')->status == 1 && isModuleActive('MultiVendor'))
        <li data-position="{{ menuManagerCheck(2,15,'refund.my_refund_list')->position }}">
            <a href="{{route('refund.my_refund_list')}}" @if (strpos(request()->getUri(),'my-refund-request') != false) class="active" @endif>{{ __('refund.my_refund_requests') }}</a>
        </li>   
        @endif

        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @if (permissionCheck('refund.reasons_list') && menuManagerCheck(2,15,'refund.reasons_list')->status == 1)
            <li data-position="{{ menuManagerCheck(2,15,'refund.reasons_list')->position }}">
                <a href="{{route('refund.reasons_list')}}" @if (strpos(request()->getUri(),'reasons-list') != false) class="active" @endif>{{ __('refund.reasons') }}</a>
            </li> 
            @endif

            @if (permissionCheck('refund.process_index') && menuManagerCheck(2,15,'refund.process_index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,15,'refund.process_index')->position }}">
                <a href="{{route('refund.process_index')}}" @if (strpos(request()->getUri(),'refund-peocess') != false) class="active" @endif>{{ __('refund.refund_process') }}</a>
            </li>
            @endif
            @if (permissionCheck('refund.config') && menuManagerCheck(2,15,'refund.config')->status == 1)
                <li data-position="{{ menuManagerCheck(2,15,'refund.config')->position }}">
                    <a href="{{route('refund.config')}}" @if (request()->is('refund/configuration')) class="active" @endif>{{ __('refund.configuration') }}</a>
                </li>
            @endif
        @endif
    </ul>
</li>
@endif
