@extends('frontend.default.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/review.css'))}}" />

@endsection
@section('breadcrumb')
    {{ __('defaultTheme.write_review') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')

            <div class="col-lg-8 col-xl-9">
                <form action="{{route('frontend.profile.review.store')}}" method="POST" enctype="multipart/form-data" id="main_form">
                    @csrf
                    <div class="customer_review_wrapper">
                        <div class="customer_review_wrapper_inner">
                            <!-- customer_review_left  -->
                            <div class="customer_review_left">
                                <div class="review_box">
                                    <span class="deliverd_date" >

                                        {{ __('defaultTheme.delivered_on') }}
                                        {{date('dS M- Y',strtotime($package->updated_at))}}</span>
                                    <h6 class="subtitle" >{{ __('defaultTheme.rate_and_review_purchased_product') }}:</h6>

                                    <input type="hidden" id="product_length" value="{{count($package->products)}}">

                                    @foreach($package->products as $key => $product)
                                        @if($product->type == 'product')
                                        <div class="product_item_box">
                                            <div class="thumb">
                                                <img src="{{showImage(@$product->seller_product_sku->product->product->thumbnail_image_source)}}" alt="">
                                                <input type="hidden" name="product_id[]" value="{{@$product->seller_product_sku->product->id}}">
                                                <input type="hidden" name="product_type[]" value="{{@$product->type}}">
                                            </div>
                                            <div class="product_item_dTails w-100">
                                                <div class="product_item_info">
                                                    <h4>{{@$product->seller_product_sku->product->product->product_name}}</h4>

                                                    <div class="star_icon d-flex align-items-center">
                                                        <a class="rating">
                                                        <input type="radio" id="product_star_{{$key}}_5" name="product_rating_{{@$product->seller_product_sku->product->id}}" checked value="5" class="rating"><label class="full product_rating" for="product_star_{{$key}}_5" id="star5" title="Delightful - 5 stars" data-rate="5"></label>
                                                        <input type="radio" id="product_star_{{$key}}_4" name="product_rating_{{@$product->seller_product_sku->product->id}}" value="4" class="rating"><label class="full product_rating" for="product_star_{{$key}}_4" title="Satisfactory - 4 stars" data-rate="4"></label>
                                                        <input type="radio" id="product_star_{{$key}}_3" name="product_rating_{{@$product->seller_product_sku->product->id}}" value="3" class="rating"><label class="full product_rating" for="product_star_{{$key}}_3" title="Neutral - 3 stars" data-rate="3"></label>
                                                        <input type="radio" id="product_star_{{$key}}_2" name="product_rating_{{@$product->seller_product_sku->product->id}}" value="2" class="rating"><label class="full product_rating" for="product_star_{{$key}}_2" title="Poor - 2 stars" data-rate="2"></label>
                                                        <input type="radio" id="product_star_{{$key}}_1" name="product_rating_{{@$product->seller_product_sku->product->id}}" value="1" class="rating"><label class="full product_rating" for="product_star_{{$key}}_1" title="Very Poor - 1 star" data-rate="1"></label>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="send_query ">
                                                    <div class="form-group">
                                                        <textarea id="textarea_{{$key}}" placeholder="{{ __('defaultTheme.please_share_your_feedback_about_the_product') }}" name="product_review[]" spellcheck="false"></textarea>
                                                        <span class="text-red" id="error_textarea_{{$key}}"></span>
                                                    </div>
                                                </div>
                                                <div class="photo_uploader_lists">
                                                    <div class="row">

                                                        <div class="col-lg-12">
                                                            <div class="img_upload_group d-flex align-items-center flex-wrap">
                                                                <div class="flex-wrap img_upload_div" id="img_upload_div_{{$key}}">

                                                                </div>
                                                                <label for="photo_{{$key}}" class="photo_uploader">
                                                                    <i class="fas fa-camera"></i>
                                                                    <p id="count_{{$key}}">0/6</p>
                                                                    <input class="d-none upload_img_for_product" type="file" id="photo_{{$key}}" name="product_images_{{@$product->seller_product_sku->product->id}}[]" data-upload_div="#img_upload_div_{{$key}}" data-count="#count_{{$key}}" max="6" multiple>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="review_guidelines">
                                                    <h4>{{ __('defaultTheme.important') }}</h4>
                                                    <p>{{ __('defaultTheme.maximum_6_images_can_be_uploaded') }}</p>
                                                    <p>{{ __('defaultTheme.image_size_can_be_maximum_5mb') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="product_item_box">
                                            <div class="thumb">
                                                <img src="{{showImage(@$product->giftCard->thumbnail_image)}}" alt="">
                                                <input type="hidden" name="product_id[]" value="{{@$product->giftcard->id}}">
                                                <input type="hidden" name="product_type[]" value="{{@$product->type}}">
                                            </div>
                                            <div class="product_item_dTails w-100">
                                                <div class="product_item_info">
                                                    <h4>{{@$product->giftCard->name}}</h4>

                                                    <div class="star_icon d-flex align-items-center">
                                                        <a class="rating">
                                                        <input type="radio" id="product_star_{{$key}}_5" name="giftcard_rating_{{@$product->giftcard->id}}" checked value="5" class="rating"><label class="full product_rating" for="product_star_{{$key}}_5" id="star5" title="Delightful - 5 stars" data-rate="5"></label>
                                                        <input type="radio" id="product_star_{{$key}}_4" name="giftcard_rating_{{@$product->giftcard->id}}" value="4" class="rating"><label class="full product_rating" for="product_star_{{$key}}_4" title="Satisfactory - 4 stars" data-rate="4"></label>
                                                        <input type="radio" id="product_star_{{$key}}_3" name="giftcard_rating_{{@$product->giftcard->id}}" value="3" class="rating"><label class="full product_rating" for="product_star_{{$key}}_3" title="Neutral - 3 stars" data-rate="3"></label>
                                                        <input type="radio" id="product_star_{{$key}}_2" name="giftcard_rating_{{@$product->giftcard->id}}" value="2" class="rating"><label class="full product_rating" for="product_star_{{$key}}_2" title="Poor - 2 stars" data-rate="2"></label>
                                                        <input type="radio" id="product_star_{{$key}}_1" name="giftcard_rating_{{@$product->giftcard->id}}" value="1" class="rating"><label class="full product_rating" for="product_star_{{$key}}_1" title="Very Poor - 1 star" data-rate="1"></label>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="send_query ">
                                                    <div class="form-group">
                                                        <textarea id="textarea_{{$key}}" placeholder="{{ __('defaultTheme.please_share_your_feedback_about_the_product') }}" name="product_review[]" spellcheck="false"></textarea>
                                                    </div>
                                                </div>
                                                <div class="photo_uploader_lists">
                                                    <div class="row">

                                                        <div class="col-lg-12">
                                                            <div class="img_upload_group d-flex align-items-center flex-wrap">
                                                                <div class="flex-wrap img_upload_div" id="img_upload_div_{{$key}}">

                                                                </div>
                                                                <label for="photo_{{$key}}" class="photo_uploader">
                                                                    <i class="fas fa-camera"></i>
                                                                    <p id="count_{{$key}}">0/6</p>
                                                                    <input class="d-none upload_img_for_product" type="file" id="photo_{{$key}}" name="gift_images_{{@$product->giftCard->id}}[]" data-upload_div="#img_upload_div_{{$key}}" data-count="#count_{{$key}}" max="6" multiple>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="review_guidelines">
                                                    <h4>{{ __('defaultTheme.important') }}</h4>
                                                    <p>{{ __('defaultTheme.maximum_6_images_can_be_uploaded') }}</p>
                                                    <p>{{ __('defaultTheme.image_size_can_be_maximum_5mb') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="customer_review_right">
                                <div class="review_seller_box">
                                    @if(isModuleActive('MultiVendor'))
                                    <p>
                                        {{ __('common.sold_by') }}

                                        @if (@$package->seller->slug)
                                        <a href="{{route('frontend.seller',@$package->seller->slug)}}">{{@$package->seller->first_name}}</a>
                                        @else
                                        <a href="{{route('frontend.seller',base64_encode(@$package->seller->id))}}">{{ app('general_setting')->company_name }}</a>
                                        @endif

                                    </p>
                                    @endif
                                    <input type="hidden" name="seller_id" value="{{@$package->seller->id}}">
                                    <input type="hidden" name="order_id" value="{{@$package->order->id}}">
                                    <input type="hidden" name="package_id" value="{{@$package->id}}">
                                    <h5>@if(isModuleActive('MultiVendor')){{ __('defaultTheme.rate_and_review_your_seller') }}@else {{__('common.company_rating_review')}} @endif</h5>
                                    <div class="star_icon d-flex align-items-center">
                                        <a class="rating">
                                        <input type="radio" id="seller_star5" name="seller_rating" checked value="5" class="rating"><label class="full rate_to_seller" for="seller_star5" id="star5" title="Delightful - 5 stars" data-rating="5"></label>
                                        <input type="radio" id="seller_star4" name="seller_rating" value="4" class="rating"><label class="full rate_to_seller" for="seller_star4" title="Satisfactory - 4 stars" data-rating="4"></label>
                                        <input type="radio" id="seller_star3" name="seller_rating" value="3" class="rating"><label class="full rate_to_seller" for="seller_star3" title="Neutral - 3 stars" data-rating="3"></label>
                                        <input type="radio" id="seller_star2" name="seller_rating" value="2" class="rating"><label class="full rate_to_seller" for="seller_star2" title="Poor - 2 stars" data-rating="2"></label>
                                        <input type="radio" id="seller_star1" name="seller_rating" value="1" class="rating"><label class="full rate_to_seller" for="seller_star1" title="Very Poor - 1 star" data-rating="1"></label>
                                        </a>
                                    </div>
                                    <div class="send_query mt-3">
                                        <div class="form-group">
                                            <label for="textarea">{{ __('defaultTheme.review_details') }}</label>
                                            <textarea name="seller_review" id="seller_review_field" placeholder="{{ __('defaultTheme.how_over_all_experience_with_seller') }}" spellcheck="false"></textarea>
                                            <span class="text-red" id="error_seller_review_field"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="customer_review_bottom">
                            <div class="row justify-content-end">
                                <div class="col-xl-4">
                                <div class="customer_review_as">
                                    @php
                                        $user = auth()->user();
                                    @endphp
                                    <span>Review as {{$user->first_name}}.</span>
                                    <label class="switch_toggle" for="checkbox">
                                        <input type="checkbox" name="is_anonymous" value="1" id="checkbox">
                                        <div class="slider round"></div>
                                    </label>
                                    <span class="Anonymous" >{{ __('defaultTheme.anonymous') }}</span>
                                </div>
                                    <button type="submit" class="btn_1 w-100 text-center" id="submit_btn">{{ __('common.submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection
@push('scripts')
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('click', '.product_rating', function(event){
                    let rate = $(this).data('rate');
                    $('#product_rating').val(val);
                });

                $(document).on('change', '.upload_img_for_product', function(event){
                    let upload_div = $(this).data('upload_div');
                    let count = $(this).data('count');
                    console.log($(this)[0]);
                    uploadImage($(this)[0], upload_div, count);
                });

                $(document).on('click', '.rate_to_seller', function(event){
                    let rate = $(this).data('rating');
                    $('#seller_rating').val(val);
                });

                function uploadImage(data, divId, count) {
                    if (data.files) {

                        if(data.files.length>6){
                            toastr.error("{{__('defaultTheme.maximum_6_image_can_upload')}}","{{__('common.error')}}");
                            data.value = '';
                        }
                        else{
                            $.each(data.files, function(key, value) {
                            $(divId).empty();
                            $(count).text(data.files.length+'/6');
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $(divId).append(
                                    `<div class="single_img">
                                        <img src="` +e.target.result + `" alt="">
                                    </div>`);
                            };

                            reader.readAsDataURL(value);

                        });
                        }
                    }
                }

                $(document).on('click', '#submit_btn', function(event){

                    let length = $('#product_length').val();
                    let seller_review = $('#seller_review_field').val();
                    $('#error_seller_review_field').text('');
                    for (let i = 0; i < length; i++) {
                        let textData = $('#textarea_' + i).val();
                        $('#error_textarea_' + i).text('');
                        if(textData == ''){
                            $('#error_textarea_' + i).text("{{__('validation.this_field_is_required')}}");
                            event.preventDefault();
                        }
                    }
                    if(seller_review == ''){
                        $('#error_seller_review_field').text("{{__('validation.this_field_is_required')}}");
                        event.preventDefault();
                    }
                });

            });
        })(jQuery);

    </script>
@endpush
