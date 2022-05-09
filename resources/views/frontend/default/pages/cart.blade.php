@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{ __('common.cart') }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/cart.css'))}}" />
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

    <section>
        <div id="cart_details_div">
            @include('frontend.default.partials._cart_details')
        </div>
    </section>
    
@endsection
@push('scripts')
    <script>

        (function($){

            "use strict";

            $(document).ready(function(){

                $(document).on('submit', '#cart_form', function(event){
                    event.preventDefault();
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    $('#pre-loader').show();
                    $.ajax({
                        url: "{{ route('frontend.cart.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('#pre-loader').hide();
                            $('#cart_details_div').html(response.MainCart);
                            $('#cart_inner').html(response.SubmenuCart);
                        },
                        error: function(response) {
                            $('#pre-loader').hide();
                        }
                    });
                });

                $(document).on('click', '.change_qty', function(event){
                    let type = $(this).val();
                    let cahnge_qty = 1;
                    let qty_id = $(this).data("qty_id");
                    let maximum_qty = $(this).data("maximum_qty");
                    let minimum_qty = $(this).data("minimum_qty");
                    var stock_manage = $(this).attr("data-stock_manage");
                    var product_stock = $(this).attr("data-product_stock");
                    var old_qty = $(qty_id).val();

                    let max_qty = $(maximum_qty).val();
                    let min_qty = $(minimum_qty).val();
                    if(stock_manage != '0'){
                        if(type === '+'){
                            var pre_qty = parseInt(cahnge_qty) + parseInt(old_qty);
                            if(max_qty != ''){
                                if (parseInt(pre_qty) <= parseInt(product_stock)) {
                                    if(parseInt(pre_qty) <= parseInt(max_qty) ){
                                        console.log(pre_qty);
                                        $(qty_id).val(pre_qty);
                                    }else{
                                        toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                    }
                                }else{
                                    toastr.warning("{{__('defaultTheme.no_more_stock_available')}}","{{__('common.warning')}}");
                                }        
                            }else{
                                if (parseInt(pre_qty) < parseInt(product_stock)) {
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.no_more_stock_available')}}","{{__('common.warning')}}");
                                }
                            }
                        }else if(type === '-'){
                            var pre_qty = parseInt(old_qty) - parseInt(cahnge_qty);
                            if(min_qty != ''){
                                if(parseInt(pre_qty) >= parseInt(min_qty)){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }else{
                                if(parseInt(pre_qty) > 1){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }
                        }
                    }else{
                        if(type === '+'){
                            var pre_qty = parseInt(cahnge_qty) + parseInt(old_qty);
                            if(max_qty != ''){
                                if(parseInt(pre_qty) <= parseInt(max_qty) ){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }else{
                                $(qty_id).val(pre_qty);
                            }
                        }else if(type === '-'){
                            var pre_qty = parseInt(old_qty) - parseInt(cahnge_qty);
                            if(min_qty != ''){
                                if(parseInt(pre_qty) >= parseInt(min_qty)){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }else{
                                if(parseInt(pre_qty) > 1){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }
                        }
                    }
                });



                $(document).on('click', '.qty_change', function(){

                    var val = $(this).attr("data-value");
                    var id = $(this).attr("data-id");
                    var p_id = $(this).attr("data-product-id");
                    var qty_id = $(this).attr("data-qty");
                    var btn_plus_id = $(this).attr("data-qty-plus-btn-id");
                    var btn_minus_id = $(this).attr("data-qty-minus-btn-id");
                    var maximum_qty = $(this).attr("data-maximum-qty");
                    var minimum_qty = $(this).attr("data-minimum-qty");
                    var stock_manage = $(this).attr("data-stock-manage");
                    var product_available_stock = $(this).attr("data-product-stock");
                    qtyChange(val,id,p_id,qty_id,btn_plus_id,btn_minus_id,maximum_qty,minimum_qty, stock_manage, product_available_stock);

                });

                function qtyChange(val,id,p_id,qty_id,btn_plus_id,btn_minus_id,maximum_qty,minimum_qty, stock_manage, product_available_stock){

                    let qty = $(qty_id).val();
                    let max_qty = $(maximum_qty).val();
                    if (max_qty == 0) {
                        max_qty = qty + 1;
                    }
                    let min_qty = $(minimum_qty).val();
                    let stock_status = stock_manage;
                    let product_stock = product_available_stock;

                    if (stock_status != 0) {
                        if(val == '+'){
                            if(max_qty != ''){
                                if (parseInt(qty) < parseInt(product_stock)) {
                                    if(parseInt(qty) < parseInt(max_qty) ){

                                        let qty1 = parseInt(++qty);
                                        $(qty_id).val(qty1);

                                        $(btn_plus_id).prop('disabled',true);
                                        $(btn_minus_id).prop('disabled',true);
                                        $('#pre-loader').show();

                                        let data = {
                                            '_token' : "{{ csrf_token() }}",
                                            'id' : id,
                                            'p_id' : p_id,
                                            'qty' : $(qty_id).val()
                                        }
                                        let base_url = $('#url').val();
                                        let url = base_url + "/cart/update-qty";

                                        $.post(url, data, function(data){
                                            $('#cart_details_div').empty();
                                            $('#cart_details_div').html(data.MainCart);
                                            $('#cart_inner').empty();
                                            $('#cart_inner').html(data.SubmenuCart);
                                            $('#pre-loader').hide();
                                            $('.nc_select, .select_address').niceSelect();
                                        });


                                    }else{
                                        toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                    }
                                }
                                else {

                                    toastr.warning("{{__('defaultTheme.no_more_stock_available')}}","{{__('common.warning')}}");
                                }
                            }
                            else{
                                if (parseInt(qty) < parseInt(product_stock)) {
                                    let qty1 = parseInt(++qty);
                                    $(qty_id).val(qty1);

                                    $(btn_plus_id).prop('disabled',true);
                                    $(btn_minus_id).prop('disabled',true);
                                    $('#pre-loader').show();

                                    let data = {
                                        '_token' : "{{ csrf_token() }}",
                                        'id' : id,
                                        'p_id' : p_id,
                                        'qty' : $(qty_id).val()
                                    }
                                    let base_url = $('#url').val();
                                    let url = base_url + "/cart/update-qty";

                                    $.post(url, data, function(data){
                                        $('#cart_details_div').empty();
                                        $('#cart_details_div').html(data.MainCart);
                                        $('#cart_inner').empty();
                                        $('#cart_inner').html(data.SubmenuCart);
                                        $('#pre-loader').hide();
                                        $('.nc_select, .select_address').niceSelect();
                                    });
                                }
                                else {
                                    toastr.warning("{{__('defaultTheme.no_more_stock_available')}}","{{__('common.warning')}}");
                                }
                            }

                        }
                        if(val == '-'){
                            if(min_qty != ''){
                                if(parseInt(qty) > parseInt(min_qty)){
                                    if(qty>1){
                                        let qty1 = parseInt(--qty)
                                        $(qty_id).val(qty1)

                                        $(btn_plus_id).prop('disabled',true);
                                        $(btn_minus_id).prop('disabled',true);
                                        $('#pre-loader').show();
                                        let data = {
                                            '_token' : "{{ csrf_token() }}",
                                            'id' : id,
                                            'p_id' : p_id,
                                            'qty' : $(qty_id).val()
                                        }
                                        let base_url = $('#url').val();
                                        let url = base_url + "/cart/update-qty";

                                        $.post(url, data, function(data){
                                            $('#cart_details_div').empty();
                                            $('#cart_details_div').html(data.MainCart);
                                            $('#cart_inner').empty();
                                            $('#cart_inner').html(data.SubmenuCart);
                                            $('#pre-loader').hide();
                                            $('.nc_select, .select_address').niceSelect();
                                        });


                                    }else{
                                        $(btn_minus_id).prop('disabled',true);
                                    }
                                }else{
                                    toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }
                            else{

                                let qty1 = parseInt(--qty)
                                $(qty_id).val(qty1)

                                $(btn_plus_id).prop('disabled',true);
                                $(btn_minus_id).prop('disabled',true);
                                $('#pre-loader').show();
                                let data = {
                                    '_token' : "{{ csrf_token() }}",
                                    'id' : id,
                                    'p_id' : p_id,
                                    'qty' : $(qty_id).val()
                                }
                                let base_url = $('#url').val();
                                let url = base_url + "/cart/update-qty";

                                $.post(url, data, function(data){
                                    $('#cart_details_div').empty();
                                    $('#cart_details_div').html(data.MainCart);
                                    $('#cart_inner').empty();
                                    $('#cart_inner').html(data.SubmenuCart);
                                    $('#pre-loader').hide();
                                    $('.nc_select, .select_address').niceSelect();
                                });
                            }

                        }
                    }
                    else {
                        if(val == '+'){
                            if(max_qty != ''){
                                if(parseInt(qty) < parseInt(max_qty)){

                                    let qty1 = parseInt(++qty);
                                    $(qty_id).val(qty1);

                                    $(btn_plus_id).prop('disabled',true);
                                    $(btn_minus_id).prop('disabled',true);
                                    $('#pre-loader').show();

                                    let data = {
                                        '_token' : "{{ csrf_token() }}",
                                        'id' : id,
                                        'p_id' : p_id,
                                        'qty' : $(qty_id).val()
                                    }
                                    let base_url = $('#url').val();
                                    let url = base_url + "/cart/update-qty";

                                    $.post(url, data, function(data){
                                        $('#cart_details_div').empty();
                                        $('#cart_details_div').html(data.MainCart);
                                        $('#cart_inner').empty();
                                        $('#cart_inner').html(data.SubmenuCart);
                                        $('#pre-loader').hide();
                                        $('.nc_select, .select_address').niceSelect();
                                    });


                                }else{
                                    toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }
                            else{
                                let qty1 = parseInt(++qty);
                                $(qty_id).val(qty1);

                                $(btn_plus_id).prop('disabled',true);
                                $(btn_minus_id).prop('disabled',true);
                                $('#pre-loader').show();

                                let data = {
                                    '_token' : "{{ csrf_token() }}",
                                    'id' : id,
                                    'p_id' : p_id,
                                    'qty' : $(qty_id).val()
                                }
                                let base_url = $('#url').val();
                                let url = base_url + "/cart/update-qty";

                                $.post(url, data, function(data){
                                    $('#cart_details_div').empty();
                                    $('#cart_details_div').html(data.MainCart);
                                    $('#cart_inner').empty();
                                    $('#cart_inner').html(data.SubmenuCart);
                                    $('#pre-loader').hide();
                                    $('.nc_select, .select_address').niceSelect();
                                });
                            }

                        }
                        if(val == '-'){
                            if(min_qty != ''){
                                if(parseInt(qty) > parseInt(min_qty)){
                                    if(qty>1){
                                        let qty1 = parseInt(--qty)
                                        $(qty_id).val(qty1)

                                        $(btn_plus_id).prop('disabled',true);
                                        $(btn_minus_id).prop('disabled',true);
                                        $('#pre-loader').show();
                                        let data = {
                                            '_token' : "{{ csrf_token() }}",
                                            'id' : id,
                                            'p_id' : p_id,
                                            'qty' : $(qty_id).val()
                                        }
                                        let base_url = $('#url').val();
                                        let url = base_url + "/cart/update-qty";

                                        $.post(url, data, function(data){
                                            $('#cart_details_div').empty();
                                            $('#cart_details_div').html(data.MainCart);
                                            $('#cart_inner').empty();
                                            $('#cart_inner').html(data.SubmenuCart);
                                            $('#pre-loader').hide();
                                            $('.nc_select, .select_address').niceSelect();
                                        });


                                    }else{
                                        $(btn_minus_id).prop('disabled',true);
                                    }
                                }else{
                                    toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }
                            else{

                                let qty1 = parseInt(--qty)
                                $(qty_id).val(qty1)

                                $(btn_plus_id).prop('disabled',true);
                                $(btn_minus_id).prop('disabled',true);
                                $('#pre-loader').show();
                                let data = {
                                    '_token' : "{{ csrf_token() }}",
                                    'id' : id,
                                    'p_id' : p_id,
                                    'qty' : $(qty_id).val()
                                }
                                let base_url = $('#url').val();
                                let url = base_url + "/cart/update-qty";

                                $.post(url, data, function(data){
                                    $('#cart_details_div').empty();
                                    $('#cart_details_div').html(data.MainCart);
                                    $('#cart_inner').empty();
                                    $('#cart_inner').html(data.SubmenuCart);
                                    $('#pre-loader').hide();
                                    $('.nc_select, .select_address').niceSelect();
                                });
                            }

                        }
                    }
                }

                $(document).on('change','#selectAllItem',function(el){
                    $('#pre-loader').show();
                    let val = 0;
                    if ($('#selectAllItem').is(":checked")){
                        val = 1;
                        $('.item_check').prop('checked',true);
                    }else{
                        $('.item_check').prop('checked',false);
                    }
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('checked', val);
                    var base_url = $('#url').val();
                    $.ajax({
                        url: base_url + "/cart/select-all",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {

                            $('#cart_details_div').empty();
                            $('#cart_details_div').html(response);
                            $('#pre-loader').hide();
                            $('.nc_select, .select_address').niceSelect();

                        },
                        error: function (response) {
                            $('.nc_select, .select_address').niceSelect();
                            $('#pre-loader').hide();

                        }
                    });

                });

                $(document).on('click', '.shipping_input_data', function() {

                    $('#pre-loader').show();
                    let shipping_method_id = $(this).data('value');
                    let cart_id = $(this).data('id');
                    let modal_id = $(this).data('modal_id');
                    $(modal_id).modal('hide');
                    $.post('{{ route('frontend.cart.update_shipping_info') }}', {_token:'{{ csrf_token() }}', shipping_method_id:shipping_method_id, cartId:cart_id}, function(data){
                        if(data){
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                            $('#pre-loader').hide();
                            $('#cart_details_div').html(data.MainCart);
                        }
                        else{
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");

                            $('#pre-loader').hide();
                        }
                    });
                });



                $(document).on('click', '#delete_all_btn', function(event){
                    event.preventDefault();
                    $('#deleteProductModalAll').modal('show');

                });

                $(document).on('submit', '#product_delete_form_all', function(event){
                    event.preventDefault();
                    deleteAlItem();
                    $('#deleteProductModalAll').modal('hide');
                });

                $(document).on('change', '.select_all_item_check', function(event){
                    event.preventDefault();
                    let unique_id = $(this).data('unique_id');
                    let seller_id = $(this).data('seller_id');
                    let seller_item_unique = $(this).data('seller_item_unique');
                    selectSellerAll(unique_id, seller_id, seller_item_unique);
                });

                $(document).on('change', '.select_single_item_check', function(event){
                    event.preventDefault();
                    let product_id  = $(this).data('product_id');
                    let unique_id  = $(this).data('unique_id');
                    let product_type = $(this).data('product_type');
                    sellerSingleItem(product_id, unique_id, product_type);
                });

                $(document).on('click', '.cart_item_delete_btn', function(event){
                    event.preventDefault();
                    let unique_id  = $(this).data('unique_id');
                    let product_id  = $(this).data('product_id');
                    let id = $(this).data('id');
                    cartProductDelete(id, product_id, unique_id);
                });


                function selectSellerAll(select_all_id,seller_id, item_class){

                    $('#pre-loader').show();
                    let val = 0;
                    if($(select_all_id).is(":checked")){
                        val = 1
                        $(item_class).prop('checked',true);
                    }else{
                        val = 0
                        $(item_class).prop('checked',false);
                    }
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('checked', val);
                    formData.append('seller_id', seller_id);
                    var base_url = $('#url').val();
                    $.ajax({
                        url: base_url + "/cart/select-all-seller",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            $('#cart_details_div').empty();
                            $('#cart_details_div').html(response);
                            $('.nc_select, .select_address').niceSelect();
                            $('#pre-loader').hide();

                        },
                        error: function (response) {
                            $('#pre-loader').hide();
                            $('.nc_select, .select_address').niceSelect();

                        }
                    });
                }

                function sellerSingleItem(p_id,checkbox_id, p_type){
                    $('#pre-loader').show();
                    let val = 0;
                    if($(checkbox_id).is(":checked")){
                        val = 1
                    }else{
                        val = 0
                    }

                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('checked', val);
                    formData.append('product_id', p_id);
                    formData.append('product_type', p_type);
                    var base_url = $('#url').val();
                    $.ajax({
                        url: base_url + "/cart/select-item",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {

                            $('#cart_details_div').empty();
                            $('#cart_details_div').html(response);
                            $('#pre-loader').hide();
                            $('.nc_select, .select_address').niceSelect();


                        },
                        error: function (response) {
                            $('#pre-loader').hide();
                            $('.nc_select, .select_address').niceSelect();

                        }
                    });
                }

                

                $(document).on('click', '.process_to_checkout_check', function(event){
                    event.preventDefault();

                    let count = $(this).data('value');
                    if(count<=0){
                        toastr.warning("{{__('defaultTheme.please_select_product_first')}}","{{__('common.warning')}}");
                    }
                    else{
                        var base_url = $('#url').val();
                        window.location.href = base_url + "/checkout";
                    }
                });

                $(document).on('click', '#term_check', function(event){
                    let val = 0;
                    if($(this).is(":checked")){
                        val = 1;
                    }else{
                        val = 0;
                    }

                    if(parseInt(val) == 0){
                        toastr.error("{{__('common.please_agree_with_our_policy_privacy')}}","{{__('common.error')}}");
                        $('.process_to_checkout_check').addClass('disable');
                    }else{
                        $('.process_to_checkout_check').removeClass('disable');
                    }
                });

                $(document).on('click', '.shipping_show', function(event){
                    let modal_id = $(this).data('id');
                    $(modal_id).modal('show');
                });

            });
        })(jQuery);


    </script>
@endpush
