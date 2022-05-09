@extends('backEnd.master')

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/appearance/css/theme_create.css'))}}" />
@endsection

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">{{ __('appearance.upload_theme') }}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="white_box_50px box_shadow_white text-center">
                        <h4>{{ __('appearance.upload_title') }}</h4>

                        <div class="card mt-25 p-50">
                            <form action="{{ route('appearance.themes.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="row mt-50">
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-35">
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                    placeholder="{{ __('appearance.browse_zip') }}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                        for="document_file_1">{{ __('common.browse') }}</label>
                                                    <input type="file" class="d-none" name="themeZip" id="document_file_1">
                                                </button>
                                                @if ($errors->has('themeZip'))
                                                <span class="text-danger" id="error_subject">{{ $errors->first('themeZip') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 pt-6">
                                        <button id="submitBtn" type="submit" disabled
                                            class="btn primary_btn_2">{{ __('appearance.install_now') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
        $(document).ready(function(){
            $(document).on('change', '#document_file_1', function(event){
                let value = $('#document_file_1').val();
                getFileName(value,'#placeholderFileOneName');
                $('#submitBtn').attr('disabled', false);
            });
        });

    })(jQuery);


</script>
@endpush
