@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{ __('ticket.ticket') }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/text_editor/summernote-bs4.css')) }}" />

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/ticket/create.css'))}}" />

@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
                <div class="referral_item">
                    <div class="single_coupons_item cart_part">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h5>{{__('ticket.create_new_ticket')}}</h5>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <form name="basic_info" action="{{route('frontend.support-ticket.store')}}" method="POST"
                            id="basic_info" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-10 offset-lg-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="subject">{{__('common.subject')}}</label> <span
                                                    class="text-danger">*</span>
                                                <input type="text" class="form-control" id="subject"
                                                    placeholder="{{__('common.subject')}}" value="" name="subject">
                                            </div>

                                            @if ($errors->has('subject'))
                                            <span
                                                class="validation-name-info-error text-danger info_error">{{ $errors->first('subject') }}</span>
                                            @endif

                                        </div>

                                        <div class="col-md-6 mt-15">
                                            <div class="form-group">
                                                <label>{{ __('common.category') }} <span class="text-danger"
                                                        for="category_id">*</span></label>
                                                <select class="form-control nc_select" name="category_id"
                                                    id="category_id" autocomplete="off">
                                                    <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                                    @foreach($categories as $key => $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('category_id'))
                                            <span class="text-danger"
                                                id="error_category_id">{{ $errors->first('category_id') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-6 mt-15">
                                            <div class="form-group">
                                                <label>{{ __('ticket.priority') }} <span class="text-danger"
                                                        for="priority_id">*</span></label>
                                                <select class="form-control nc_select" name="priority_id"
                                                    id="priority_id" autocomplete="off">
                                                    <option value="">{{__('defaultTheme.select_from_options')}}</option>
                                                    @foreach($priorities as $key => $priority)
                                                    <option value="{{$priority->id}}">{{$priority->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('priority_id'))
                                            <span class="text-danger"
                                                id="error_priority_id">{{ $errors->first('priority_id') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-12 mt-15 mb_15">
                                            <div class="form-group">
                                                <label for="textarea">{{__('common.description')}} <span class="text-danger">*</span></label>
                                                <textarea id="description" class="summernote" placeholder="{{__('common.description')}}"
                                                    name="description"></textarea>
                                            </div>

                                            @if ($errors->has('description'))
                                            <span class="text-danger"
                                                id="error_message">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-12">
                                            <div id="attach_file_div">
                                                <div class="attach_item d-flex align-items-end gap_15 mb_15">
                                                    <div class="flex-fill">
                                                        <div class="form-group primary_file_uploader">
                                                            <label for="subject">{{__('common.attach_file')}}</label>

                                                            <input type="text" class="form-control" id="attach" readonly
                                                                placeholder="">
                                                            <button class="d-inline" type="button">
                                                                <label class="primary-btn small fix-gr-bg ticket_browse"
                                                                    for="ticket_file">{{ __('common.browse') }} </label>
                                                                <input type="file" class="d-none attach_file_change"
                                                                    name="ticket_file[]" id="ticket_file"
                                                                    data-value="#attach">
                                                            </button>
                                                        </div>
                                                        @if ($errors->has('ticket_file'))
                                                        <span class="text-danger"
                                                            id="error_message">{{ $errors->first('ticket_file') }}</span>
                                                        @endif

                                                    </div>
                                                    <div class="">
                                                        <a href="javascript:void(0)" id="new_attach_file"
                                                            class="btn_1 attach_plus_btn m-0"><i class="ti-plus"></i></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form_btn col-md-12">
                                            <button type="submit" class="btn_1"
                                                id="update_info">{{__('common.create')}}</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts')
<script src="{{asset(asset_path('backend/vendors/text_editor/summernote-bs4.js'))}}"></script>
<script>
    (function($){
            "use strict";

            $(document).ready(function(){
                $('#description').summernote({
                    placeholder: 'Write here',
                    tabsize: 2,
                    height: 200,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                $(document).on('click', '#new_attach_file', function(event){
                    let index = $('.attach_item').length
                    addNewFileAddItem(index);
                });

                $(document).on('click', '.remove_attach', function() {
                    $(this).parent().parent().remove();
                });

                $(document).on('change','.attach_file_change', function(event){
                    let unique_id = $(this).data('value');
                    getFileName($(this).val(),unique_id);
                });

                function addNewFileAddItem(index){
                    if(index >4){
                        toastr.error("{{__('ticket.attch_upload_limit_is_5')}}","{{__('common.error')}}");
                        return false;
                    }
                    let new_file = `
                        <div class="attach_item d-flex align-items-end gap_15 mb_15">
                            <div class="flex-fill">
                                <div class="form-group primary_file_uploader">
                                    <label for="subject">{{__('common.attach_file')}}</label>
                                    <input type="text" class="form-control" id="attach_${index}" readonly placeholder="{{ __('common.browse_file') }}">
                                    <button class="d-inline" type="button">
                                        <label class="primary-btn small fix-gr-bg" for="ticket_file_${index}">Browse </label>
                                        <input type="file" class="d-none attach_file_change" name="ticket_file[]" id="ticket_file_${index}" data-value="#attach_${index}">
                                    </button>
                                </div>

                            </div>
                            <div class="">
                                <a href="javascript:void(0)" class="btn_1 remove_attach attach_plus_btn"><i class="ti-trash"></i></a>
                            </div>
                        </div>

                    `;
                    $('#attach_file_div').append(new_file);
                }
            });
        })(jQuery);

</script>

@endpush
