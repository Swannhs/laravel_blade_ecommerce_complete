@if($posts->count() > 0)
    @foreach($posts as $post)
        <div class="single_blog_post d-flex align-items-center">
            <div class="single_blog_post_img" >
                <div class="blog_search_div">
                    <a href="{{route('blog.single.page',$post->slug)}}">
                        <img src="{{isset($post->image_url)? showImage($post->image_url):showImage('frontend/default/img/blog/single_blog_1.png')}}" alt="#" height="100% !important;" width="100% !important">
                    </a>
                </div>

            </div>
            <div class="single_blog_post_content">
                <h4><a href="{{route('blog.single.page',$post->slug)}}">{{$post->title}}</a></h4>
                <p>{{$post->excerpt}}</p>
                <div class="blog_post_details">
                    <a href="#"> <i class="ti-user"></i> {{$post->user->getFullNameAttribute()}} </a>
                    <a href="#"> <i class="ti-calendar"></i> {{ \Carbon\Carbon::parse($post->published_at)->toDayDateTimeString()}}</a>
                    <a href="#"> <i class="ti-comment"></i> {{count($post->comments)}} </a>
                    <a href="#"><i class="ti-eye"></i>{{ $post->view_count }}</a>
                    <a href="#"><i class="ti-hand-point-right"></i>{{ $post->like->count() }}</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-lg-12 col-md-12">
        <div class="card h-100">
            <div class="single-post post-style-1 p-2">
                <strong>{{ __('blog.no_post_found') }} </strong>
            </div><!-- single-post -->
        </div><!-- card -->
    </div>
@endif
