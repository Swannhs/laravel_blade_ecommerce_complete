@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/shipping/css/style.css'))}}" />
   
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                @if (permissionCheck('shipping_methods.store'))
                    <div class="col-lg-4">
                        <div class="create_div">
                            @include('shipping::shipping_methods.components._create')
                        </div>
                    </div>
                @endif

                <div class="col-lg-8">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('shipping.shipping_method') }}</h3>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div id="method_list">
                                @include('shipping::shipping_methods.components._method_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('backEnd.partials._deleteModalForAjax',['item_name' => __('shipping.shipping_method'),'form_id' =>
'shipping_delete_form','modal_id' => 'shipping_delete_modal', 'delete_item_id' => 'shipping_delete_id'])

@endsection

@include('shipping::shipping_methods.components._scripts')
