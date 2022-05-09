@extends('backEnd.master')
@push('css')

<link rel="stylesheet" href="{{asset(asset_path('modules/product/css/style.css'))}}" />

@endpush
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <div class="box_header">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30">{{ __('product.bulk_product_upload') }}</h3>
                                </div>
                            </div>
                            <form action="{{ route('product.bulk_product_store') }}" method="POST" enctype="multipart/form-data" class="csvForm">
                                @csrf
                                <div class="row form">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                       <div class="primary_input mb-15">
                                          <label class="primary_input_label" for="">{{ __('common.csv_upload') }} <small><a class="d-flex float-right" href="{{ asset(asset_path('bulk_upload_sample/product.xlsx')) }}" download>{{ __('common.sample_file_download') }}</a><small> </label>
                                          <div class="primary_file_uploader">
                                             <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{ __('common.browse_file') }}" readonly="">
                                             <button class="" type="button">
                                             <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.browse")}} </label>
                                             <input type="file" class="d-none" accept=".xlsx, .xls, .csv" name="file" id="document_file_1">
                                             </button>
                                          </div>
                                          <span class="red">{{$errors->first('file')}}</span>
                                       </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                       <div class="primary_input mb-15">
                                          <label class="primary_input_label red_text" for="">{{ __('common.download_warning') }}</label>
                                       </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="submit_btn text-center ">
                                        <button class="primary-btn semi_large2 fix-gr-bg csvFormBtn" type="submit"><i class="ti-check"></i>{{__('common.upload_csv')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push("scripts")
   <script type="text/javascript">
        $( document ).ready(function() {
            $( ".csvFormBtn" ).attr("disabled", false);
        });
        $( ".csvFormBtn" ).on( "click", function() {
            $(".csvForm").submit();
            $( ".csvFormBtn" ).attr("disabled", true);
         });
    </script>
@endpush
