
<div class="product_thumb_div">
    @if ($products->thumbnail_image_source != null)
        <img class="productImg" src="{{showImage($products->thumbnail_image_source)}}" alt="{{$products->product_name}}">
    @else
        <img class="productImg" src="{{showImage('frontend/img/no_image.png')}}" alt="{{$products->product_name}}">
    @endif
</div>
