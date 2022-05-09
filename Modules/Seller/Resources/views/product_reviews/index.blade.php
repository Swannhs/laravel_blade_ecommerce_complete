@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/style.css'))}}" />


@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div id="replyModalDiv">

    </div>
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('review.product_review_list')}}</h3>

                    </div>
                </div>
            </div>
            @if (permissionCheck('seller.product-reviews.get-data'))
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="table-responsive" id="item_table">
                                @include('seller::product_reviews.components.list')
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

</section>
@endsection
@include('seller::product_reviews.components.scripts')
