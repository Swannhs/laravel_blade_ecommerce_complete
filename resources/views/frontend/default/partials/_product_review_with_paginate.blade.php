<div class="item_description">
    <h4>{{__('defaultTheme.product_reviews')}}</h4>

    @php
        $total_number_of_item_per_page = $reviews->perPage();
        $total_number_of_items = ($reviews->total() > 0) ? $reviews->total() : 0;
        $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
        $reminder = $total_number_of_items % $total_number_of_item_per_page;
        if ($reminder > 0) {
            $total_number_of_pages += 1;
        }
        $current_page = $reviews->currentPage();
        $previous_page = $reviews->currentPage() - 1;
        if($current_page == $reviews->lastPage()){
            $show_end = $total_number_of_items;
        }else{
            $show_end = $total_number_of_item_per_page * $current_page;
        }


        $show_start = 0;
        if($total_number_of_items > 0){
            $show_start = ($total_number_of_item_per_page * $previous_page) + 1;
        }


    @endphp

    @if(count($reviews) > 0)
        @foreach(@$reviews as $key => $review)

        <div class="client_review media_style">
            <div class="single_product_img">
                @if($review->is_anonymous == 1 || @$review->customer->avatar == null)
                <img src="{{showImage('frontend/default/img/avatar.jpg')}}" alt="#" />
                @else
                <img src="{{showImage(@$review->customer->avatar)}}" alt="#" />
                @endif
            </div>
            <div class="single_product_text">
                <div class="review_icon">
                    <i class="fas fa-star {{$review->rating >= 1?'':'text-gray'}}"></i>
                    <i class="fas fa-star {{$review->rating >= 2?'':'text-gray'}}"></i>
                    <i class="fas fa-star {{$review->rating >= 3?'':'text-gray'}}"></i>
                    <i class="fas fa-star {{$review->rating >= 4?'':'text-gray'}}"></i>
                    <i class="fas fa-star {{$review->rating == 5?'':'text-gray'}}"></i>
                </div>
                <h3>{{$review->is_anonymous==1?'Unknown Name':@$review->customer->first_name.' '.@$review->customer->last_name}} <span>{{date('dS M, Y',strtotime($review->created_at))}}</span></h3>
                <p>
                    {{$review->review}}
                </p>
                <div class="single_product_img">

                    @foreach($review->images as $key => $image)
                        <img class="review_img" src="{{asset(asset_path($image->image))}}" alt="">
                    @endforeach
                </div>
            </div>


        </div>
        @if(@$review->reply)
        <div class="replyDiv">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="client_review media_style">
                        <div class="single_product_img">

                            <img class="seller_avatar" src="{{asset(asset_path(@$review->seller->photo?$review->seller->photo:'frontend/default/img/avatar.jpg'))}}" alt="" />
                        </div>
                        <div class="single_product_text seller_text_div">
                            <h3>{{@$review->seller->first_name}}<span>{{date('dS M, Y',strtotime($review->reply->created_at))}}</span></h3>
                            <p>
                                {{@$review->reply->review}}
                            </p>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    @else
        <p>{{ __('defaultTheme.no_review_found') }}</p>
    @endif

</div>

@if(count($reviews) > 0)
<div class="col-lg-12">

    <div class="pagination_part">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="{{ $reviews->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
                @for ($i=1; $i <= $total_number_of_pages; $i++)
                    @if (($reviews->currentPage() + 2) == $i)
                        <li class="page-item"><a class="page-link" href="{{ $reviews->url($i) }}">{{ $i }}</a></li>
                    @endif
                    @if (($reviews->currentPage() + 1) == $i)
                        <li class="page-item"><a class="page-link" href="{{ $reviews->url($i) }}">{{ $i }}</a></li>
                    @endif
                    @if ($reviews->currentPage() == $i)
                        <li class="page-item @if (request()->toRecievedList == $i || request()->toRecievedList == null) active @endif"><a class="page-link" href="{{ $reviews->url($i) }}">{{ $i }}</a></li>
                    @endif
                    @if (($reviews->currentPage() - 1) == $i)
                        <li class="page-item"><a class="page-link" href="{{ $reviews->url($i) }}">{{ $i }}</a></li>
                    @endif
                    @if (($reviews->currentPage() - 2) == $i)
                        <li class="page-item"><a class="page-link" href="{{ $reviews->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor
                <li class="page-item"><a class="page-link" href="{{ $reviews->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
            </ul>
        </nav>
    </div>
</div>

@endif
