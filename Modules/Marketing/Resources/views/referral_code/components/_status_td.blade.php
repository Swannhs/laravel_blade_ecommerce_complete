<label class="switch_toggle" for="checkbox_{{ $code->id }}">
    <input type="checkbox" id="checkbox_{{ $code->id }}" {{$code->status?'checked':''}} @if(permissionCheck('marketing.referral-code.status')) value="{{$code->id}}" class="status_change_referral" @else disabled @endif>
    <div class="slider round"></div>
</label>
