@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{ __('ticket.ticket') }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/ticket/index.css'))}}" />

@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
                <div class="referral_item">
                    <div id="dataShow" class="single_coupons_item cart_part">

                        @include('frontend.default.pages.ticket.partials._ticket_list_with_paginate')

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
                $('#status_by').niceSelect();
                $(document).on('click', '.page-item a', function(event) {
                    event.preventDefault();
                    let page = $(this).attr('href').split('page=')[1];
                    fetch_filter_data(page);

                });

                function fetch_filter_data(page){
                    $('#pre-loader').show();
                    var status = $('#status_by').val();
                    if(status != null) {
                        var url = "{{route('frontend.support-ticket.paginate')}}"+'?status='+status+'&page='+page;
                    }else {
                        var url = "{{route('frontend.support-ticket.paginate')}}"+'?page='+page;
                    }

                    if(page != 'undefined'){
                        $.ajax({
                            url:url,
                            success:function(data)
                            {
                                $('#dataShow').html(data);
                                $('#status_by').niceSelect();
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.warning("{{__('common.error_message')}}");
                    }

                }

                $(document).on('change', '#status_by', function(event){
                    getFilterUpdateByIndex();
                });

                function getFilterUpdateByIndex(){
                    $('#pre-loader').show();
                    let status = $('#status_by').val();

                    $.get("{{ route('frontend.support-ticket.paginate') }}", {status : status}, function(data){
                        $('#dataShow').html(data);
                        $('#status_by').niceSelect();
                        $('#pre-loader').hide();
                    });
                }
            });
        })(jQuery);

</script>

@endpush
