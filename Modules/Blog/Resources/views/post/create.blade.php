@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/blog/css/post_create.css'))}}" />

@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('blog.add_new_post') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="white-box">
            <form action="{{route('blog.posts.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-9">
                        <div class="white_box_25px box_shadow_white mb-20">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title d-flex">
                                        <h3 class="mb-2 mr-30">{{ __('blog.post_info') }}</h3>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('common.title')}} <span class="text-danger">*</span></label>
                                        <input name="title" class="primary_input_field title" id="title"
                                        placeholder="{{ __('common.title') }}" type="text" autocomplete="off" required value="{{old('title')}}">
                                    </div>
                                    @if ($errors->has('title'))
                                        <span class="alert alert-warning" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-lg-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('common.slug')}} <span class="text-danger">*</span></label>
                                        <input type="text" class="primary_input_field title" id="slug" name="slug" autocomplete="off" placeholder="{{ __('common.slug') }}" value="{{old('slug')}}">
                                    </div>
                                </div>
                                @if ($errors->has('slug'))
                                        <span class="alert alert-warning" role="alert">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif

                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("common.description")}} <span class="text-danger">*</span> </label>
                                        <textarea id="laraberg" name="content" hidden value="{{old('name')}}"></textarea>

                                    </div>
                                </div>
                                @if ($errors->has('content'))
                                        <span class="alert alert-warning" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 upload_item_area">
                        <div class="white_box_25px box_shadow_white upload_item_forms">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title d-flex">
                                        <h3 class="mb-2 mr-30">{{ __('common.basic_info') }}</h3>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                        <select class="primary_select mb-25" name="categories[]" id="category_id" data-live-search="true" multiple required>
                                            @foreach($CategoryList as $value)
                                            <option value="{{$value->id}}">
                                                <strong>-></strong>
                                                {{ $value->name }}

                                              @foreach ($value->childs as $child_account)
                                               @include('blog::category.category_select', ['child_account' => $child_account])
                                                    @endforeach
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                     @if ($errors->has('categories'))
                                        <span class="alert alert-warning" role="alert">
                                            <strong>{{ $errors->first('categories') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-lg-12">

                                    <div class="single_field ">
                                        <label for="">@lang('blog.tags') (@lang('product.comma_separated'))<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="tagInput_field mb_26">
                                        <input name="tag" class="tag-input" id="tag-input-upload-shots" type="text" value="" data-role="tagsinput" />
                                    </div>

                                        <div class="suggeted_tags">
                                            <label>@lang('blog.suggested_tags')</label>
                                            <div class="tagInput_field mb_26">
                                                <ul id="tag_show" class="suggested_tag_show">
                                                </ul>
                                            </div>
                                        </div>

                                    @if ($errors->has('tags'))
                                        <span class="alert alert-warning" role="alert">
                                            <strong>{{ $errors->first('tags') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <br>
                                <div class="col-lg-12">
                                    <div class="main-title d-flex">
                                        <label class="mb-2 mr-30">{{ __('common.image') }}<small>(1000x500)px</small></label>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="primary_input mb-25">
                                        <div class="primary_file_uploader">
                                          <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{ __('common.browse') }}" readonly="">
                                          <button class="" type="button">
                                              <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.image")}} </label>
                                              <input type="file" class="d-none" name="file" id="document_file_1">
                                          </button>
                                       </div>
                                       <div class="img_div">
                                        <img id="blogImgShow"
                                        src="{{showImage('backend/img/default.png')}}" alt="">
                                       </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <input type="checkbox" id="comments" class="filled-in" name="comments" value="0">
                                        <label for="comments">{{__("blog.close_comments")}}</label>
                                    </div>
                                    <div  class="col-lg-12">
                                        <input type="checkbox" id="publish" class="filled-in" name="status" value="1">
                                        <label for="publish">{{__("blog.publish")}}</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="primary_btn_2 mt-5"><i class="ti-check"></i>{{__("common.save")}} </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function () {
                $('.summernote').summernote({
                    height: 200,
                    codeviewFilter: true,
			        codeviewIframeFilter: true,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                Laraberg.init('laraberg');

                $(document).on('mouseover', 'body', function(event){
                    $('.editor-block-list-item-file').parent().addClass('d-none');
                });

                //slug focus in name keyup
                $(document).on('keyup', '.name', function(){
                    if ($.trim($('.slug').val()).length) {
                        $('.slug').addClass('has-content');
                    } else {
                        $('.slug').removeClass('has-content');
                    }
                });


                $(document).on('click', '.tag-add', function(e){
                    e.preventDefault();
                    $('#tag-input-upload-shots').tagsinput('add', $(this).text());
                });

                $(document).on('change', '#document_file_1', function(){
                    getFileName($(this).val(),'#placeholderFileOneName');
                    imageChangeWithFile($(this)[0],'#blogImgShow');
                });

                $(document).on('keyup', '#title', function(){
                    processSlug($(this).val(), '#slug');
                });
                $(document).on('focusout', '#title', function(){
                    // tag get
                    $("#tag_show").html('<li></li>');
                    var sentence = $(this).val();
                    $.get('/setup/getTagBySentence',{sentence:sentence},function(result){
                        $("#tag_show").append(result);
                    })
                });

            });
        })(jQuery);
    </script>
@endpush
