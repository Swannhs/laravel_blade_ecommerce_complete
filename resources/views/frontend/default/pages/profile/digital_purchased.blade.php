@extends('frontend.default.layouts.app')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/digital_purchased_product.css'))}}" />
   
@endsection
@section('breadcrumb')
{{ __('customer_panel.purchased_digital_products') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
               <div class="coupons_item">
                   <div class="single_coupons_item cart_part">
                       <div class="table-responsive">
                        <table class="table table-hover red-header">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.name') }}</th>
                                        <th width="10%">{{ __('common.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="cart_table_body">
                                    @foreach ($digital_products as $key => $digital_product)
                                        <tr>
                                            <td>{{ $digital_product->seller_product_sku->product->product_name }}</td>
                                            <td>
                                                <a class="btn_1 gift_card_redeem" href="{{ route('digital_file_download', encrypt($digital_product->id)) }}">Download</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                   </div>
                   @php
                       $total_number_of_item_per_page = $digital_products->perPage();
                       $total_number_of_items = ($digital_products->total() > 0) ? $digital_products->total() : 0;
                       $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
                       $reminder = $total_number_of_items % $total_number_of_item_per_page;
                       if ($reminder > 0) {
                           $total_number_of_pages += 1;
                       }

                       $current_page = $digital_products->currentPage();
                       $previous_page = $digital_products->currentPage() - 1;
                       if($current_page == $digital_products->lastPage()){
                       $show_end = $total_number_of_items;
                       }else{
                       $show_end = $total_number_of_item_per_page * $current_page;
                       }


                       $show_start = 0;
                       if($total_number_of_items > 0){
                         $show_start = ($total_number_of_item_per_page * $previous_page) + 1;
                       }
                   @endphp
                   @if (count($digital_products) > 0)
                       <div class="pagination_part">
                           <nav aria-label="Page navigation example">
                               <ul class="pagination">
                                   <li class="page-item"><a class="page-link" href="{{ $digital_products->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
                                   @for ($i=1; $i <= $total_number_of_pages; $i++)
                                       @if (($digital_products->currentPage() + 2) == $i)
                                           <li class="page-item"><a class="page-link" href="{{ $digital_products->url($i) }}">{{ $i }}</a></li>
                                       @endif
                                       @if (($digital_products->currentPage() + 1) == $i)
                                           <li class="page-item"><a class="page-link" href="{{ $digital_products->url($i) }}">{{ $i }}</a></li>
                                       @endif
                                       @if ($digital_products->currentPage() == $i)
                                           <li class="page-item @if (request()->toRecievedList == $i || request()->toRecievedList == null) active @endif"><a class="page-link" href="{{ $digital_products->url($i) }}">{{ $i }}</a></li>
                                       @endif
                                       @if (($digital_products->currentPage() - 1) == $i)
                                           <li class="page-item"><a class="page-link" href="{{ $digital_products->url($i) }}">{{ $i }}</a></li>
                                       @endif
                                       @if (($digital_products->currentPage() - 2) == $i)
                                           <li class="page-item"><a class="page-link" href="{{ $digital_products->url($i) }}">{{ $i }}</a></li>
                                       @endif
                                   @endfor
                                   <li class="page-item"><a class="page-link" href="{{ $digital_products->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
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
</section>

@endsection
