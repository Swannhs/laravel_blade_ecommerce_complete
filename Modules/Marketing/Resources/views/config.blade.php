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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.configuration') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="white_box_50px box_shadow_white mb-20">
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("marketing.news_letter")}} {{__("product.cronjob_url")}}</label>
                                        <input class="primary_input_field" name="cronjob_url" placeholder="{{__("product.cronjob_url")}}" type="text" value="{{route('marketing.news-letter.cronjob')}}" readonly>
                                        
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("marketing.bulk_sms")}} {{__("product.cronjob_url")}}</label>
                                        <input class="primary_input_field" name="cronjob_url" placeholder="{{__("product.cronjob_url")}}" type="text" value="{{route('marketing.bulk-sms.cronjob')}}" readonly>
                                        
                                    </div>
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
                
            });
        })(jQuery);
    </script>
@endpush
