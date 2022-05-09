@extends('backEnd.master')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/refund/css/style.css'))}}" />

@endsection
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-8 student-details">
                    <div class="white_box_50px box_shadow_white" id="printableArea">
                        <div class="row pb-30 border-bottom">
                            <div class="col-md-6 col-lg-6">
                                <div class="logo_div">
                                    <img src="{{showImage(app('general_setting')->logo)}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-right">
                                <h4><a href="{{route('order_manage.show_details',$refund_request->order_id)}}" target="_blank">{{$refund_request->order->order_number}}</a></h4>
                            </div>
                        </div>
                        <div class="row mt-30">
                            <div class="col-md-6 col-lg-6">
                                <table class="table-borderless clone_line_table">
                                    <tr>
                                        <td><strong>{{ __('refund.refund_related_info') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('common.status') }}</td>
                                        <td>: {{ $refund_request->CheckConfirmed }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('refund.request_sent') }}</td>
                                        <td>: {{ $refund_request->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('refund.refund_method') }}</td>
                                        <td>: {{ strtoupper(str_replace("_"," ",$refund_request->refund_method)) }}</td>
                                    </tr>
                                    @if ($refund_request->refund_method == "bank_transfer")
                                        <tr>
                                            <td>{{ __('refund.bank_name') }}</td>
                                            <td>: {{ $refund_request->bank_payments->bank_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('refund.branch_name') }}</td>
                                            <td>: {{ $refund_request->bank_payments->branch_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('refund.account_name') }}</td>
                                            <td>: {{ $refund_request->bank_payments->account_holder }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('refund.account_nb') }}</td>
                                            <td>: {{ $refund_request->bank_payments->account_number }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>{{ __('refund.shipping_method') }}</td>
                                        <td>: {{ strtoupper(str_replace("_"," ",$refund_request->shipping_method)) }}</td>
                                    </tr>
                                </table>
                            </div>
                            @if ($refund_request->shipping_method == "courier")
                                <div class="col-md-6 col-lg-6">
                                    <table class="table-borderless clone_line_table">
                                        <tr>
                                            <td><strong>{{ __('refund.pick_up_info') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('refund.shipping_gateway') }}</td>
                                            <td>: {{ @$refund_request->shipping_gateway->method_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.name') }}</td>
                                            <td>: {{ @$common_request->pick_up_address_customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.email') }}</td>
                                            <td>: {{ @$common_request->pick_up_address_customer->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.phone') }}</td>
                                            <td>: {{ @$common_request->pick_up_address_customer->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.address') }}</td>
                                            <td>: {{ @$refund_request->pick_up_address_customer->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('refund.post_code') }}</td>
                                            <td>: {{ @$refund_request->pick_up_address_customer->postal_code }}</td>
                                        </tr>
                                    </table>
                                </div>
                            @else
                                <div class="col-md-6 col-lg-6">
                                    <table class="table-borderless clone_line_table">
                                        <tr>
                                            <td><strong>{{ __('refund.drop_of_info') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('refund.shipping_gateway') }}</td>
                                            <td>: {{ @$refund_request->shipping_gateway->method_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.address') }}</td>
                                            <td>: {{ @$refund_request->drop_off_address }}</td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="row mt-30">
                            @foreach ($refund_request->refund_details as $key => $refund_detail)
                                <div class="col-12 mt-30">
                                    <div class="box_header common_table_header">
                                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.package') }}:
                                            {{ @$refund_detail->order_package->package_code }} <small>({{ @$refund_detail->process_refund->name }})</small></h3>


                                        <ul class="d-flex float-right">
                                            @if(isModuleActive('MultiVendor'))
                                            <li> <strong>@if(@$refund_detail->order_package->seller->role->type == 'seller'){{ (@$refund_detail->order_package->seller->SellerAccount->seller_shop_display_name) ? @$refund_detail->order_package->seller->SellerAccount->seller_shop_display_name : @$order_package->seller->first_name }} @else Inhouse @endif</strong> </li>
                                            @else
                                                @if (permissionCheck('refund.update_refund_detail_state_by_seller'))
                                                    <li>
                                                        <a href="" data-id="{{$refund_detail->id}}" class="primary_btn manage_package"><i class="fas fa-cog"></i> Manage Refund Process</a>
                                                    </li>
                                                @endif
                                            @endif
                                        </ul>

                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table ">
                                            <!-- table-responsive -->
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th scope="col">{{ __('common.sl') }}</th>
                                                        <th scope="col">{{ __('common.photo') }}</th>
                                                        <th scope="col">{{ __('common.name') }}</th>
                                                        <th scope="col">{{ __('refund.return_qty') }}</th>
                                                        <th scope="col">{{ __('common.total_amount') }}</th>
                                                        <th scope="col">{{ __('refund.reason') }}</th>
                                                    </tr>
                                                    @foreach ($refund_detail->refund_products as $key => $package_product)
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>
                                                                <div class="product_img_div">
                                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                        <img src="{{showImage(@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                    @else
                                                                        <img src="{{showImage(@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="text-nowrap">{{ @$package_product->seller_product_sku->sku->product->product_name }}</td>
                                                            <td class="text-nowrap">{{ $package_product->return_qty }}</td>
                                                            <td class="text-nowrap">{{ single_price($package_product->return_amount) }}</td>
                                                            <td>{{ @$package_product->refund_reason->reason }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row mt-30">
                            <div class="col-md-12">
                                <h5>{{ __('refund.additional_info') }}</h5>
                                <p>{{ $refund_request->additional_info }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if (permissionCheck('refund.update_refund_request_by_admin'))
                    <div class="col-lg-4 student-details">
                        <form action="{{ route('refund.update_refund_request_by_admin', $refund_request->id) }}" method="post">
                            @csrf
                            <div class="row white_box p-25 ml-0 mr-0 box_shadow_white">
                                <div class="col-lg-12 p-0">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for=""> <strong>{{ __('refund.request_confirmation') }}</strong> </label>
                                        <select class="primary_select mb-25" name="is_confirmed" id="is_confirmed">
                                            <option value="0" @if ($refund_request->is_confirmed == 0) selected @endif>{{ __('order.pending') }}</option>
                                            <option value="1" @if ($refund_request->is_confirmed == 1) selected @endif>{{ __('order.confirmed') }}</option>
                                            <option value="2" @if ($refund_request->is_confirmed == 2) selected @endif>{{ __('order.declined') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 p-0">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for=""> <strong>{{ __('refund.refund_money_status') }}</strong> </label>
                                        <select class="primary_select mb-25" name="is_refunded" id="is_refunded">
                                            <option value="0" @if ($refund_request->is_refunded == 0) selected @endif>{{ __('order.pending') }}</option>
                                            <option value="1" @if ($refund_request->is_refunded == 1) selected @endif>{{ __('order.paid') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 p-0">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for=""> <strong>{{ __('refund.is_completed') }}</strong> </label>
                                        <select class="primary_select mb-25" name="is_completed" id="is_completed">
                                            <option value="0" @if ($refund_request->is_completed == 0) selected @endif>{{ __('order.pending') }}</option>
                                            <option value="1" @if ($refund_request->is_completed == 1) selected @endif>{{ __('refund.completed') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 p-0">
                                    <button class="primary_btn_2"><i class="ti-check"></i>{{ __('common.update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        @if(!isModuleActive('MultiVendor'))
        <div id="manage_package_div">

        </div>
        @endif
    </section>

@endsection
@push("scripts")
    <script type="text/javascript">

        (function($){
            "use Strict";
            $(document).ready(function() {
                $(document).on('click', '.manage_package', function(event) {
                    event.preventDefault();
                    let package_id = $(this).data('id');

                    let url = "{{route('refund.get_refund_package_data')}}";
                    let data = {
                        '_token' : "{{ csrf_token() }}",
                        'id' : package_id
                    }
                    $('#pre-loader').removeClass('d-none');
                    $.post(url, data, function(response) {
                        $('#manage_package_div').html(response);
                        $('#package_modal').modal('show');
                        $('#pre-loader').addClass('d-none');
                        $('#processing_state').niceSelect();
                    });

                });
            });
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
                setTimeout(function () {
                    window.location.reload();
                }, 15000);
            }
        })(jQuery);


    </script>
@endpush
