<label class="switch_toggle" for="checkbox{{ $cities->id }}">
    <input type="checkbox" id="checkbox{{ $cities->id }}" @if(permissionCheck('setup.city.status')) class="status_change" {{$cities->status?'checked':''}} value="{{$cities->id}}" data-id="{{$cities->id}}" @else disabled @endif>
    <div class="slider round"></div>
</label>
