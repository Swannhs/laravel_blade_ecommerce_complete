@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/wishlist.css'))}}" />

<link rel="stylesheet" href="{{asset(asset_path('backend/css/cart_modal.css'))}}" />
@endsection


@section('mainContent')
<!--  dashboard part css here -->

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-xl-12">
                <div class="white_box_30px mb_30">
                    <div id="productShow">
                        @include('backEnd.pages.customer_data._wishlist_with_paginate')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
    <div class="add-product-to-cart-using-modal">

    </div>
</section>
@include('backEnd.partials._deleteModalForAjax',['item_name' => __('defaultTheme.wishlist_product'),'form_id' =>
'wishlist_delete_form','modal_id' => 'wishlist_delete_modal'])
@endsection
@push('scripts')
<script type="text/javascript">
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
                    $('#productShow').html(response);
                    $('#product_short_list').niceSelect();
                    $('#paginate_by').niceSelect();
                    $('#pre-loader').hide();
                },
                error: function(response) {
                    toastr.error('{{__("common.error_message")}}', "{{__('common.error')}}");
                    $('#pre-loader').hide();
                }
            });
        });
    });
    $(document).on('change','.paginate_no', function(){
        getFilterUpdateByIndex()
    });
    $(document).on('change','.sort_by', function(){
        getFilterUpdateByIndex()
    });
    $(document).on('click','.removeFromWhishlist', function(event){
        event.preventDefault();
        $('#wishlist_delete_modal').modal('show');
        $('#delete_item_id').val($(this).attr("data-product-id"));
    });
    function getFilterUpdateByIndex(){

        var paginate = $('#paginate_by').val();
        var sort_by = $('#product_short_list').val();
        $("#pre-loader").removeClass('d-none');
        $.get("{{ route('frontend.my-wishlist.paginate-data') }}", {sort_by:sort_by, paginate:paginate}, function(data){
            $('#productShow').html(data);
            $('#product_short_list').niceSelect();
            $('#paginate_by').niceSelect();
            $("#pre-loader").addClass('d-none');
        });
    }
    function removeWishlist(id){
        $('#wishlist_delete_modal').modal('show');
        $('#delete_item_id').val(id);
    }
</script>
@include(theme('partials.add_to_cart_script'))
@include(theme('partials.add_to_compare_script'))
@endpush
