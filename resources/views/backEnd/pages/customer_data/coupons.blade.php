@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/coupons.css'))}}" />
@endsection
@section('mainContent')
<!--  dashboard part css here -->
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-xl-12 mb-30">
                <div class="white_box_30px">
                    <form type="POST" id="couponForm">
                        <div class="input-group">
                            <input type="text" name="code" class="form-control primary_input_field" id="code" placeholder="{{__('common.coupon_code')}}"/>
                            <div class="input-group-append">
                              <button id="addCodeBtn" type="button" class="primary_btn_2 input-group-text">{{__('common.add')}}</button>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="white_box_30px">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('customer_panel.my_coupon')}}</h3>
                    </div>

                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div id="couponDiv">
                                @include('backEnd.pages.customer_data._coupon_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','#addCodeBtn', function(event){
            let code = $('#code').val();
            console.log(code)
            if(code){
                $('#pre-loader').removeClass('d-none');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('code', code);
                console.log(formData);
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
                            $('#pre-loader').addClass('d-none');
                        }else{
                            $('#couponDiv').empty();
                            $('#couponDiv').html(response.CouponList);
                            $('#pre-loader').addClass('d-none');
                            toastr.success("{{__('defaultTheme.coupon_store_successfully')}}","{{__('common.success')}}");
                            $('#code').val('');
                        }
                    },
                    error: function (response) {
                        if(response.responseJSON.error){
                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                    $('#pre-loader').addClass('d-none');
                    return false;
                }
                        $('#pre-loader').addClass('d-none');

                    }
                });
            }else{
                toastr.error("{{__('defaultTheme.coupon_code_in_required')}}",'common.error');
            }
        });
    });

    $(document).on('click', '.deleteCoupon', function(){
        couponDelete($(this).attr("data-id"));
    });

    function couponDelete(id){
        $('#pre-loader').removeClass('d-none');
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
                $('#pre-loader').addClass('d-none');
                toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
            },
            error: function (response) {
                if(response.responseJSON.error){
                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                    $('#pre-loader').addClass('d-none');
                    return false;
                }
                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
            }
        });
    }

    </script>
@endpush
