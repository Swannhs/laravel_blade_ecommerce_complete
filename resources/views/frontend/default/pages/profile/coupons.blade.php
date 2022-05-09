@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{ __('customer_panel.my_coupon') }}
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/coupons.css'))}}" />

@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
               <div class="coupons_item">
                   <div class="single_coupons_item cart_part">
                       <div class="row">
                        <div class="col-lg-12">
                            <div class="my-link">
                                <h5>{{__('defaultTheme.add_coupon')}}</h5>
                                <div class="codeDiv">
                                    <form type="POST" id="couponForm">
                                        <div class="input-group">
                                            <input type="text" name="code" class="form-control" id="code" placeholder="{{__('common.code')}}"/>
                                            <div class="input-group-append">
                                              <button id="addBtn" type="submit" class="input-group-text">{{__('common.add')}}</button>
                                            </div>
                                          </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                       </div>
                       <div id="couponDiv" class="row mt_50">
                           <div class="col-lg-12">
                               <div class="table-responsive">
                                    @include('frontend.default.pages.profile.partials._coupon_list')
                               </div>

                           </div>
                       </div>



                    </div>
               </div>
            </div>
        </div>
    </div>
    @include('frontend.default.partials._delete_modal_for_ajax',['item_name' => __('defaultTheme.coupon'),'form_id' => 'coupon_delete_form','modal_id' => 'coupon_delete_modal'])
</section>


@endsection
@push('scripts')
    <script>

        (function($){
            "use strict";

            $(document).ready(function(){
                $(document).on('submit','#couponForm', function(event){
                    event.preventDefault();
                    let code = $('#code').val();
                    if(code){
                        $('#pre-loader').show();
                        let formElement = $(this).serializeArray()
                        let formData = new FormData();
                        formElement.forEach(element => {
                            formData.append(element.name, element.value);
                        });
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('form', 'modal_form');
                        $.ajax({
                            url: "{{route('frontend.profile.coupon.store')}}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                if(response.error){
                                    toastr.error(response.error,'Error');
                                    $('#pre-loader').hide();
                                }else{
                                    $('#couponDiv').empty();
                                    $('#couponDiv').html(response.CouponList);
                                    $('#pre-loader').hide();
                                    toastr.success("{{__('defaultTheme.coupon_store_successfully')}}","{{__('common.success')}}");
                                    $('#code').val('');
                                }
                            },
                            error: function (response) {
                                if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').hide();
                                    return false;
                                }
                                $('#pre-loader').hide();

                            }
                        });
                    }else{
                        toastr.error("{{__('defaultTheme.coupon_code_in_required')}}",'common.error');
                    }
                });

                $(document).on('click', '.coupon_delete_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#coupon_delete_modal').modal('show');
                });

                $(document).on('submit', '#coupon_delete_form', function(event){
                    event.preventDefault();

                    couponDelete($('#delete_item_id').val());

                });
                function couponDelete(id){
                    $('#pre-loader').show();
                    $('#coupon_delete_modal').modal('hide');
                    let formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    $.ajax({
                        url: "{{route('frontend.profile.coupon.delete')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            $('#couponDiv').empty();
                            $('#couponDiv').html(response.CouponList);
                            $('#pre-loader').hide();
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                        },
                        error: function (response) {
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                    });
                }
            });
        })(jQuery);

    </script>
@endpush
