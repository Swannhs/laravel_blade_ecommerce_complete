<label class="switch_toggle" for="checkbox{{ $states->id }}">
    <input type="checkbox" id="checkbox{{ $states->id }}" @if (permissionCheck('setup.state.status')) class="status_change" {{$states->status?'checked':''}} value="{{$states->id}}" data-id="{{$states->id}}" @else disabled @endif>
    <div class="slider round"></div>
</label>
