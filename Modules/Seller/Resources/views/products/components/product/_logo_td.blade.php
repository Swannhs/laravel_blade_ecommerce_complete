<div class="product_img_div">
    @if ($products->thum_img != null)
        <img src="{{ showImage($products->thum_img) }}" alt="{{ $products->product->product_name }}">
    @elseif ($products->product->thumbnail_image_source != null)
        <img src="{{ showImage($products->product->thumbnail_image_source) }}"
            alt="{{ $products->product->product_name }}">
    @else
        <img src="{{ showImage('frontend/img/no_image.png') }}"
            alt="{{ $products->product->product_name }}">
    @endif
</div>
