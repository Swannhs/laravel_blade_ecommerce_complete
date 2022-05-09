@extends('backEnd.master')

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/supplier.css'))}}" />


@endsection

@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('seller.supplier_profile') }}</h3>
                        </div>

                        <ul class="d-flex">
                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                    href="{{route('seller.supplier.edit',$supplier->id)}}"><i
                                        class="ti-pen"></i>{{ __('common.edit') }}</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <img class="student-meta-img img-100 mb-3" src="{{$supplier->photo?$supplier->photo:''}}"
                                alt="">
                            <h3>{{ __('seller.office_xtract') }}</h3>
                            <table class="table table-borderless supplier_view">
                                <tr>
                                    <td>{{ __('common.name') }}</td>
                                    <td>: <span class="ml-1"></span>{{$supplier->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.email') }}</td>
                                    <td>: <span class="ml-1"></span>{{$supplier->email}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.phone') }}</td>
                                    <td>: <span class="ml-1"></span>{{$supplier->phone}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('seller.pay_term') }}</td>
                                    <td>: <span class="ml-1">{{$supplier->payterm}}</span></td>
                                </tr>
                                <tr>
                                    <td>{{ __('seller.pay_condition') }}</td>
                                    <td>: <span class="ml-1"></span>{{$supplier->payterm_condition==1?'Months':'Days'}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.address') }}</td>
                                    <td>: <span class="ml-1">{{$supplier->address}}</span></td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.country') }}</td>
                                    <td>: <span class="ml-1"></span>{{$supplier->country()->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.state') }}</td>
                                    <td>: <span class="ml-1"></span>Dhaka</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.city') }}</td>
                                    <td>: <span class="ml-1"></span>Dhaka</td>
                                </tr>
                                <tr>
                                    <td>{{ __('seller.tax_number') }}</td>
                                    <td>: <span class="ml-1"></span>{{$supplier->tax_number}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('seller.opening_balance') }}</td>
                                    <td>: <span class="ml-1"></span>{{single_price($supplier->opening_balance)}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.registered_date') }}</td>
                                    <td>: <span class="ml-1"></span>6 Jan, 2021</td>
                                </tr>
                                <tr>
                                    <td>{{ __('common.status') }}</td>
                                    <td>: <span class="ml-1"></span>
                                        @if($supplier->status == 1)
                                        <span class="badge_1">{{ __('common.active') }}</span>
                                        @else{
                                        <span class="badge_2">{{ __('common.inactive') }}</span>
                                        }
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-12 supplier_profile">
                            <h3>Purchase Information</h3>
                            <table class="table table-borderless supplier_view">
                                <tr>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                            <a href="http://trading.rishfa.com/contact/supplier/purchase-porduct-list/14"
                                class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-bars"></i>
                                {{ __('common.products') }}</a>
                        </div>
                        <div class="col-md-1 col-lg-1 col-sm-12"></div>
                        <div class="col-md-4 col-lg-4 col-sm-12 supplier_profile">
                            <h3>{{ __('seller.finance_information') }}</h3>
                            <table class="table table-borderless supplier_view">
                                <tr>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                            <a data-toggle="modal" data-target="#addBalanceModal"
                                class="primary-btn radius_30px mr-10 fix-gr-bg text-white"><i class="fa fa-bars"></i>
                                {{ __('common.add') }} {{ __('common.balance') }}</a>
                            <a data-toggle="modal" data-target="#substractBalanceModal"
                                class="primary-btn radius_30px mr-10 fix-gr-bg text-white"><i
                                    class="fa fa-minus"></i>{{ __('common.subtract') }} {{ __('common.balance') }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <label class="primary_input_label" for="">
                                <p>@php echo $supplier->description; @endphp <br></p>
                            </label>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>

    </div>

</section>


@endsection
