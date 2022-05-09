@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('modules/inhouseorder/css/create.css'))}}">
    <link rel="stylesheet" href="{{asset(asset_path('backend/css/cart_modal.css'))}}"/>
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="">
            <div class="col-lg-12">
                <div class="main-title">
                    <h3 class="mb-30">
                        {{__('order.create_new_order')}} </h3>
                </div>
            </div>
        </div>
        <div id="formHtml" class="col-lg-12">
            <div class="white-box">
                <form action="{{route('admin.inhouse-order.store')}}" id="add_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="add-visitor">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('product.product_list') }}
                                                <span class="text-danger">*</span></label>
                                            <select class="primary_select mb-25" name="product" id="product">
                                                <option value="" selected disabled>{{ __('common.select') }}{{ __('common.product') }}</option>
                                                @if(isModuleActive('MultiVendor'))
                                                    @foreach($products as $key => $product)
                                                        <option value="{{$product->id}}">{{ substr($product->product_name,0,35) }} @if(strlen($product->product_name) > 35)... @endif [@if($product->seller->role->type == 'seller'){{$product->seller->first_name}} @else Inhouse @endif]</option>
                                                    @endforeach
                                                @else
                                                    @foreach($products->where('user_id', 1) as $key => $product)
                                                        <option value="{{$product->id}}">{{ substr($product->product_name,0,35) }} @if(strlen($product->product_name) > 35)... @endif</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.payment_method') }}
                                                <span class="text-danger">*</span></label>
                                            <select class="primary_select mb-25" name="payment_method" id="payment_method">

                                                <option value="{{$paymentMethod->id}}">{{ $paymentMethod->method }}</option>

                                            </select>

                                        </div>

                                    </div>

                                    @if(\Session::has('inhouse_order_shipping_address'))
                                    @else
                                    <div class="col-lg-12" id="alert_div">
                                        <div class="alert alert-warning mt-30 text-center">
                                            {{ __('shipping.please_save_customer_address_before_add_product') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                        </div>
                                    </div>
                                    @endif



                                </div>
                            </div>

                            <div class="col-lg-6" id="addressDiv">
                                @include('inhouseorder::inhouse_order.components._address')
                            </div>


                        </div>

                        <div class="row mt-50" id="PackageDiv">
                            @include('inhouseorder::inhouse_order.components._product_by_package')

                        </div>


                    </div>
                </form>

            </div>
        </div>
    </div>


    <div id="productVariantDiv">

    </div>

    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('product.product'),'modal_id' => 'deleteProductModal',
    'form_id' => 'product_delete_form','delete_item_id' => 'delete_product_id','dataDeleteBtn' =>'productDeleteBtn'])

</section>
@endsection

