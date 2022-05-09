<label class="switch_toggle" for="checkbox_{{ $subscriber->id }}">
    <input type="checkbox" id="checkbox_{{ $subscriber->id }}" {{$subscriber->status?'checked':''}} @if(permissionCheck('marketing.subscriber.status')) value="{{$subscriber->id}}" class="status_change_subscription" @else disabled @endif>
    <div class="slider round"></div>
</label>
