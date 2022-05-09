@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/generalsetting/css/style.css'))}}" />
@endsection
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white_box_30px mb_30">
                <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="box_header">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30" >{{ __('general_settings.general_settings') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            @include('generalsetting::page_components.general_settings')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function() {
                $('.summernote').summernote({
                    placeholder: '',
                    tabsize: 2,
                    height: 500,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                $(document).on('change', '#site_logo', function(event){
                    imageChangeWithFile($(this)[0],'#generalSettingLogo');
                });
                $(document).on('change', '#favicon_logo', function(event){
                    imageChangeWithFile($(this)[0],'#generalSettingFavicon');
                });
                $(document).on('change', '#shop_link_banner', function(event){
                    imageChangeWithFile($(this)[0],'#shopLinkBanner');
                });

                $(document).on('change', '#default_country_id', function(event){
                    let country = $('#default_country_id').val();
                    $('#pre-loader').removeClass('d-none');
                    if(country != null){
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-state?country_id=' +country;

                        $('#default_state_id').empty();

                        $('#default_state_id').append(
                            `<option value="" selected>{{__('common.select_one')}}</option>`
                        );
                        $('#default_state_id').niceSelect('update');
                        $.get(url, function(data){

                            $.each(data, function(index, stateObj) {
                                $('#default_state_id').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                            });

                            $('#default_state_id').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
