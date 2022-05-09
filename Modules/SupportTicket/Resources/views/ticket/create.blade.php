@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/supportticket/css/create.css'))}}" />
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

                    <form class="form-horizontal" action="{{ route('ticket.tickets.store') }}" method="POST"
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

                            <div class="col-lg-6 col-xl-3" id="category_list_div">
                                @include('supportticket::ticket.components._category_list_select')

                            </div>
                            <div class="col-lg-6 col-xl-3" id="priority_list_div">
                                @include('supportticket::ticket.components._priority_list_select')

                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.user') }}
                                        {{ __('common.list') }}</label>
                                    <select name="user_id" id="user_id" class="primary_select mb-15">
                                        <option value="" selected disabled>{{__('common.select_one')}}</option>
                                        @foreach ($UserList as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->getFullNameAttribute() }}
                                            [{{ $item->role->type }}]</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('user_id'))
                                    <span class="text-danger" id="error_user_id">{{ $errors->first('user_id') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="col-lg-6 col-xl-3" id="status_list_div">
                                @include('supportticket::ticket.components._status_list_select')

                            </div>

                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('ticket.assign_to')}}</label>
                                    <select name="refer_id" id="refer_id" class="primary_select mb-15">
                                        <option value="" selected disabled>{{__('common.select_one')}}</option>
                                        @foreach ($AgentList as $key => $item)
                                        <option value="{{ $item->id }}">{{ $item->getFullNameAttribute() }}
                                            [{{ $item->id == 1?'Super Admin':$item->role->type }}] </option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('refer_id'))
                                    <span class="text-danger"
                                        id="error_refer_id">{{ $errors->first('refer_id') }}</span>
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
                                                                placeholder="{{ __('common.browse_file') }}"
                                                                readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="ticket_file">{{ __('common.browse') }} </label>
                                                                <input type="file" class="d-none ticket_file_input" name="ticket_file[]" id="ticket_file" data-value="#attach">
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

    @include('supportticket::ticket.components._add_priority_modal')
    @include('supportticket::ticket.components._add_category_modal')
    @include('supportticket::ticket.components._add_status_modal')
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

            $(document).on('change', '.ticket_file_input', function(){
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
                                            <label class="primary_input_label" for="">{{ __('ticket.attach_file') }}</label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="attach_${index}"
                                                        placeholder="{{ __('common.browse_file') }}" readonly="">
                                                <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="ticket_file_${index}">{{ __('common.browse') }} </label>
                                                    <input type="file" class="d-none ticket_file_input" name="ticket_file[]" id="ticket_file_${index}" data-value="#attach_${index}">
                                                </button>
                                            </div>
                                        </div>

                                         <span class="text-danger" id="error_attach_${index}"></span>

                                     </div>

                                </div>
                            </div>
                        <div class="col-1 mt-32 btn_margin"><button class="primary-btn delete-ticket-message-attach small fix-gr-bg custom_plus_btn" type="button"> <i class="fa fa-trash"></i> </button></div>
                    </div>

                `;
                $('.attach-file-section').append(attachFile);
            }

                $(document).on('click', '#add_new_priority', function(event){
                    event.preventDefault();
                    $('#priorityCreateModal').modal('show');
                });
                $(document).on('click', '#add_new_category', function(event){
                    event.preventDefault();
                    $('#categoryCreateModal').modal('show');
                });
                $(document).on('click', '#add_new_status', function(event){
                    event.preventDefault();
                    $('#statusCreateModal').modal('show');
                });

                $(document).on('submit', '#add_priority_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#error_priority_name').text('');
                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name,element.value);
                    });

                    formData.append('_token',"{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('ticket.priority.store')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            toastr.success("{{__('common.added_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                            $('#priorityCreateModal').modal('hide');
                            $('#priority_list_div').html(response);
                            $('#priority_id').niceSelect();
                            $('#add_priority_form')[0].reset();
                        },
                        error:function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $('#error_priority_name').text(response.responseJSON.errors.name);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit', '#add_category_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#error_category_name').text('');
                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name,element.value);
                    });

                    formData.append('_token',"{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('ticket.category.store')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            toastr.success("{{__('common.added_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                            $('#categoryCreateModal').modal('hide');
                            $('#category_list_div').html(response);
                            $('#category_id').niceSelect();
                            $('#add_category_form')[0].reset();
                        },
                        error:function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $('#error_category_name').text(response.responseJSON.errors.name);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit', '#add_status_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#error_status_name').text('');
                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name,element.value);
                    });

                    formData.append('_token',"{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('ticket.status.store')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            toastr.success("{{__('common.added_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                            $('#statusCreateModal').modal('hide');
                            $('#status_list_div').html(response);
                            $('#status').niceSelect();
                            $('#add_status_form')[0].reset();
                        },
                        error:function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $('#error_status_name').text(response.responseJSON.errors.name);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

        });
    })(jQuery);

</script>
@endpush
