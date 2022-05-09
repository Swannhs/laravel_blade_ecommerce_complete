@extends('frontend.default.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/wishlist.css'))}}" />
   
@endsection
@section('breadcrumb')
    {{__('defaultTheme.wishlist')}}
@endsection

@section('content')

    @include('frontend.default.partials._breadcrumb')

    <!--  dashboard part css here -->
    <section class="dashboard_part bg-white padding_top">
        <div class="container">
            <div class="row">
                @include('frontend.default.pages.profile.partials._menu')


                <div id="productShow" class="col-lg-8 col-xl-9">

                    @include('frontend.default.pages.profile.partials._wishlist_with_paginate')
                </div>


            </div>
        </div>

        @include('frontend.default.partials._delete_modal_for_ajax',['item_name' => __('defaultTheme.wishlist_product'),'form_id' => 'wishlist_delete_form','modal_id' => 'wishlist_delete_modal'])
    </section>
    <!-- dashboard part css here -->
    <div class="add-product-to-cart-using-modal">

    </div>

@endsection

@push('scripts')
    <script>

        (function($){
            "use strict";

            $(document).ready(function(){
                $(document).on('click', '.page-item a', function(event) {
                    event.preventDefault();
                    let page = $(this).attr('href').split('page=')[1];
                    fetch_filter_data(page);

                });

                function fetch_filter_data(page){
                    $('#pre-loader').show();
                    var paginate = $('#paginate_by').val();
                    var sort_by = $('#product_short_list').val();
                    if (sort_by != null && paginate != null) {
                        var url = "{{route('frontend.my-wishlist.paginate-data')}}"+'?sort_by='+sort_by+'&paginate='+paginate+'&page='+page;
                    }else if (sort_by == null && paginate != null) {
                        var url = "{{route('frontend.my-wishlist.paginate-data')}}"+'?paginate='+paginate+'&page='+page;
                    }else {
                        var url = "{{route('frontend.my-wishlist.paginate-data')}}"+'?page='+page;
                    }
                    if(page != 'undefined'){
                        $.ajax({
                            url:url,
                            success:function(data)
                            {
                                $('#productShow').html(data);
                                $('#product_short_list').niceSelect();
                                $('#paginate_by').niceSelect();
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.warning("{{__('common.error_message')}}");
                    }

                }

                $(document).on('click', '.removeWishlist', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#wishlist_delete_modal').modal('show');
                });

                $(document).on('click', '#wishlist_delete_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').show();
                    $('#wishlist_delete_modal').modal('hide');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', $('#delete_item_id').val());
                    formData.append('sort_by', $('#product_short_list').val());
                    formData.append('paginate', $('#paginate_by').val());
                    $.ajax({
                        url: "{{ route('frontend.wishlist.remove') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                            $('#productShow').html(response.page);
                            $('#product_short_list').niceSelect();
                            $('#paginate_by').niceSelect();
                            $('#pre-loader').hide();
                            $('.wishlist_count').text(response.totalItems);
                        },
                        error: function(response) {
                            toastr.error('{{__("common.error_message")}}', "{{__('common.error')}}");
                            $('#pre-loader').hide();
                        }
                    });
                });

                $(document).on('change', '.getFilterUpdateByIndex', function(event){
                    getFilterUpdateByIndex();
                });

                function getFilterUpdateByIndex(){

                    var paginate = $('#paginate_by').val();
                    var sort_by = $('#product_short_list').val();
                    $('#pre-loader').show();
                    $.get("{{ route('frontend.my-wishlist.paginate-data') }}", {sort_by:sort_by, paginate:paginate}, function(data){
                        $('#productShow').html(data);
                        $('#product_short_list').niceSelect();
                        $('#paginate_by').niceSelect();
                        $('#pre-loader').hide();
                    });
                }

                $(document).on('click', ".add_to_cart_gift_thumnail", function(event) {
                    event.preventDefault();
                    addToCart($(this).attr('data-gift-card-id'),$(this).attr('data-seller'),1,$(this).attr('data-base-price'),1,'gift_card');
                });

            });
        })(jQuery);

    </script>
@endpush
@include(theme('partials.add_to_cart_script'))
@include(theme('partials.add_to_compare_script'))
