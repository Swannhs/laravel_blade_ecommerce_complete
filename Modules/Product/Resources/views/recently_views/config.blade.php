@extends('backEnd.master')
@section('styles')
    <style>
        #logoImg{
            margin-bottom: 10px;
            width: 40%;
            height: auto;
            margin-top: -10px;
        }
    </style>
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.recently_viewed_product_configuration') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{route("product.recent_view_product_config_update")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="white_box_50px box_shadow_white mb-20">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("product.max_limit_of_product_store_for_per_user")}} <span class="text-danger">*</span></label>
                                        <input class="primary_input_field" name="max_limit" placeholder="{{__("product.max_limit_of_product_store_for_per_user")}}" type="number" min="6" step="1" value="{{app('recently_viewed_config')['max_limit']}}">
                                        @error('max_limit')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("product.remove_stored_data_after_days")}} <span class="text-danger">*</span></label>
                                        <input class="primary_input_field" name="number_of_days" placeholder="{{__("product.remove_stored_data_after_days")}}" type="number" min="1" step="1" value="{{app('recently_viewed_config')['number_of_days']}}">
                                        @error('number_of_days')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("product.cronjob_url")}} <span class="text-danger">*</span></label>
                                        <input class="primary_input_field" name="cronjob_url" placeholder="{{__("product.cronjob_url")}}" type="text" value="{{route('product.recently_view_product_cronejob')}}" readonly>
                                        @error('cronjob_url')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="primary_btn_2"><i class="ti-check"></i>{{__("common.save")}} </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
			        codeviewIframeFilter: true
                });
                $(document).on('change', '#logo', function(event){
                    getFileName($(this).val(),'#logo_file');
                    imageChangeWithFile($(this)[0],'#logoImg');
                });
            });
        })(jQuery);
    </script>
@endpush
