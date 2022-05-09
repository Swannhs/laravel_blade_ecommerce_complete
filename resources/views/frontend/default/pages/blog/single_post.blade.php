@extends('frontend.default.layouts.app')

@section('breadcrumb')

{{ __('blog.blog') }}
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/blog/single_post.css'))}}" />

@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')

<!-- blog part here -->
<section class="blog_part bg-white padding_top">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="blog_details_part">
                    <div class="blog_details_img">

                        @if(isset($post->image_url))
                        <img src="{{showImage($post->image_url)}}" alt="">
                        @endif
                    </div>
                    <div class="blog_details_content">
                        <div class="blog_details_text">
                            <p id="laraberg">@php echo $post->content; @endphp</p>
                        </div>

                        @guest
                         <div class="float-left">
                            <button type="button" class="btn btn-sm  btn-info guest_btn_class">

                              <span class="glyphicon glyphicon-thumbs-up"></span> Like
                              <div class="d-inline-block">{{$likePost->like_count}}</div>
                            </button>
                        </div>

                        @else
                        <div class="float-left">
                            <button type="button" class="btn btn-sm likebtn {{$likecheck? '':'btn-info'}}" pid="{{$post->id}}">

                              <span class="glyphicon glyphicon-thumbs-up"></span> Like
                              <div id="like-bs3" class="d-inline-block">{{$likePost->like_count}}</div>
                            </button>
                        </div>
                        @endguest

                        <div class="author_details">
                            <div class="author_img">
                                <img src="{{isset($post->user->avatar)?showImage($post->user->avatar) : showImage('frontend/default/img/author_img.png')}}" alt="#">
                            </div>
                            <div class="author_details_content">
                                <h4>{{$post->user->fullname}}</h4>
                                <p></p>
                                <div class="author_social_icon">
                                    <a href="#"><i class="ti-facebook"></i></a>
                                    <a href="#"><i class="ti-twitter-alt"></i></a>
                                    <a href="#"><i class="ti-google"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="comment_area">
                            <h4>
                                {{ __('common.total') }}
                                 {{count($post->comments)}} Comments</h4>
                            <div class="comment_area_iner">
                                @foreach($post->comments as $comment)
                                <div class="media">
                                    <a href="#">
                                        <img src="{{isset($comment->commentUser->avatar)?showImage($comment->commentUser->avatar):showImage('frontend/default/img/author/author_1.png')}}" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <div class="author_tittle">
                                           <h5>{{$comment->commentUser->fullname}}</h5>
                                           <span>|</span>
                                           <p>{{ \Carbon\Carbon::parse($comment->created_at)->toDayDateTimeString()}}</p>
                                        </div>
                                        <p>{{$comment->comment}}.</p>
                                        @auth
                                        <a  class="btn_2 reply" cid="{{ $comment->id }}" post_id="{{ $post->id }}" token="{{ csrf_token() }}">Reply</a>
                                        <div class="reply-form">

                                        </div>
                                        @endauth
                                        @if ($errors->has('replay'))
                                        <span class="" role="alert">
                                            <strong>{{ $errors->first('replay') }}</strong>
                                        </span>
                                        @endif
                                        @if(count($comment->replay) > 0)
                                        @foreach($comment->replay as $replay)
                                        <div class="media">
                                            <a href="#">
                                                <img src="{{isset($replay->replayUser->avatar)?showImage($replay->replayUser->avatar):showImage('frontend/default/img/author/author_2.png')}}" alt="...">
                                            </a>
                                            <div class="media-body">
                                                <div class="author_tittle">
                                                    <h5>{{$replay->replayUser->fullname}}</h5>
                                                    <span>|</span>
                                                    <p>{{ \Carbon\Carbon::parse($replay->created_at)->toDayDateTimeString()}}</p>
                                                </div>
                                                <p>@php echo $replay->replay; @endphp.</p>
                                                @auth
                                                <a  class="btn_2 rreply" cid="{{ $comment->id }}" post_id="{{ $post->id }}" replay_id="{{$replay->id}}" token="{{ csrf_token() }}">Reply</a>
                                                <div class="rreply-form">
                                                </div>
                                                @endauth


                                      @if(count($replay->replayReplay) > 0)
                                        @foreach($replay->replayReplay as $rreplay)
                                        <div class="media">
                                            <a href="#">
                                                <img src="{{isset($rreplay->replayUser->avatar)?showImage($rreplay->replayUser->avatar) :showImage('frontend/default/img/author/author_2.png')}}" alt="...">
                                            </a>
                                            <div class="media-body">
                                                <div class="author_tittle">
                                                    <h5>{{$rreplay->replayUser->fullname}}</h5>
                                                    <span>|</span>
                                                    <p>{{ \Carbon\Carbon::parse($rreplay->created_at)->toDayDateTimeString()}}</p>
                                                </div>
                                                <p>@php echo $rreplay->replay; @endphp.</p>

                                            </div>
                                        </div>
                                        @endforeach
                                      @endif
                                      </div>
                                      </div>
                                     @endforeach
                                     @endif

                                </div>
                            </div>
                                @endforeach

                        </div>
                        <div class="comment_form">
                            @if($post->is_commentable==true)
                            @guest
                            <h4>{{ __('blog.for_post_a_new_comment_you_need_to_login_first') }} <a href="{{ route('login') }}">{{ __('defaultTheme.login') }}</a></h4>
                            @else
                            <h4>{{ __('blog.post_a_comment_now') }}</h4>
                            <form action="{{route('blog.comment.store',$post->id)}}" name="comment_form" method="POST" id="comment_form">
                                @csrf
                                <div class="form-row">
                                    @if ($errors->has('comment'))
                                        <span class="alert alert-danger" role="alert">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                        @endif
                                    <div class="form-group col-md-12">
                                        <label for="comment">{{ __('common.message') }}</label>
                                        <textarea name="comment" id="comment" placeholder="{{ __('common.write_some_messages') }}"></textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <a href="javascript:void(0)" class="btn_1 for_submit">{{ __('blog.post_comment') }}</a>
                                    </div>
                                </div>
                            </form>
                            @endguest
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

            @include('frontend.default.pages.blog.partials._sidebar')

        </div>
    </div>
