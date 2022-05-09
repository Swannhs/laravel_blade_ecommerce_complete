@push('scripts')
    <script>
        (function($) {
        	"use strict";
            $(document).ready(function(){

                $(document).on('submit', '#create_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');

                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name,element.value);
                    });

                    let flag = $('#flag')[0].files[0];

                    if(flag){
                        formData.append('flag',flag);
                    }
                    formData.append('_token',"{{ csrf_token() }}");


                    resetValidationError();
                    $.ajax({
                        url: "{{ route('setup.country.store')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            resetAfterChange(response.TableData);
                            create_form_reset();
                            toastr.success("{{__('common.added_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');


                        },
                        error:function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            showValidationErrors('#create_form',response.responseJSON.errors);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('submit', '#edit_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let formElement = $(this).serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name,element.value);
                    });

                    let flag = $('#flag')[0].files[0];

                    if(flag){
                        formData.append('flag',flag);
                    }
                    formData.append('_token',"{{ csrf_token() }}");
                    resetValidationError();
                    $.ajax({
                        url: "{{ route('setup.country.update')}}",
                        type:"POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success:function(response){
                            resetAfterChange(response.TableData);
                            toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');

                            $('#formHtml').html(response.createForm);

                        },
                        error:function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            showValidationErrors('#edit_form',response.responseJSON.errors);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $(document).on('click', '.edit_country', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(this).data('id');
                    let base_url = $('#url').val();
                    let url = base_url + '/setup/location/country/edit/' +id;
                    $.get(url, function(response){
                        if(response){
                            $('#formHtml').html(response);
                        }
                        $('#pre-loader').addClass('d-none');
                    });

                });

                $(document).on('change', '#flag', function(event){
                    event.preventDefault();
                    getFileName($(this).val(),'#flag_file');
                    imageChangeWithFile($(this)[0],'#FlagPreview');

                });

                $(document).on('change', '.status_change', function(event){
                    event.preventDefault();
                    let status = 0;
                    if($(this).prop('checked')){
                        status = 1;
                    }
                    else{
                        status = 0;
                    }
                    let id = $(this).data('id');
                    $('#pre-loader').removeClass('d-none');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    formData.append('status', status);

                    $.ajax({
                        url: "{{ route('setup.country.status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });

                });


                function resetAfterChange(TableData){
                    $('#item_table').html(TableData);
                    CRMTableThreeReactive();
                }

                function create_form_reset(){
                    $('#create_form')[0].reset();
                    $('#countryFlagFileDiv').html(
                        `<div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('setup.flag') }} (61 X 36)</label>
                            <div class="primary_file_uploader">
                                <input class="primary-input" type="text" id="flag_file"
                                    placeholder="{{__('common.browse_image')}}" readonly="">
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                        for="flag">{{ __('common.browse') }} </label>
                                    <input type="file" class="d-none" name="flag" id="flag"
                                        onchange="getFileName(this.value,'#flag_file'),imageChangeWithFile(this,'#FlagPreview')">
                                </button>
                            </div>
                        </div>

                        <span class="text-danger" id="error_slider_image"></span>`
                    );
                    $('#createCountryFlagDiv').html(
                        `<img id="FlagPreview"
                            src="{{ showImage('flags/no_image.png') }}" alt="">`
                    );
                }

                function showValidationErrors(formType, errors){
                    $(formType +' #error_name').text(errors.name);
                    $(formType +' #error_code').text(errors.code);
                    $(formType +' #error_phonecode').text(errors.phonecode);
                }

                function resetValidationError(){
                    $('#error_name').html('');
                    $('#error_code').html('');
                    $('#error_phonecode').html('');
                }

            });
        })(jQuery);
    </script>
@endpush