@push('scripts')
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){
                let base_url = $('#url').val();

                $(document).on('change', '#product', function(event){
                    let product_id = $('#product').val();

                    $('#pre-loader').removeClass('d-none');
                    if(product_id){

                        let url = base_url + '/admin/in-house-order/get-product-variant?product_id=' + product_id;
                        $.get(url, function(data){
                            if(data.productType == 'variant_product'){
                                $('#productVariantDiv').html(data.modalData);

                                $('#theme_modal').modal('show');
                                $('#shipping_type').niceSelect();
                            }else{
                                if(data == 'out_of_stock'){
                                  toastr.error('out of stock.')
                                }else{
                                  $('#PackageDiv').html(data.PackageData);
                                  $('.shipping_method').niceSelect();
                                  $('#product').val('');
                                  $('#product').niceSelect('update');
                                }
                            }
                            $('#pre-loader').addClass('d-none');

                        });
                    }else{
                        $('#pre-loader').addClass('d-none');
                    }

                });


                $(document).on('click', '#save_address_btn', function(event){

                    $('#pre-loader').removeClass('d-none');

                    let shipping_name = $('#shipping_name').val();
                    let shipping_email = $('#shipping_email').val();
                    let shipping_phone = $('#shipping_phone').val();
                    let shipping_address = $('#shipping_address').val();
                    let shipping_country = $('#shipping_country').val();
                    let shipping_state = $('#shipping_state').val();
                    let shipping_city = $('#shipping_city').val();
                    let shipping_postcode = $('#shipping_postcode').val();

                    let billing_name = $('#billing_name').val();
                    let billing_email = $('#billing_email').val();
                    let billing_phone = $('#billing_phone').val();
                    let billing_address = $('#billing_address').val();
                    let billing_country = $('#billing_country').val();
                    let billing_state = $('#billing_state').val();
                    let billing_city = $('#billing_city').val();
                    let billing_postcode = $('#billing_postcode').val();

                    let same_address = 0;

                    if($('#is_billing_address').prop('checked')){
                        same_address = 1;
                    }

                    let data = {
                        'shipping_name' : shipping_name,
                        'shipping_email' : shipping_email,
                        'shipping_phone' : shipping_phone,
                        'shipping_address' : shipping_address,
                        'shipping_country' : shipping_country,
                        'shipping_state' : shipping_state,
                        'shipping_city' : shipping_city,
                        'shipping_postcode' : shipping_postcode,
                        'billing_name' : billing_name,
                        'billing_email' : billing_email,
                        'billing_phone' : billing_phone,
                        'billing_address' : billing_address,
                        'billing_country' : billing_country,
                        'billing_state' : billing_state,
                        'billing_city' : billing_city,
                        'billing_postcode' : billing_postcode,
                        'is_bill_address' : same_address,
                        '_token' : "{{ csrf_token() }}"
                    }


                    $.each(data, function(index, stateObj) {
                        $('#error_'+index).text('');
                    });



                    let error_show = 0;

                    if(shipping_name == ''){
                        $('#error_shipping_name').text('The name required.');
                        error_show = 1;
                    }
                    if(shipping_email == ''){
                        $('#error_shipping_email').text('The email required.');
                        error_show = 1;
                    }
                    if(shipping_phone == ''){
                        $('#error_shipping_phone').text('The phone required.');
                        error_show = 1;
                    }
                    if(shipping_address == ''){
                        $('#error_shipping_address').text('The address required.');
                        error_show = 1;
                    }
                    if(shipping_country == null){
                        $('#error_shipping_country').text('The country required.');
                        error_show = 1;
                    }
                    if(shipping_state == null){
                        $('#error_shipping_state').text('The state required.');
                        error_show = 1;
                    }
                    if(shipping_city == null){
                        $('#error_shipping_city').text('The city required.');
                        error_show = 1;
                    }
                    if(shipping_postcode == ''){
                        $('#error_shipping_postcode').text('The postcode required.');
                        error_show = 1;
                    }

                    if(same_address == 0){
                        if(error_show == 1){
                        $('#pre-loader').addClass('d-none');
                        error_show = 0;
                        return false;
                    }

                    }

                    if(same_address == 1){
                        if(billing_name == ''){
                            $('#error_billing_name').text('The name required.');
                            error_show = 1;
                        }
                        if(billing_email == ''){
                            $('#error_billing_email').text('The email required.');
                            error_show = 1;
                        }
                        if(billing_phone == ''){
                            $('#error_billing_phone').text('The phone required.');
                            error_show = 1;
                        }
                        if(billing_address == ''){
                            $('#error_billing_address').text('The address required.');
                            error_show = 1;
                        }
                        if(billing_country == null){
                            $('#error_billing_country').text('The country required.');
                            error_show = 1;
                        }
                        if(billing_state == null){
                            $('#error_billing_state').text('The state required.');
                            error_show = 1;
                        }
                        if(billing_city == null){
                            $('#error_billing_city').text('The city required.');
                            error_show = 1;
                        }
                        if(billing_postcode == ''){
                            $('#error_billing_postcode').text('The postcode required.');
                            error_show = 1;
                        }
                        if(error_show == 1){
                            $('#pre-loader').addClass('d-none');
                            error_show = 0;
                            return false;
                        }
                    }

                    $.post("{{route('admin.inhouse-order.save_address')}}", data, function(response){
                        $('#pre-loader').addClass('d-none');
                        if(response.PackageData){
                            $('#PackageDiv').html(response.PackageData);
                            $('.shipping_method').niceSelect();
                            $('#addressDiv').html(response.address);
                            $('.address_dropdown').niceSelect();
                        }
                    });


                });

                $(document).on('click', '#resetAddress', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let url = base_url + '/admin/in-house-order/reset-address';
                    $.get(url, function(response){
                        $('#pre-loader').addClass('d-none');
                        if(response.PackageData){
                            $('#PackageDiv').html(response.PackageData);
                            $('.shipping_method').niceSelect();
                            $('#addressDiv').html(response.address);
                            $('.address_dropdown').niceSelect();
                            $('#alert_div').html(`
                                <div class="alert alert-warning mt-30 text-center">
                                    Please Save Customer Address Before Add Product
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </div>
                            `);
                        }
                    });
                });


                $(document).on('click','#add_to_cart_btn', function(event){
                    event.preventDefault();

                    let seller_id = $('#seller_id').val();
                    let price = $('#base_sku_price').val();
                    let qty = $('#qty').val();
                    let shipping_type = $('#shipping_type').val();
                    let product_sku_id = $('#product_sku_id').val();
                    let type = 'product';

                    $('#add_to_cart_btn').prop('disabled',true);
                    $('#add_to_cart_btn').html("{{__('defaultTheme.adding')}}");

                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('price', price);
                    formData.append('qty', qty);
                    formData.append('product_id', product_sku_id);
                    formData.append('seller_id', seller_id);
                    formData.append('shipping_method_id', shipping_type);
                    formData.append('type', type);
                    $('#pre-loader').removeClass('d-none');

                    $.ajax({
                        url: "{{route('admin.inhouse-order.add-to-cart')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            if(response == 'out_of_stock'){
                                toastr.error('No more product to buy.');
                                $('#pre-loader').addClass('d-none');
                                $('#add_to_cart_btn').prop('disabled',false);
                                $('#add_to_cart_btn').html("{{__('defaultTheme.add_to_cart')}}");
                            }else{
                                toastr.success("{{__('defaultTheme.product_successfully_added_to_cart')}}", "{{__('common.success')}}");
                                $('#add_to_cart_btn').prop('disabled',false);
                                $('#add_to_cart_btn').html("{{__('defaultTheme.add_to_cart')}}");
                                $('#PackageDiv').html(response.PackageData);
                                $('.shipping_method').niceSelect();
                                $('#theme_modal').modal('hide');
                                $('#pre-loader').addClass('d-none');
                            }
                        },
                        error: function (response) {
                            toastr.error("{{__('defaultTheme.product_not_added')}}","{{__('common.error')}}");
                            $('#add_to_cart_btn').prop('disabled',false);
                            $('#add_to_cart_btn').html("{{__('defaultTheme.add_to_cart')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });

                });

                $(document).on('change', '.shipping_method', function(event){
                    let method_id = $(this).val();
                    let product_id = $(this).data('id');
                    $('#pre-loader').removeClass('d-none');
                    let data = {
                        '_token' : "{{csrf_token()}}",
                        'product_id' : product_id,
                        'method_id' : method_id
                    }
                    $.post("{{route('admin.inhouse-order.change-shipping-method')}}", data, function(response){

                        if(response.PackageData){
                            $('#PackageDiv').html(response.PackageData);
                            $('.shipping_method').niceSelect();
                            $('#variant_modal').modal('hide');
                        }
                        $('#pre-loader').addClass('d-none');
                    });


                });
                $(document).on('keyup', '.product_qty', function(event){
                    let qty = 1;
                    if($(this).val() != ''){
                        qty = $(this).val();
                    }
                    let product_id = $(this).data('id');
                    $('#pre-loader').removeClass('d-none');
                    let data = {
                        '_token' : "{{csrf_token()}}",
                        'product_id' : product_id,
                        'qty' : qty
                    }
                    $.post("{{route('admin.inhouse-order.change-qty')}}", data, function(response){

                        if(response.PackageData){
                            $('#PackageDiv').html(response.PackageData);
                            $('.shipping_method').niceSelect();
                            $('#variant_modal').modal('hide');
                        }
                        $('#pre-loader').addClass('d-none');
                    });


                });


                $(document).on('click', '.deleteCartItem', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    if(id != null){
                        $('#delete_product_id').val(id);
                        $('#deleteProductModal').modal('show');

                    }else{
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }

                });

                $(document).on('click','#product_delete_form', function(event){
                    event.preventDefault();
                    let id = $('#delete_product_id').val();
                    if(id){

                        let data = {
                            'id' : id,
                            '_token' : '{{ csrf_token() }}'
                        }
                        $('#pre-loader').removeClass('d-none');
                        $('#deleteProductModal').modal('hide');
                        $.post("{{route('admin.inhouse-order.delete')}}",data, function(response){
                            if(response.PackageData){
                                $('#PackageDiv').html(response.PackageData);
                                $('.shipping_method').niceSelect();
                                $('#variant_modal').modal('hide');
                            }
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });



                $(document).on('click', '#is_billing_address', function(event){
                    $('.billing_address_field').toggleClass('d-none');
                });

                $(document).on('change', '#shipping_country', function(event){
                    let country = $('#shipping_country').val();

                    $('#pre-loader').removeClass('d-none');
                    if(country){

                        let url = base_url + '/seller/profile/get-state?country_id=' +country;

                        $('#shipping_state').empty();

                        $('#shipping_state').append(
                            `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                        );
                        $('#shipping_state').niceSelect('update');
                        $('#shipping_city').empty();
                        $('#shipping_city').append(
                            `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                        );
                        $('#shipping_city').niceSelect('update');
                        $.get(url, function(data){

                            $.each(data, function(index, stateObj) {
                                $('#shipping_state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                            });

                            $('#shipping_state').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });

                $(document).on('change', '#shipping_state', function(event){
                    let state = $('#shipping_state').val();

                    $('#pre-loader').removeClass('d-none');
                    if(state){

                        let url = base_url + '/seller/profile/get-city?state_id=' +state;

                        $('#shipping_city').empty();

                        $('#shipping_city').append(
                            `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                        );
                        $('#shipping_city').niceSelect('update');

                        $.get(url, function(data){

                            $.each(data, function(index, cityObj) {
                                $('#shipping_city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                            });

                            $('#shipping_city').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });

                $(document).on('change', '#billing_country', function(event){
                    let country = $('#billing_country').val();

                    $('#pre-loader').removeClass('d-none');
                    if(country){

                        let url = base_url + '/seller/profile/get-state?country_id=' +country;

                        $('#billing_state').empty();

                        $('#billing_state').append(
                            `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                        );
                        $('#billing_state').niceSelect('update');
                        $('#billing_city').empty();
                        $('#billing_city').append(
                            `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                        );
                        $('#billing_city').niceSelect('update');
                        $.get(url, function(data){

                            $.each(data, function(index, stateObj) {
                                $('#billing_state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                            });

                            $('#billing_state').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });

                $(document).on('change', '#billing_state', function(event){
                    let state = $('#billing_state').val();

                    $('#pre-loader').removeClass('d-none');
                    if(state){

                        let url = base_url + '/seller/profile/get-city?state_id=' +state;

                        $('#billing_city').empty();

                        $('#billing_city').append(
                            `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                        );
                        $('#billing_city').niceSelect('update');

                        $.get(url, function(data){

                            $.each(data, function(index, cityObj) {
                                $('#billing_city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                            });

                            $('#billing_city').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        });
                    }
                });




                $(document).on('click', '.qtyChangePlus', function(){
                    qtyChange(this.value);
                    $('.nc_select, .select_address, #product_short_list, #paginate_by').niceSelect('update');
                });

                $(document).on('click', '.qtyChangeMinus', function(){
                    qtyChange(this.value);
                    $('.nc_select, .select_address, #product_short_list, #paginate_by').niceSelect('update');
                });

                function qtyChange(val){
                    $('.cart-qty-minus').prop('disabled',false);
                    let available_stock = $('#availability').html();
                    let stock_manage_status = $('#stock_manage_status').val();
                    let maximum_order_qty = $('#maximum_order_qty').val();
                    let minimum_order_qty = $('#minimum_order_qty').val();
                    let qty = $('#qty').val();
                    if (stock_manage_status != 0) {
                        if (parseInt(qty) < parseInt(available_stock)) {
                            if(val == '+'){
                                if(maximum_order_qty != ''){
                                    if(parseInt(qty) < parseInt(maximum_order_qty)){
                                    let qty1 = parseInt(++qty);
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price');
                                    }else{
                                        toastr.warning('{{__("defaultTheme.maximum_quantity_limit_is")}}'+maximum_order_qty+'.', '{{__("common.warning")}}');
                                    }
                                }else{
                                    let qty1 = parseInt(++qty);
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price');
                                }


                            }
                            if(val == '-'){
                                if(minimum_order_qty != ''){
                                    if(parseInt(qty) > parseInt(minimum_order_qty)){
                                        if(qty>1){
                                            let qty1 = parseInt(--qty)
                                            $('#qty').val(qty1)
                                            totalValue(qty1, '#base_price','#total_price')
                                            $('.cart-qty-minus').prop('disabled',false);
                                        }else{
                                            $('.cart-qty-minus').prop('disabled',true);
                                        }
                                    }else{
                                        toastr.warning('{{__("defaultTheme.minimum_quantity_Limit_is")}}'+minimum_order_qty+'.', '{{__("common.warning")}}')
                                    }
                                }else{
                                    if(parseInt(qty)>1){
                                        let qty1 = parseInt(--qty)
                                        $('#qty').val(qty1)
                                        totalValue(qty1, '#base_price','#total_price')
                                        $('.cart-qty-minus').prop('disabled',false);
                                    }else{
                                        $('.cart-qty-minus').prop('disabled',true);
                                    }
                                }
                            }
                        }else {
                            toastr.error("{{__('defaultTheme.no_more_stock')}}", "{{__('common.error')}}");
                        }
                    }
                    else {
                        if(val == '+'){
                            if(maximum_order_qty != ''){
                                if(parseInt(qty) < parseInt(maximum_order_qty)){
                                    let qty1 = parseInt(++qty);
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price');
                                }else{
                                    toastr.warning('{{__("defaultTheme.maximum_quantity_limit_is")}}'+maximum_order_qty+'.', '{{__("common.warning")}}')
                                }
                            }else{
                                let qty1 = parseInt(++qty);
                                $('#qty').val(qty1)
                                totalValue(qty1, '#base_price','#total_price');
                            }


                        }
                        if(val == '-'){
                            if(minimum_order_qty != ''){
                                if(parseInt(qty) > parseInt(minimum_order_qty)){
                                    if(qty>1){
                                        let qty1 = parseInt(--qty)
                                        $('#qty').val(qty1)
                                        totalValue(qty1, '#base_price','#total_price')
                                        $('.cart-qty-minus').prop('disabled',false);
                                    }else{
                                        $('.cart-qty-minus').prop('disabled',true);
                                    }
                                }else{
                                    toastr.warning('{{__("defaultTheme.minimum_quantity_Limit_is")}}'+minimum_order_qty+'.', '{{__("common.warning")}}')
                                }
                            }else{
                                if(parseInt(qty)>1){
                                    let qty1 = parseInt(--qty)
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price')
                                    $('.cart-qty-minus').prop('disabled',false);
                                }else{
                                    $('.cart-qty-minus').prop('disabled',true);
                                }
                            }
                        }
                    }
                }

                function totalValue(qty, main_price, total_price){
                    let base_sku_price = $('#base_sku_price').val();
                    let value = parseInt(qty) * parseFloat(base_sku_price);
                    $(total_price).html('$ ' + formatMoney(value));
                    $('#final_price').val(value);
                }

                function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
                    try {
                        decimalCount = Math.abs(decimalCount);
                        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                        const negativeSign = amount < 0 ? "-" : "";

                        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                        let j = (i.length > 3) ? i.length % 3 : 0;

                        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
                    } catch (e) {
                        
                    }
                }

                $(document).on('click', '.attr_val_name', function(){

                    $(this).parent().parent().find('.attr_value_name').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));
                    $(this).parent().parent().find('.attr_value_id').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));

                    if ($(this).attr('color') == "color") {
                        $('.attr_clr').removeClass('selected_btn');
                    }
                    if ($(this).attr('color') == "not") {
                        $('.attr_val_name').removeClass('selected_btn');
                    }
                    $(this).addClass('selected_btn');
                    get_price_accordint_to_sku();

                });

                function get_price_accordint_to_sku(){
                    var value = $("input[name='attr_val_name[]']").map(function(){return $(this).val();}).get();
                    var id = $("input[name='attr_val_id[]']").map(function(){return $(this).val();}).get();
                    var product_id = $("#product_id").val();
                    var user_id = $('#seller_id').val();
                    $.post('{{ route('seller.get_seller_product_sku_wise_price') }}', {_token:'{{ csrf_token() }}', id:id, product_id:product_id, user_id:user_id}, function(data){
                        if (data != 0) {
                            let discount_type = $('#discount_type').val();
                            let discount = $('#discount').val();
                            let qty = $('.qty').val();
                            calculatePrice(data.data.selling_price, discount, discount_type, qty);
                            $('#sku_id_li').text(data.data.sku.sku);
                            $('#product_sku_id').val(data.data.id);
                            
                            $('#availability').html(data.data.product_stock);

                            if(parseInt(data.data.product_stock) >= parseInt(data.data.product.product.minimum_order_qty)){
                                $('#add_to_cart_div').html(`
                                    <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                                `);
                            }
                            else if(data.data.product.stock_manage == 0){
                                $('#add_to_cart_div').html(`
                                    <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                                `);
                            }
                            else{
                                $('#add_to_cart_div').html(`
                                    <p class="out_of_stock">{{__('defaultTheme.out_of_stock')}}</p>
                                `);
                                toastr.warning("{{__('defaultTheme.out_of_stock')}}");
                            }
                        }else {
                            toastr.error("{{__('defaultTheme.no_stock_found_for_this_seller')}}", "{{__('common.error')}}");
                        }
                    });
                }
                function calculatePrice(main_price, discount, discount_type, qty){
                    var main_price = main_price;
                    var discount = discount;
                    var discount_type = discount_type;
                    var total_price = 0;
                    if (discount_type == 0) {
                        discount = (main_price * discount) / 100;
                    }
                    total_price = (main_price - discount);
                    let currencySymbol = $('#currency_symbol').val();
                    let currency_rate = $('#currency_rate').val();
                    $('#total_price').html(currencySymbol + formatMoney((total_price * qty) * currency_rate));
                    $('#base_sku_price').val(total_price);
                    $('#final_price').val(total_price);
                }


            });
        })(jQuery);
    </script>
@endpush
