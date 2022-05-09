@if(permissionCheck('support_tickets'))
@php
$support_ticket_admin = false;
if(strpos(request()->getUri(),'ticket') != false)
{
$support_ticket_admin = true;
}
@endphp
<li class="{{ $support_ticket_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,21)->position }}" data-status="{{ menuManagerCheck(1,21)->status }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="{{ $support_ticket_admin ? 'true' : 'false' }}">
        <div class="nav_icon_small">
            <span class="fas fa-wrench"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('ticket.support_ticket')}}</span>
        </div>
    </a>
    <ul id="support_ticket_ul">
        @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
            @if(permissionCheck('ticket.tickets.index') && menuManagerCheck(2,21,'ticket.tickets.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,21,'ticket.tickets.index')->position }}">
                    <a href="{{route('ticket.tickets.index')}}" @if (request()->is('admin/ticket/tickets')) class="active"
                        @endif>{{ __('ticket.support_ticket')}}</a>
            </li>
            @endif
            @if(permissionCheck('ticket.category.index') && menuManagerCheck(2,21,'ticket.category.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,21,'ticket.category.index')->position }}">
                    <a href="{{ route('ticket.category.index') }}" @if (request()->is('admin/ticket/categories')) class="active"
                        @endif>{{ __('common.category')}}</a>
                </li>
            @endif
            @if(permissionCheck('ticket.priority.index') && menuManagerCheck(2,21,'ticket.priority.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,21,'ticket.priority.index')->position }}">
                    <a href="{{ route('ticket.priority.index') }}" @if (request()->is('admin/ticket/priorities')) class="active"
                        @endif>{{ __('ticket.priority')}}</a>
                </li>
            @endif
            @if(permissionCheck('ticket.status.index') && menuManagerCheck(2,21,'ticket.status.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,21,'ticket.status.index')->position }}">
                    <a href="{{ route('ticket.status.index') }}" @if (request()->is('admin/ticket/status')) class="active"
                        @endif>{{ __('common.status')}}</a>
                </li>
            @endif
            @if(permissionCheck('ticket.my_ticket') && menuManagerCheck(2,21,'ticket.my_ticket')->status == 1)
            
                <li data-position="{{ menuManagerCheck(2,21,'ticket.my_ticket')->position }}">
                    <a href="{{ route('ticket.my_ticket') }}" @if (request()->is('admin/ticket/assigned-ticket')) class="active"
                        @endif>{{ __('ticket.my_tickets')}}</a>
                </li>
            @endif
        @endif
        @if(auth()->check() && auth()->user()->role->type == "seller" && menuManagerCheck(2,21,'seller.support-ticket.index')->status == 1 && isModuleActive('MultiVendor'))
            <li data-position="{{ menuManagerCheck(2,21,'seller.support-ticket.index')->position }}">
                <a href="{{ route('seller.support-ticket.index') }}">{{ __('ticket.my_tickets')}}</a>
            </li>
        @endif

    </ul>
</li>
@endif
