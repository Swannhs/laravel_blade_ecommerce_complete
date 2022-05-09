<p><strong>{{ $review->review }}</strong></p>
<div class="row mt-10">
    <div class="product_img_div">
        <img class="product_img" src="{{ asset(asset_path($review->product->product->thumbnail_image_source)) }}" alt="">
    </div>
    
    <p>{{ $review->product->product->product_name }}</p>
</div>
