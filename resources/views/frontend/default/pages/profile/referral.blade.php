@extends('frontend.default.layouts.app')

@section('breadcrumb')

{{ __('common.referral') }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/referral.css'))}}" />
 
@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
               <div class="referral_item">
                   <div class="single_coupons_item cart_part">
                       @if(isset($myCode))
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="my-link">
                                    <h5>{{__('defaultTheme.my_referral_code')}}</h5>
                                    <div class="codeDiv">
                                        <div class="input-group">
                                            <input type="text" name="code" class="form-control" value="{{$myCode->referral_code}}" id="code" placeholder="{{__('common.code')}}" readonly/>
                                            <div class="input-group-append">
                                              <button id="copyBtn" class="input-group-text">{{__('defaultTheme.copy_code')}}</button>
                                            </div>
                                          </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12 user_list_div">
                                <h5>{{__('defaultTheme.user_list')}}</h5>
                                <div class="user-list">
                                    <div class="table-responsive">
                                        <table class="table table-hover red-header">
                                            <thead>
                                                <tr>
                                                    <th>{{__('common.sl')}}</th>
                                                    <th>{{__('common.user')}}</th>
                                                    <th>{{__('common.date')}}</th>
                                                    <th>{{__('common.status')}}</th>
                                                    <th>{{__('defaultTheme.discount_amount')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="cart_table_body">
                                                @foreach($referList as $key => $referral)
                                                <tr>
                                                    <td>{{$key +1}}</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-2">
                                                                <img class="user-img" src="{{@$referral->user->avatar?$referral->user->avatar:'/frontend/default/img/avatar.jpg'}}" alt="">
                                                            </div>
                                                            <div class="col-lg-10">
                                                                <strong>{{@$referral->user->first_name. @$referral->user->last_name}}</strong>
                                                                <p>{{@$referral->user->email?@$referral->user->email:@$referral->user->username}}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{date('d-m-Y',strtotime($referral->created_at))}}</td>
                                                    <td>{{$referral->is_use == 1?__('defaultTheme.already_use'):__('defaultTheme.not_used')}}</td>
                                                    <td>{{single_price($referral->discount_amount)}}</td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        @php
                                            $total_number_of_item_get_for_this_page = ($referList->count() > 0) ? $referList->count() : 0;
                                            if ($total_number_of_item_get_for_this_page != 0) {
                                                $total_number_of_items = ($referList->total() > 0) ? $referList->total() : 1;
                                                $half_of_total_items = intval($total_number_of_items/2);
                                                $reminder = $total_number_of_items % 2;
                                                if ($reminder > 0) {
                                                    $half_of_total_items += 1;
                                                }
                                                if ($total_number_of_item_get_for_this_page >= $half_of_total_items) {
                                                    $total_number_of_pages = intval($total_number_of_items / $total_number_of_item_get_for_this_page);
                                                    $reminder = $total_number_of_items % $total_number_of_item_get_for_this_page;
                                                }else {
                                                    $total_number_of_pages = intval($total_number_of_items / $half_of_total_items);
                                                    $reminder = $total_number_of_items % $half_of_total_items;
                                                }
                                                if ($reminder > 0) {
                                                    $total_number_of_pages += 1;
                                                }
                                            }else {
                                                $total_number_of_pages = 1;
                                            }
                                        @endphp
                                        @if (count($referList) > 0)
                                        <div class="pagination_part">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">
                                                    <li class="page-item"><a class="page-link" href="{{ $referList->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
                                                    @for ($i=1; $i <= $total_number_of_pages; $i++)
                                                        @if (($referList->currentPage() + 2) == $i)
                                                            <li class="page-item"><a class="page-link" href="{{ $referList->url($i) }}">{{ $i }}</a></li>
                                                        @endif
                                                        @if (($referList->currentPage() + 1) == $i)
                                                            <li class="page-item"><a class="page-link" href="{{ $referList->url($i) }}">{{ $i }}</a></li>
                                                        @endif
                                                        @if ($referList->currentPage() == $i)
                                                            <li class="page-item @if (request()->toRecievedList == $i || request()->toRecievedList == null) active @endif"><a class="page-link" href="{{ $referList->url($i) }}">{{ $i }}</a></li>
                                                        @endif
                                                        @if (($referList->currentPage() - 1) == $i)
                                                            <li class="page-item"><a class="page-link" href="{{ $referList->url($i) }}">{{ $i }}</a></li>
                                                        @endif
                                                        @if (($referList->currentPage() - 2) == $i)
                                                            <li class="page-item"><a class="page-link" href="{{ $referList->url($i) }}">{{ $i }}</a></li>
                                                        @endif
                                                    @endfor
                                                    <li class="page-item"><a class="page-link" href="{{ $referList->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                        @else
                                            <div class="row mt-20">
                                              <div class="col-lg-12 text-center">
                                                <p class="mt-200">{{__('common.nothing_found')}}</p>
                                              </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-center mt_60">{{__('defaultTheme.you_will_get_referral_after')}}</h5>
                            </div>
                        </div>
                        @endif
                   </div>
               </div>
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts')
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){
                document.getElementById("copyBtn").onclick = function() {
                    let copyTextarea = document.createElement("textarea");
                    copyTextarea.style.position = "fixed";
                    copyTextarea.style.opacity = "0";
                    copyTextarea.textContent = document.getElementById("code").value;

                    document.body.appendChild(copyTextarea);
                    copyTextarea.select();
                    document.execCommand("copy");
                    document.body.removeChild(copyTextarea);
                    toastr.success("{{__('defaultTheme.code_copied_successfully')}}", "{{__('common.success')}}");
                }
            });

        })(jQuery);
    </script>

@endpush
