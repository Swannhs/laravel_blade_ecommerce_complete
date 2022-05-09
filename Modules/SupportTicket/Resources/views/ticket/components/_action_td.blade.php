<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{__('common.select')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
         @if(permissionCheck('ticket.tickets.show'))
         <a class="dropdown-item" href="{{ route('ticket.tickets.show',$TicketList->id)}}"> {{__('common.show')}}</a>
         @endif


         @if(permissionCheck('ticket.tickets.edit'))
        <a class="dropdown-item" href="{{ route('ticket.tickets.edit',$TicketList->id)}}"> {{__('common.edit')}}</a>
        @endif

        @if(permissionCheck('ticket.tickets.destroy'))
        <a class="dropdown-item delete_ticket" data-id="{{$TicketList->id}}">{{__('common.delete')}}</a>
        @endif


    </div>
</div>
