@extends('backEnd.master')
@section('mainContent')
<!--  dashboard part css here -->
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-xl-12">
                <div class="white_box_30px">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('customer_panel.purchased_digital_products')}}</h3>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active2">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.name') }}</th>
                                        <th scope="col" width="10%">{{ __('customer_panel.is_used') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($digital_products as $key => $digital_product)
                                            <tr>
                                                <td>{{ $digital_product->seller_product_sku->product->product_name }}</td>
                                                <td>
                                                    <a class="primary_btn_2 gift_card_redeem" href="{{ route('digital_file_download', encrypt($digital_product->id)) }}">Download</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
