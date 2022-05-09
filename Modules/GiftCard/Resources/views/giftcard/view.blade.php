@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/giftcard/css/style.css'))}}" />

@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.name') }}: {{$card->name}}</h3>
                        @if (permissionCheck('order_manage.print_order_details'))
                            <ul class="d-flex float-right">
                                <li><a href="{{ route('order_manage.print_order_details', $card->id) }}" target="_blank"
                                   class="primary-btn fix-gr-bg radius_30px mr-10">{{__('order.print')}}</a>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-8 student-details">
                <div class="white_box_50px box_shadow_white" id="printableArea">
                    <div class="row pb-30 border-bottom">
                        <div class="col-md-6 col-lg-6">
                            <div class="logo_div">
                                <img src="{{showImage(app('general_setting')->logo)}}" width="100px" alt="">
                            </div>
                        </div>
                        <div class="-md-6 col-lg-6 text-right">
                            <h4>  {{ __('product.card_number') }} : {{$card->card_number}}</h4>


                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-md-6 col-lg-6">
                            <table class="table-borderless clone_line_table">
                                <tr>
                                    <td><strong>{{__('')}}</strong></td>
                                </tr>
                                <tr>
                                    <td>{{__('common.name')}}</td>
                                    <td>: {{$card->name}}</td>
                                </tr>

                                <tr>
                                    <td>{{__('product.card_number')}}</td>
                                    <td>: {{$card->card_number}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.start_date')}}</td>
                                    <td>: {{date(app('general_setting')->dateFormat->format,strtotime($card->start_date))}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.end_date')}}</td>
                                    <td>: {{date(app('general_setting')->dateFormat->format,strtotime($card->end_date))}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.status')}}</td>
                                    <td>: <span class="{{$card->status == 1?'badge_1':'badge_2'}}">{{$card->status==1?'Active':'Inactive'}}</span></td>
                                </tr>
                                <tr>
                                    <td>{{__('common.number_of_use')}}</td>
                                    <td>: {{count(@$card->uses)}}</td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>


    </script>
@endpush
