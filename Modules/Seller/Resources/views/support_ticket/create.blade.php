@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/support_ticket_create.css'))}}" />

@endsection
@section('mainContent')

<section class="admin-visitor-area">

    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{__('ticket.open_a_ticket')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <!-- Prefix  -->
                    <form class="form-horizontal" action="{{ route('seller.support-ticket.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="subject">{{ __('ticket.subject') }} <span
                                            class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="subject" name="subject"
                                        autocomplete="off" value="{{old('subject')}}"
                                        placeholder="{{ __('ticket.subject') }}">
                                </div>
                                @if ($errors->has('subject'))
                                <span class="text-danger" id="error_subject">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>

                            <div class="col-lg-6" id="category_list_div">
                                <div class="primary_input mb-25">
                                    <div class="double_label d-flex justify-content-between">
                                        <label class="primary_input_label" for="">{{ __('common.category_list') }} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <select name="category_id" id="category_id" class="primary_select mb-15">
                                        <option value="" selected disabled>{{__('common.select_one')}}</option>
                                        @foreach ($CategoryList as $key => $item)
                                        <option value="{{ $item->id }}"
                                            {{isset($editData->category_id) != null ? ($item->id == @$editData->category_id? 'selected':''):''}}>
                                            {{ $item->name }} </option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('category_id'))
                                    <span class="text-danger"
                                        id="error_category_id">{{ $errors->first('category_id') }}</span>
                                    @endif
                                </div>

                            </div>


                            <div class="col-lg-6">
                                <div class="attach-file-section">
                                    <div class="row attach-item">
                                        <div class="col-11">
                                            <div class="row no-gutters input-right-icon">


                                                <div id="countryFlagFileDiv" class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                            for="">{{ __('ticket.attach_file') }}</label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text" id="attach"
                                                                placeholder="{{ __('ticket.attach_file') }}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="ticket_file">{{ __('common.browse') }} </label>
                                                                <input type="file" class="d-none" name="ticket_file[]"
                                                                    id="ticket_file">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('ticket_file.*'))
                                                    <span class="text-danger"
                                                        id="error_attach">{{ $errors->first('ticket_file.*') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1 mt-32 btn_margin"><button
                                                class="primary-btn small fix-gr-bg custom_plus_btn" type="button"
                                                id="ticket_file_add"> <i class="fa fa-plus"></i>
                                            </button></div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6" id="priority_list_div">
                                <div class="primary_input mb-15">
                                    <div class="double_label d-flex justify-content-between">
                                        <label class="primary_input_label" for="">{{__('ticket.priority')}} <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <select name="priority_id" id="priority_id" class="primary_select mb-15">
                                        <option value="" selected disabled>{{__('common.select_one')}}</option>
                                        @foreach ($PriorityList as $key => $item)
                                        <option value="{{ $item->id }}"
                                            {{isset($editData->priority_id)? ($item->id == @$editData->priority_id? 'selected':''):''}}>
                                            {{ $item->name }} </option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('priority_id'))
                                    <span class="text-danger"
                                        id="error_priority_id">{{ $errors->first('priority_id') }}</span>
                                    @endif

                                </div>

                            </div>


                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="description">{{ __('common.description') }}
                                        <span class="text-danger">*</span></label>

                                    <textarea name="description" id="description"
                                        class="summernote">{{ old('description') }}</textarea>
                                </div>
                                @if ($errors->has('description'))
                                <span class="text-danger" id="error_message">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="submit_btn text-center ">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"> <i
                                            class="ti-check"></i>{{__('ticket.create_ticket')}}</button>
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
<script>
    (function($){
            "use strict";
            $(document).ready(function() {

                $('#description').summernote({
                    placeholder: 'Write here',
                    tabsize: 2,
                    height: 200,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                $('.popover').css("display", "none");

                var index = 0;
                $(document).on('click', '#ticket_file_add', function() {
                    index = $('.attach-item').length
                    addNewFileAddItem(index)
                });

                $(document).on('click', '.delete-ticket-message-attach', function() {
                    $(this).parent().parent().remove();
                });

                $(document).on('change', '.file-upload-multi', function(e) {
                    let fileName = e.target.files[0].name;
                    $(this).parent().parent().parent().find('#placeholderStaffsName').attr('placeholder',
                        fileName);
                });

                $(document).on('change', '#ticket_file', function(){
                    getFileName($(this).val(),'#attach');
                });

                $(document).on('change', '.ticket_file', function(){
                    let value = $(this).data('value');
                    getFileName($(this).val(), value);
                });


                function addNewFileAddItem(index) {

                    var attachFile = `
                        <div class="row attach-item">
                            <div class="col-11">
                                <div class="row no-gutters input-right-icon">

                                    <div id="countryFlagFileDiv" class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.attach_file') }}</label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="attach_${index}"
                                                        placeholder="{{ __('common.browse_file') }}" readonly="">
                                                <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="ticket_file_${index}">{{ __('common.browse') }} </label>
                                                    <input type="file" class="d-none ticket_file" data-value="#attach_${index}" name="ticket_file[]" id="ticket_file_${index}">
                                                </button>
                                                </div>
                                            </div>

                                            <span class="text-danger" id="error_attach_${index}"></span>

                                        </div>


                                    </div>
                                </div>
                            <div class="col-1 mt-35 btn_margin"><button class="primary-btn delete-ticket-message-attach small fix-gr-bg custom_plus_btn" type="button"> <i class="fa fa-trash"></i> </button></div>
                        </div>

                    `;


                    $('.attach-file-section').append(attachFile);
                }


            });
        })(jQuery);

</script>
@endpush
