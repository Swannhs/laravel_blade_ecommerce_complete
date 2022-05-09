@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/giftcard/css/style.css'))}}" />

@endsection

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        @if (permissionCheck('admin.giftcard.delete'))
            @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.gift_card')])
        @endif
        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.gift_card') }} {{__('common.list')}}</h3>
                            @if (permissionCheck('admin.giftcard.create'))
                                <ul class="d-flex">
                                    <li><a href="{{ route('admin.giftcard.create') }}" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="ti-plus"></i>{{ __('common.add_new') }}</a></li>
                                    @if (permissionCheck('admin.giftcard.bulk_gift_card_upload_page'))
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('admin.giftcard.bulk_gift_card_upload_page') }}"><i class="ti-plus"></i>{{ __('product.bulk_upload') }}</a></li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div id="item_table">
                                @include('giftcard::giftcard.components._list')
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection

@include('giftcard::giftcard.components._scripts')
