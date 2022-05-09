<label class="switch_toggle" for="switch_checkbox{{ $value->id }}">
    <input type="checkbox" id="switch_checkbox{{ $value->id }}" @if ($value->status == 1) checked @endif value="{{ $value->id }}" data-value="{{$value}}" class="status_change">
    <div class="slider round"></div>
</label>
