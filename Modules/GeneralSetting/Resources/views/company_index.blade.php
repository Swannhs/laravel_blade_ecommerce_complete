@extends('backEnd.master')

@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="white_box_30px">
                            @include('generalsetting::page_components.company_info_settings')
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

            $(document).on('change', '#business_country', function(event){
                let country = $('#business_country').val();

                $('#pre-loader').removeClass('d-none');
                if(country){
                    let base_url = $('#url').val();
                    let url = base_url + '/seller/profile/get-state?country_id=' +country;

                    $('#business_state').empty();

                    $('#business_state').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#business_state').niceSelect('update');
                    $('#business_city').empty();
                    $('#business_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#business_city').niceSelect('update');
                    $.get(url, function(data){

                        $.each(data, function(index, stateObj) {
                            $('#business_state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                        });

                        $('#business_state').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });

            $(document).on('change', '#business_state', function(event){
                let state = $('#business_state').val();

                $('#pre-loader').removeClass('d-none');
                if(state){
                    let base_url = $('#url').val();
                    let url = base_url + '/seller/profile/get-city?state_id=' +state;

                    $('#business_city').empty();

                    $('#business_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#business_city').niceSelect('update');

                    $.get(url, function(data){

                        $.each(data, function(index, cityObj) {
                            $('#business_city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        });

                        $('#business_city').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });
        });

    })(jQuery);

</script>
@endpush

