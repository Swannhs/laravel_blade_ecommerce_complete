<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{__('common.select')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
         
         <a class="dropdown-item" href="{{ route('seller.support-ticket.show',$TicketList->id)}}"> {{__('common.show')}}</a>
         
        <a class="dropdown-item" href="{{ route('seller.support-ticket.edit',$TicketList->id)}}"> {{__('common.edit')}}</a>
        
        

    </div>
</div>