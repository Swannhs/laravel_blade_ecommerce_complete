@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/marketing/css/flash_deal_edit.css'))}}" />

@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <form action="{{route('marketing.flash-deals.update',encrypt($flash_deal->id))}}" enctype="multipart/form-data" method="POST">
        <div class="row">

                @csrf
                @method('POST')
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                {{__('marketing.update_flash_deal')}} </h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="formHtml" class="col-lg-12">
                        <div class="white-box">

                                <div class="add-visitor">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                        for="title">{{__('common.title')}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field" type="text" id="title" name="title" autocomplete="off"
                                                    value="{{$flash_deal->title?$flash_deal->title:old('title')}}" placeholder="{{__('common.title')}}">
                                                @error('title')
                                                    <span class="text-danger" id="error_title">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="background_color">{{__('marketing.background_color')}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field" type="text" id="background_color" class="form-control" name="background_color" autocomplete="off"
                                                    value="{{$flash_deal->background_color?$flash_deal->background_color:old('background_color')}}" placeholder="{{__('#000000')}}">
                                                @error('background_color')
                                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                        for="text_color">{{__('marketing.text_color')}} <span class="text-danger">*</span></label>
                                                <input class="primary_input_field" type="text" id="text_color" name="text_color" autocomplete="off"
                                                    value="{{$flash_deal->text_color?$flash_deal->text_color:old('text_color')}}" placeholder="{{__('#000000')}}">
                                                @error('text_color')
                                                    <span class="text-danger" id="error_text_color">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.banner') }} {{__('common.image')}} (1920 x 500) <span class="text-danger">*</span></label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary-input" type="text" id="banner_image_file"
                                                        placeholder="{{__('common.browse')}} {{__('common.image')}}" readonly="">
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="banner_image">{{ __('common.browse') }} </label>
                                                        <input type="file" class="d-none" name="banner_image" id="banner_image">
                                                    </button>
                                                </div>
                                            @error('banner_image')
                                                <span class="text-danger" id="error_banner_image">{{$message}}</span>
                                            @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="banner_img_div">
                                                <img id="MetaImgDiv"
                                                src="{{ showImage($flash_deal->banner_image?$flash_deal->banner_image:'backend/img/default.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('common.date')}}</label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="{{__('common.date')}}" class="primary_input_field primary-input form-control" id="date" type="text" value="{{date('d-m-Y',strtotime($flash_deal->start_date)).' to '.date('d-m-Y',strtotime($flash_deal->end_date))}}" name="date" autocomplete="off" readonly required>
                                                            </div>
                                                            <input type="hidden" name="start_date" id="start_date" value="{{$flash_deal->start_date}}">
                                                            <input type="hidden" name="end_date" id="end_date" value="{{$flash_deal->end_date}}">
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('date')
                                                    <span class="text-danger" id="error_date">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-lg-12">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{ __('common.products') }}</label>
                                                <select id="products" class="primary_select mb-15">
                                                    <option disabled selected value="">{{ __('marketing.select_products') }}</option>

                                                    @php
                                                        $user = auth()->user();
                                                    @endphp
                                                    @if($user->role->type == 'admin' || $user->role->type == 'superadmin' || $user->role->type == 'staff')
                                                        @foreach($sellerProducts as $key => $product)
                                                            <option value="{{$product->id}}">{{@$product->product->product_name}} @if(isModuleActive('MultiVendor')) [@if($product->seller->role->type == 'seller') {{$product->seller->first_name}} @else Inhouse @endif] @endif</option>
                                                        @endforeach
                                                    @elseif($user->role->type == 'seller')
                                                        @foreach($sellerProducts as $key => $product)
                                                            <option value="{{$product->id}}">{{@$product->product_name}}</option>
                                                        @endforeach
                                                    @else

                                                    @endif

                                                </select>
                                                @error('products')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>


                                    </div>
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                        <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg" data-toggle="tooltip" title=""
                                                data-original-title="">
                                                <span class="ti-check"></span>
                                                {{__('common.update')}} </button>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">

                <div class="row ">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-30">{{__('marketing.selected_product_list')}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="white-box overflow-auto">
                            <div id="item_table">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="35%" class="text-center">{{__('common.product')}}</th>
                                            <th width="15%" class="text-center">{{__('common.price')}}</th>
                                            <th width="15%" class="text-center">{{__('common.discount')}}</th>
                                            <th width="25%" class="text-center">{{__('common.discount_type')}}</th>
                                            <th width="10%" class="text-center">{{__('common.delete')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sku_tbody">
                                        @foreach(@$flash_deal->products as $key => $product)
                                        <tr>
                                            <td>
                                                <div class="product_info">
                                                    <div class="product_img_div">
                                                        <img class="productImg" src="{{ showImage(@$product->product->product->thumbnail_image_source) }}" alt="">
                                                    </div>
                                                    <div class="product_name_div">
                                                        <p class="text-nowrap">{{substr(@$product->product->product->product_name, 0, 40)}}</p>
                                                        <input type="hidden" name="products[]" value="{{$product->product->id}}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="mt-25 ml-5 mr-5 text-nowrap">
                                                    @if (@$product->product->product->product_type == 1)
                                                    {{single_price(@$product->product->skus->max('selling_price'))}}
                                                    @else
                                                    {{single_price(@$product->product->skus->min('selling_price'))}} - {{single_price(@$product->product->skus->max('selling_price'))}}
                                                    @endif
                                                </p>
                                                <input type="hidden" name="price[]" value="{{single_price(@$product->product->skus->max('selling_price'))}}">
                                            </td>
                                            <td class="text-center pl-5 pr-5"><input class="primary_input_field mt-14" name="discount[]" id="discount" placeholder="" type="number" min="0" step="{{step_decimal()}}" value="{{@$product->discount}}" required></td>
                                            <td class="pl-5 pr-5">
                                                <div class="primary_input mt-14">
                                                    <select class="primary_select mb-25 discount_type p_discount_type" name="discount_type[]">
                                                        <option {{@$product->discount_type ==1?'selected':''}}  value="1">{{ __('common.amount') }}</option>
                                                        <option {{@$product->discount_type ==0?'selected':''}}   value="0">{{ __('common.percentage') }}</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="text-center pt-25">
                                                <a class="product_delete_btn" href=""><i class="ti-close"></i></a>
                                                <input type="hidden" id="product_{{$product->product->id}}">
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
    </form>
    </div>
</section>
@endsection
@push('scripts')
    <script>
        (function($){
            "use strict";

            $(document).ready(function(){
                $("#background_color").spectrum();
                $("#text_color").spectrum();

                $(document).on('change','#products', function(event){
                    $('#submit_btn').prop('disabled',true);
                    $('.p_discount_type').removeClass('discount_type');
                    get_flash_deal();
                });

                function get_flash_deal(){
                    let product_id = $('#products').val();
                    $('#pre-loader').removeClass('d-none');
                    if(product_id != null){
                        $.post('{{ route('marketing.flash-deals.product-list-edit') }}', {_token:'{{ csrf_token() }}', product_id:product_id,flash_deal_id:'{{$flash_deal->id}}'}, function(data){
                            let exsists = $('#product_'+product_id).length;
                            if(exsists < 1){
                                $('#sku_tbody').append(data);
                                $('#submit_btn').prop('disabled',false);
                                $('.discount_type').niceSelect();
                                $('#products').val('');
                                $('#products').niceSelect('update');
                                $('#pre-loader').addClass('d-none');
                            }else{
                                $('#pre-loader').addClass('d-none');
                                toastr.error("{{__('marketing.this_item_already_added_to_list')}}");
                                $('#submit_btn').prop('disabled',false);
                            }

                        });
                    }
                    else{
                        $('#submit_btn').prop('disabled',false);
                        $('#pre-loader').addClass('d-none');
                    }
                }

                $('#date').daterangepicker({
                    "timePicker": false,
                    "linkedCalendars": false,
                    "autoUpdateInput": false,
                    "showCustomRangeLabel": false,
                    "startDate": "{{date('mm/dd/Y',strtotime($flash_deal->start_date))}}",
                    "endDate": "{{date('mm/dd/Y',strtotime($flash_deal->end_date))}}",
                    "buttonClasses": "primary-btn fix-gr-bg",
                    "applyButtonClasses": "primary-btn fix-gr-bg",
                    "cancelClass": "primary-btn fix-gr-bg",
                }, function(start, end, label) {
                    $('#date').val(start.format('DD-MM-YYYY')+' to ' + end.format('DD-MM-YYYY'));
                    $('#start_date').val(start.format('DD-MM-YYYY'));
                    $('#end_date').val(end.format('DD-MM-YYYY'));
                });

                $(document).on('change', '#banner_image', function(event){
                    getFileName($(this).val(),'#banner_image_file');
                    imageChangeWithFile($(this)[0],'#MetaImgDiv');
                });

                $(document).on('click', '.product_delete_btn', function(event){
                    event.preventDefault();
                    let this_data = $(this)[0];
                    delete_product_row(this_data);
                });

                function delete_product_row(this_data){
                    let row = this_data.parentNode.parentNode;
                    row.parentNode.removeChild(row);
                }

            });
        })(jQuery);

    </script>
@endpush
