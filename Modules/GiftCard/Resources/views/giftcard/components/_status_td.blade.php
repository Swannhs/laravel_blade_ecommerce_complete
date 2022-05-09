<label class="switch_toggle" for="checkbox_{{ $card->id }}">
    <input type="checkbox" id="checkbox_{{ $card->id }}" class="status_change" {{$card->status?'checked':''}} value="{{$card->id}}" data-id="{{$card->id}}">
    <div class="slider round"></div>
</label>