</section>
<!-- blog part end -->


@endsection
@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";
            $(document).ready(function(){
                $(".for_submit").on('click',function(){
                    $("#comment_form").submit();
                });

                $(document).on("click", ".reply",function(){
                    $('.reply-form').toggle();
                    $('.reply-form').empty();
                    var well = $(this).closest('.media-body');
                    var cid = $(this).attr("cid");
                    var pid = $(this).attr('post_id');
                    var token = $(this).attr('token');
                    var form = '<form method="post" action="{{route('blog.replay')}}"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="comment_id" value="'+ cid +'"><input type="hidden" name="post_id" value="'+pid+'"><div class="form-group"><textarea class="form-control" name="replay" placeholder="Enter your reply" > </textarea> </div> <div class="form-group"> <input class="btn btn-primary" type="submit"> </div></form>';

                    well.find(".reply-form").append(form);

                });


                //replay replay
                $(document).on("click", ".rreply",function(){
                    $('.rreply-form').toggle();
                    $('.rreply-form').empty();
                    var well = $(this).closest('.media-body');
                    var cid = $(this).attr("cid");
                    var pid = $(this).attr('post_id');
                    var token = $(this).attr('token');
                    var replay_id =$(this).attr('replay_id');
                    var form = '<form method="post" action="{{route('blog.replay')}}"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="comment_id" value="'+ cid +'"><input type="hidden" name="post_id" value="'+pid+'"><input type="hidden" name="replay_id" value="'+replay_id+'"><div class="form-group"><textarea class="form-control" name="replay" placeholder="Enter your reply" > </textarea> </div> <div class="form-group"> <input class="btn btn-primary" type="submit"> </div></form>';

                    well.find(".rreply-form").append(form);

                });

                //replay replay replay
                $(document).on("click", ".rrreply",function(){
                    $('.rrreply-form').toggle();
                    $('.rrreply-form').empty();
                    var well = $(this).parent().parent().parent().parent();
                    var cid = $(this).attr("cid");
                    var pid = $(this).attr('post_id');
                    var token = $(this).attr('token');
                    var replay_id =$(this).attr('replay_id');
                    var form = '<form method="post" action="{{route('blog.replay')}}"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="comment_id" value="'+ cid +'"><input type="hidden" name="post_id" value="'+pid+'"><input type="hidden" name="replay_id" value="'+replay_id+'"><div class="form-group"><textarea class="form-control" name="replay" placeholder="Enter your reply" > </textarea> </div> <div class="form-group"> <input class="btn btn-primary" type="submit"> </div></form>';

                    well.find(".rrreply-form").append(form);

                });


                $(document).on('click','.likebtn',function(){

                    var formData= new FormData();
                    var pid = $(this).attr('pid');
                    var c = $('#like-bs3').html();


                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('pid', pid);
                    $.ajax({
                        url: "{{ route('blog.post.like') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            if (response.dislike) {
                                toastr.success(response.dislike)
                                $('#like-bs3').html(parseInt(c)-1);
                                $('.likebtn').addClass("btn-info");
                            }
                            else if (response.like) {
                                toastr.success(response.like)
                                $('#like-bs3').html(parseInt(c)+1);
                                $('.likebtn').removeClass("btn-info");
                            }


                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                    });

                });

                $(document).on('click', '.guest_btn_class', function(event){
                    event.preventDefault();
                    toastr.info('To add favorite list. You need to login first.','Info',{closeButton: true,progressBar: true,});
                });

            });
        })(jQuery);

    </script>
@endpush
