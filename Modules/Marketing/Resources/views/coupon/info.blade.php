@extends('backEnd.master')

@section('mainContent')
    @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.coupon')])
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-30">{{ __('marketing.coupon_list') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('common.sl')}}</th>
                                        <th scope="col">{{__('common.type')}}</th>
                                        <th scope="col">{{__('common.title')}}</th>
                                        <th scope="col">{{__('common.coupon')}}</th>
                                        <th scope="col">{{__('marketing.total_discount')}}</th>
                                        <th scope="col">{{__('marketing.num_of_uses')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coupons as $key => $coupon)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>
                                                    @if ($coupon->coupon_type == 1)
                                                        {{__('marketing.product_base')}}
                                                    @elseif ($coupon->coupon_type == 2)
                                                        {{__('marketing.order_base')}}
                                                    @else
                                                        {{__('marketing.free_shipping')}}
                                                    @endif
                                                </td>
                                                <td>{{$coupon->title}}</td>
                                                <td>{{$coupon->coupon_code}}</td>
                                                <td>{{$coupon->coupon_uses->sum('discount_amount')}}</td>
                                                <td>{{@$coupon->coupon_uses->count()}}</td>
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
    </section>
@endsection
