@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/edit.css'))}}" />
  
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100">
                        <h3 class="mb-0 mr-30">{{ __('common.product') }} {{ __('common.update') }}</h3>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{route('seller.product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for=""> {{__("product.i_want_to_manage_stock_for_this_product")}}</label>
                            <label class="switch_toggle" for="checkbox1">
                                <input type="checkbox" id="checkbox1" @if ($product->stock_manage == 1) checked @endif value="{{ $product->id }}">
                                <div class="slider round"></div>
                            </label>
                        </div>
                    </div>
                </div>
                @if($product->product->product_type ==1)
                <div class="row">
                    @if ($product->stock_manage == 1)
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="product_stock">{{__('product.product_stock')}} <span class="text-danger">*</span></label>
                                    <input class="primary_input_field" name="product_stock" id="product_stock" placeholder="{{__("product.product_stock")}}" type="number" min="0" step="0" value="{{$product->skus->first()->product_stock??0}}" required>
                                   @error('product_stock')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                        </div>

                    </div>
                    @endif
                    <input type="hidden" id="stock_manage" name="stock_manage" value="{{ $product->stock_manage }}">

                    <div class="col-lg-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for=""> {{__("product.selling_price")}} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" name="selling_price" id="selling_price" placeholder="{{__("product.selling_price")}}" type="number" min="0" step="{{step_decimal()}}" value="{{$product->skus->first()->selling_price?$product->skus->first()->selling_price:0}}" required>
                            <span class="text-danger">{{$errors->first('selling_price')}}</span>
                        </div>
                    </div>
                </div>
                @endif


                <div class="row">

                    <div class="col-lg-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for="">
                                {{__("product.display_name")}}</label>
                            <input class="primary_input_field" id="product_name" name="product_name"
                                placeholder="{{__("product.display_name")}}" type="text" value="{{old('product_name')?old('product_name'):$product->product_name}}">
                            <span class="text-danger">{{$errors->first('product_name')}}</span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xl-8 col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label"
                                        for="">{{ __('product.thumbnail_image') }} (165x165)PX</label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input" type="text"
                                            id="thumbnail_image_file_seller"
                                            placeholder="{{ __('product.thumbnail_image') }}"
                                            readonly="">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg"
                                                for="thumbnail_image_seller">{{ __('product.Browse') }}
                                            </label>
                                            <input type="file" class="d-none" name="thumbnail_image" accept="image/*"
                                                id="thumbnail_image_seller">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                <div class="thumb_img_div">
                                    <img id="sellerThumbnailImg" src="{{asset(asset_path($product->thum_img != null?$product->thum_img:'backend/img/default.png'))}}"
                                    alt="">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for=""> {{__("product.tax")}}</label>
                            <input class="primary_input_field" id="tax" name="tax" placeholder="{{__("product.tax")}}" type="number" min="0" step="{{step_decimal()}}" value="{{$product->tax?$product->tax:0}}">
                            <span class="text-danger">{{$errors->first('tax')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('product.tax_type') }}</label>
                            <select class="primary_select mb-25" name="tax_type" id="tax_type">
                                <option {{$product->tax_type == 1?'selected':''}} value="1">{{ __('product.amount') }}</option>
                                <option {{$product->tax_type == 0?'selected':''}} value="0">{{ __('product.percentage') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for=""> {{__("product.discount")}}</label>
                            <input class="primary_input_field" name="discount" id="discount" placeholder="{{__("product.discount")}}" type="number" min="0" step="{{step_decimal()}}" value="{{$product->discount?$product->discount:0}}">
                            <span class="text-danger">{{$errors->first('discount')}}</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('product.discount_type') }}</label>
                            <select class="primary_select mb-25" name="discount_type" id="discount_type">
                                <option {{$product->discount_type == 1?'selected':''}} value="1">{{ __('product.amount') }}</option>
                                <option {{$product->discount_type == 0?'selected':''}} value="0">{{ __('product.percentage') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for="startDate">{{__('product.discount_start_date')}}</label>
                            <div class="primary_datepicker_input">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="">
                                            <input placeholder="{{ __('common.date') }}"  class="primary_input_field primary-input date form-control" id="startDate" type="text" name="discount_start_date" value="{{$product->discount_start_date??''}}" autocomplete="off">
                                        </div>
                                    </div>
                                    <button class="" type="button">
                                        <i class="ti-calendar" id="start-date-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="primary_input mb-15">
                            <label class="primary_input_label" for="endDate">{{__('product.discount_end_date')}}</label>
                            <div class="primary_datepicker_input">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="">
                                            <input placeholder="{{ __('common.date') }}" class="primary_input_field primary-input date form-control" id="endDate" type="text" name="discount_end_date" value="{{$product->discount_end_date??''}}" autocomplete="off">
                                        </div>
                                    </div>
                                    <button class="" type="button">
                                        <i class="ti-calendar" id="end-date-icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($product->product->product_type ==2)

                <div class="row">
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="product_sku">{{ __('common.select') }} {{ __('common.new') }}</label>
                            <select class="primary_select mb-25" name="product_sku" id="product_sku" >
                                <option value="" disabled selected>{{__('seller.select_from_list')}}</option>
                                @foreach($skus as $sku)
                                <option value="{{$sku->id}}">{{$sku->sku}}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                    <input type="hidden" id="stock_manage" name="stock_manage" value="{{ $product->stock_manage }}">
                    <div class="col-lg-6">
                        <ul class="mt-25" id="sku_list_div">
                            @foreach($product->skus as $sku)
                            <li class="badge_1 mb-10" id="badge_id_{{$sku->id}}">{{$sku->sku->sku}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row mt-20">
                    <div id="variant_table_div" class="col-xl-12 overflow-auto">
                        <table class="table table-bordered sku_table">
                            <thead>
                                <tr>
                                    <th class="text-center text-nowrap">{{ __('product.variant') }}</th>

                                    <th class="text-center">{{ __('product.selling_price') }}</th>
                                    @if ($product->stock_manage == 1)
                                        <th class="text-center">{{ __('product.product_stock') }}</th>
                                    @endif
                                    <th class="text-center">{{ __('common.status') }}</th>
                                    <th class="text-center">{{ __('common.delete') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sku_tbody">
                                @foreach($product->skus as $key => $item)
                                <tr>
                                    <input type="hidden" name="product_skus[]" value="{{$item->sku->id}}">
                                    <td class="text-center product_sku_name">{{$item->sku->sku}}</td>

                                    <td class="text-center sku_price_td"><input  class="primary_input_field" type="number" name="selling_price_sku[]" value="{{$item->selling_price}}" min="0" step="{{step_decimal()}}" class="form-control" required></td>
                                    @if ($product->stock_manage == 1)
                                        <td class="text-center sku_price_td"><input  class="primary_input_field" type="number" name="stock[]" value="{{$item->product_stock}}" min="0" step="0" class="form-control" required></td>
                                    @endif
                                    <td class="text-center product_sku_name">
                                        <label class="switch_toggle" for="checkbox_{{$item->id}}">
                                            <input type="checkbox" name="status_{{$item->sku->id}}" id="checkbox_{{$item->id}}"  {{$item->status?'checked':''}}  value="{{$item->id}}">
                                            <div class="slider round"></div>
                                        </label>
                                    </td>
                                    <td class="text-center sku_delete_td" data-id="{{$item->id}}" data-unique_id="#badge_id_{{$item->id}}"><p><i class="fa fa-trash"></i></p></td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-lg-12 text-center mt-20">
                        <div class="d-flex justify-content-center">
                            <button class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent"
                                type="submit"><i class="ti-check"></i>{{__('common.update')}}</button>
                        </div>
                    </div>
                </div>
            </form>

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

            $(document).on('change','#product_sku', function(){
                let a_id = $(this).val();
                var stock_manage = $('#stock_manage').val();
                let sku = $('#product_sku option:selected').html();
                console.log(sku)
                $('#sku_list_div').append(`<li class="badge_1 mb-10" id="badge_id_${a_id}">${sku}</li>`)
                $.post('{{ route('seller.product.variant-edit') }}', {_token:'{{ csrf_token() }}', id:a_id, stock_manage:stock_manage}, function(data){

                    $('#sku_tbody').append(data.variants)

                });

            });

            $(document).on('change', '#thumbnail_image_seller', function(event){
                getFileName($(this).val(),'#thumbnail_image_file_seller');
                imageChangeWithFile($(this)[0],'#sellerThumbnailImg');
            });

            $(document).on('change', '#checkbox1', function(event){
                update_stock_manage_status($(this)[0]);
            });

            $(document).on('click', '.sku_delete_td', function(event){
                let id = $(this).data('id');
                let unique_id = $(this).data('unique_id');

                deleteRow($(this)[0], id, unique_id);
            });

            $(document).on('click', '.sku_delete_new', function(event){
                let unique_id = $(this).data('unique_id');

                deleteRowNew($(this)[0], unique_id);
            });


            function deleteRow(btn,rowId,id) {

                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', rowId);

                $.ajax({
                    url: "{{ route('seller.product.variant.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                        },
                        error: function(response) {
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        }
                    });
                var row = btn.parentNode;
                row.parentNode.removeChild(row);

                $(id).css('display','none');
            }

            function deleteRowNew(btn, id){
                var row = btn.parentNode;
                row.parentNode.removeChild(row);
                $(id).css('display','none');

            }

            function update_stock_manage_status(el){
                if(el.checked){
                    var status = 1;
                }
                else{
                    var status = 0;
                }
                $.post('{{ route('seller.product.update_stock_manage_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                    if(data == 1){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        location.reload();
                    }
                    else{
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }
                });
            }

        });
    })(jQuery);



</script>
@endpush
