@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{ __('blog.blog') }}
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/blog/category_post.css'))}}" />

@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')

<!-- blog part here -->
<section class="blog_part bg-white padding_top">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="blog_post">

                   @foreach($categoryPosts as $list)
                     @foreach($list->posts as $post )

                    <div class="single_blog_post d-flex align-items-center">
                        <div class="single_blog_post_img" >
                            <div class="blog_img_main_div">
                            <a class="blog_img_div" href="{{route('blog.single.page',$post->slug)}}">
                              <img src="{{
                                isset($post->image_url)? showImage($post->image_url):showImage('backend/img/default.png')}}" alt="#">
                            </a>
                            </div>

                        </div>
                        <div class="single_blog_post_content">
                        <h4><a href="{{route('blog.single.page',$post->slug)}}">{{$post->title}}</a></h4>
                            <p>{{$post->excerpt}}</p>
                            <div class="blog_post_details">
                                <a href="javascript:void(0);"> <i class="ti-user"></i> {{$post->user->getFullNameAttribute()}} </a>
                                <a href="javascript:void(0);"> <i class="ti-calendar"></i> {{ \Carbon\Carbon::parse($post->published_at)->toDayDateTimeString()}}</a>
                                <a href="{{route('blog.single.page',$post->slug)}}"> <i class="ti-comment"></i> {{count($post->comments)}} </a>
                            </div>
                        </div>
                    </div>

                    @endforeach
                   @endforeach

                    <!--  -->
                </div>


                </div>
                <div class="pagination_part">
                    <nav aria-label="Page navigation example">
                        @if ($posts->lastPage() > 1)
                        <ul class="pagination">
                            <li class="{{ ($posts->currentPage() == 1) ? ' disabled' : '' }} page-item">
                                <a class="page-link" href="{{ $posts->url(1) }}"><i class="ti-arrow-left"></i></a>
                            </li>
                            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                <li class="{{ ($posts->currentPage() == $i) ? ' active' : '' }} page-item">
                                    <a class="page-link"  href="{{ $posts->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="{{ ($posts->currentPage() == $posts->lastPage()) ? ' disabled' : '' }} page-item">
                                <a href="{{ $posts->url($posts->currentPage()+1) }}" class="page-link" ><i class="ti-arrow-right"></i></a>
                            </li>
                        </ul>
                        @endif
                    </nav>
                </div>




            @include('frontend.default.pages.blog.partials._sidebar')


        </div>
    </div>
</section>
<!-- blog part end -->


@endsection
