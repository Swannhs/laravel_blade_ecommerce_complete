<div class="col-lg-3">
    <div class="blog_sidebar">
        <div class="single_blog_sidebar">
            <form action="#" name="sidebar_search">
                <div class="input-group">
                    <div class="input-group-append">
                            <input type="text" class="form-control search_input" id="inlineFormInputGroup" placeholder="{{ __('blog.search_posts') }}" name="query" required="">
                           <div class="input-group-text"> <a href="javascript:void(0)" class="search text-white"><i class="ti-search"></i></a> </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="single_blog_sidebar">
            <div class="sidebar_tittle">
                <h5>{{ __('blog.popular_posts') }}</h5>
            </div>
            @foreach($popularPost as $post)
            <div class="single_sidebar_post d-flex align-items-center">
                <div class="single_post_img">
                    <a class="sidebar_post_img" href="{{route('blog.single.page',$post->slug)}}">
                        <img src="{{showImage($post->image_url?$post->image_url:'backend/img/default.png')}}" alt="" class="img-fluid">
                    </a>
                </div>
                <div class="single_post_content">
                    <h5><a href="{{route('blog.single.page',$post->slug)}}">{{Str::limit($post->title,25)}}.</a></h5>
                    <p>
                        {{date(app('general_setting')->dateFormat->format, strtotime($post->published_at))}}

                    </p>
                </div>
            </div>
            @endforeach

        </div>
        <div class="single_blog_sidebar">
            <div class="sidebar_tittle">
                <h5>{{ __('common.category') }}</h5>
            </div>
            <ul>
                @foreach($categoryPost as $post)
                <li><a href="{{route('blog.category.posts',$post->slug)}}">{{$post->name}} <span>({{$post->active_post_count}}
                )</span></a></li>
                @endforeach
            </ul>
        </div>
        <div class="single_blog_sidebar">
            <div class="sidebar_tittle">
                <h5>{{ __('common.category') }}</h5>
            </div>
            <div class="instagram_img">
                @foreach($categoryPost as $post)
                <div class="single_instagram_img">
                    <a class="sidebar_category_img" href="{{route('blog.category.posts',$post->slug)}}">
                        <img src="{{showImage($post->image_url)}}" alt="">
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('.search','click',function(){
                    alert('testing');
                    var data=$('.search_input').val();
                    console.log(data);
                    $.ajax({
                        url: "{{ route('blog.posts.search') }}",
                        type: "GET",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: {'data':data},
                        success: function(response) {
                            console.log(response);

                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                    });
                });
            });
        })(jQuery);
    </script>
@endpush
