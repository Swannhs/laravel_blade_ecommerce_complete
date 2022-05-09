<div class="single-meta">
    <div class="d-flex justify-content-between assign-user">
       <form action="{{ route('ticket.assign.user') }}" method="POST" class="assign_form">
           @method('PUT')
           @csrf
           <select class="niceSelect w-100 bb form-control{{ $errors->has('refer_id') ? ' is-invalid' : '' }}" name="refer_id">
                    <option value="" disabled>{{__('ticket.agent_asign')}}</option>
                    <option value="0">{{__('ticket.unassigned')}}</option>
                @foreach($AgentList as $item)
                    <option value="{{$item->id}}" {{isset($TicketList->refer_id)? ($item->id == $TicketList->refer_id? 'selected':''):''}}>{{ $item->name }} [{{ $item->email }}]</option>
                @endforeach
            </select>
                @if ($errors->has('refer_id'))
            <span class="invalid-feedback invalid-select" role="alert">
                <strong>{{ $errors->first('refer_id') }}</strong>
            </span>
            @endif
            <input type="hidden" name="ticket_id" value="{{ $TicketList->id}}">
            <br>
            <br>
            <button class="primary-btn small fix-gr-bg" type="submit"> {{__('common.update')}}</button>
       </form>
    </div>
</div>