@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/blog/css/post_show.css'))}}" />

@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="white-box">
                        <div class="knowledge_view">
                            <div class="arrow_button"></div>
                            <div class="main-title ">
                                <h3 class="mb-0 d-flex justify-content-between">  {{$data->title}} <a href="{{route('blog.posts.index')}}"><i class="fas fa-chevron-left"></i></a></h3>
                            </div>
                            <p class="date_links">From <a href="#">{{$data->user->getFullNameAttribute()}}</a> {{ \Carbon\Carbon::parse($data->published_at)->toDayDateTimeString()}}</p>
                            <div class="single_blog_post_img" >
                                <div class="blog_img_div">
                                <a target="_blank" href="{{route('blog.single.page',$data->slug)}}">
                                  <img src="{{
                                  isset($data->image_url)? showImage($data->image_url):showImage('backend/img/default.png')}}" alt="">
                                </a>
                                </div>
                            </div>
                            <p class="knowledge_text" >@php echo $data->content; @endphp.</p>
                            @foreach($data->categories as $list)
                            <button class="primary_btn mb-25">{{$list->name}}</button>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div >

                        </div>

                    </div>
                </div>
                <!-- Add Modal add_department -->
                <div class="modal fade admin-query" id="New_Article">
                    <div class="modal-dialog modal_800px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{__('blog.new_article')}}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('common.title')}}</label>
                                                <input class="primary_input_field" placeholder={{__('common.title')}}" type="text">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{__('blog.post_tag')}}</label>
                                                <input class="primary_input_field" placeholder="-" type="email">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-35">
                                                <label class="primary_input_label" for="">{{__('blog.short_description')}}</label>
                                                <div class="lms_summernote"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center">
                                                <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button"><i class="ti-check"></i> {{__('blog.post_article')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!--/ add_department -->
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')

@endpush
