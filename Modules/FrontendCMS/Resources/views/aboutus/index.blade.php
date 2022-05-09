@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/frontendcms/css/style.css'))}}" />
@endsection
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">{{__('frontendCms.about_us_contant')}}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        @include('frontendcms::aboutus.components.form')
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
                $(document).on('keyup', '#mainTitle', function(event){
                    processSlug($(this).val(), '#slug');
                });

                $(document).on('change', '#document_file_1', function(event){
                    getFileName($(this).val(),'#image_sec_1');
                    imageChangeWithFile($(this)[0],'#AboutUsImgShow_1');
                });

                $(document).on('change', '#document_file_2', function(event){
                    getFileName($(this).val(),'#image_sec_2');
                    imageChangeWithFile($(this)[0],'#AboutUsImgShow_2')
                });
            });
        })(jQuery);
    </script>

@endpush
