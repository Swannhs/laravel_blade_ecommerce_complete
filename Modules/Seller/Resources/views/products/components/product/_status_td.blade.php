<label class="switch_toggle" for="checkbox{{$status_slider}}{{ $products->id }}">
    <input type="checkbox" id="checkbox{{$status_slider}}{{ $products->id }}" {{$products->status?'checked':''}} value="{{$products->id}}" class="product_status_change">
    <div class="slider round"></div>
</label>