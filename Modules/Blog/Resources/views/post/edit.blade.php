@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/blog/css/post_edit.css'))}}" />
  
@endsection

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('blog.edit_post') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="white-box">
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('blog.posts.update',$post->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
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
                                    <input type="hidden" id="item_id" name="id" value="" />
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('common.title')}} <span class="text-danger">*</span></label>
                                        <input name="title" class="primary_input_field title" id="title" placeholder="{{__('common.title')}}" type="text" autocomplete="off" required value="{{$post->title}}">
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
                                        <input type="text" class="primary_input_field title" id="slug" name="slug" autocomplete="off" placeholder="{{__('common.slug')}}" required value="{{$post->slug}}">
                                    </div>

                                    @if ($errors->has('slug'))
                                        <span class="alert alert-warning" role="alert">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("common.description")}} <span class="text-danger">*</span> </label>
                                        <textarea id="laraberg" name="content" hidden="">@php echo $post->content; @endphp</textarea>

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

                                        <select class="primary_select mb-25 cat_select" name="categories[]" id="category_id" data-live-search="true" required multiple="multiple">
                                            @foreach($CategoryList as $value)
                                            <option value="{{$value->id}}"
                                                 {{in_array($value->id,$cat_id)? 'selected' :''}}
                                            >
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
                                        @php
                                        $tags =[];
                                        foreach($post->tags as $tag){
                                        $tags[] = $tag->name;
                                        }
                                        $tags = implode(',',$tags);
                                        @endphp
                                        <input name="tag" class="tag-input" id="tag-input-upload-shots" type="text"  value="{{$tags}}" data-role="tagsinput" />

                                    </div>

                                        <div class="suggeted_tags">
                                            <label>@lang('blog.suggested_tags')</label>
                                            <ul id="tag_show" class="suggested_tag_show">
                                            </ul>
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
                                          <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{__('common.browse')}}" readonly="">
                                          <button class="" type="button">
                                              <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.image")}} </label>
                                              <input type="file" class="d-none" name="file" id="document_file_1">
                                          </button>
                                       </div>
                                       <div id="businessImgDiv" class="logo_img">
                                        @if ($post->image_url)
                                            <p id="documentCrossPost" class="img_cross" aria-disabled="true" data-id="{{$post->id}}">
                                                <i class="fas fa-times"></i>
                                            </p>
                                        @endif
                                        <div class="img_div">
                                            <img id="blogImgShow"
                                                src="{{ asset(asset_path($post->image_url?$post->image_url:'backend/img/default.png')) }}" alt="">
                                        </div>

                                    </div>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <input type="checkbox" id="publish" class="filled-in" name="comments" value="{{$post->is_commentable==1 ? 1:0}}" {{$post->is_commentable==1 ? '':'checked'}} >
                                        <label for="publish">{{__("blog.close_comments")}}</label>
                                    </div>
                                    <div  class="col-lg-12">
                                        <input type="checkbox" id="publish" class="filled-in" name="status" value="{{$post->status==1 ? 1:0}}" {{$post->status==1 ? 'checked':''}} >
                                        <label for="publish">{{__("blog.publish")}}</label>
                                    </div>
                                </div>
                                @if (permissionCheck('blog.posts.update'))
                                    <div class="col-12">
                                        <button id="update_btn" class="primary_btn_2 mt-5"><i class="ti-check"></i>{{__("common.update")}} </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
              {{ Form::close() }}
            </div>
        </div>
        @include('backEnd.partials._deleteModalForAjax',
        ['item_name' => __('common.post_image'),'modal_id' => 'imgModal','form_id' => 'imgForm','delete_item_id' => 'delete_document_id','dataDeleteBtn'=>'document_delete_btn'])
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";

            $(document).ready(function () {

                Laraberg.init('laraberg');

                $(document).on('click', '.tag-add', function(e){
                    e.preventDefault();
                    $('#tag-input-upload-shots').tagsinput('add', $(this).text());
                });

                $(document).on('mouseover', 'body', function(event){
                    $('.editor-block-list-item-file').parent().addClass('d-none');
                });



                $(document).on('submit','#imgForm',function(event){
                        event.preventDefault();

                        $("#document_delete_btn").prop('disabled', true);
                        $('#document_delete_btn').val('{{ __("common.deleting") }}');
                        $('#imgModal').modal('hide');
                        $('#pre-loader').removeClass('d-none');

                        var formData = new FormData();
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('id', $('#delete_document_id').val());
                        $.ajax({
                            url: "{{ route('blog.post.image.delete') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                if(response ==1){

                                    $('#businessImgDiv').html(`<div class="img_div"><img id="blogImgShow"
                                                src="{{ asset(asset_path('backend/img/default.png')) }}" alt=""></div>`);
                                    toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                                    $("#document_delete_btn").prop('disabled', false);
                                    $('#document_delete_btn').val('{{ __("common.delete") }}');
                                    $('#pre-loader').addClass('d-none');
                                }else{
                                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                                    $("#document_delete_btn").prop('disabled', false);
                                    $('#document_delete_btn').val('{{ __("common.delete") }}');
                                    $('#pre-loader').addClass('d-none');
                                }
                            },
                            error: function(response) {

                            if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').addClass('d-none');
                                    return false;
                                }

                                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                                $("#document_delete_btn").prop('disabled', false);
                                $('#document_delete_btn').val('{{ __("common.delete") }}');
                                $('#pre-loader').addClass('d-none');
                            }
                        });
                    });

                $(document).on('change','#document_file_1', function(event){
                    getFileName($(this).val(),'#placeholderFileOneName');
                    imageChangeWithFile($(this)[0],'#blogImgShow');
                    removeCross('#documentCrossPost');
                });

                $(document).on('click', '#documentCrossPost', function(event){
                    let id = $(this).data('id');
                    imgDeletePost(id);
                });

                $(document).on('keyup', '#title', function(){
                    processSlug($(this).val(), '#slug');
                });


                //slug focus in name keyup
                $(document).on('keyup', '.name', function(){
                    if ($.trim($('.slug').val()).length) {
                        $('.slug').addClass('has-content');
                    } else {
                        $('.slug').removeClass('has-content');
                    }
                });

                function imgDeletePost(id){
                    $('#delete_document_id').val(id);
                    $('#imgModal').modal('show');
                }
                function removeCross(id){
                    $(id).css('display','none');
                }

                // when page load get tag before focus
                var sentence = $("#title").val();
                $.get('/setup/getTagBySentence',{sentence:sentence},function(result){
                    $("#tag_show").append(result);
                })
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
