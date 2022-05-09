@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";

            $(document).ready(function() {
                $(document).on('click', ".addToCartFromThumnail", function() {
                    event.preventDefault();
                    var className = this.className;
                    $("."+className).prop("disabled", true);
                    if ($(this).data('producttype') == 1) {

                        let is_stock_manage = $(this).data('stock_manage');
                        let stock = $(this).data('stock');
                        let min_qty = $(this).data('min_qty');

                        if(is_stock_manage == 1 && stock > min_qty){
                            addToCart($(this).attr('data-product-sku'),$(this).attr('data-seller'),min_qty,$(this).attr('data-base-price'),$(this).attr('data-shipping-method'),'product')
                            $("."+className).prop("disabled", false);
                        
                        }else if(is_stock_manage == 0){
                            addToCart($(this).attr('data-product-sku'),$(this).attr('data-seller'),min_qty,$(this).attr('data-base-price'),$(this).attr('data-shipping-method'),'product')
                            $("."+className).prop("disabled", false);
                        }else{
                            toastr.warning("{{__('defaultTheme.out_of_stock')}}");
                            $("."+className).prop("disabled", false);
                        }
                        
                    }
                    else {
                        $('#pre-loader').show();
                        $.post('{{ route('frontend.item.show_in_modal') }}', {_token:'{{ csrf_token() }}', product_id:$(this).attr('data-product-id')}, function(data){
                            $(".add-product-to-cart-using-modal").html(data);
                            $("#theme_modal").modal('show');
                            $('.nc_select, .select_address, #product_short_list, #paginate_by').niceSelect();
                            $("."+className).prop("disabled", false);
                            $('#pre-loader').hide();
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

                $(document).on('click', '.add_to_wishlist_modal', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let is_login = $('#login_check').val();
                    let type = 'product';
                    if(is_login == 1){
                        addToWishlist(product_id,seller_id, type);
                        $("#theme_modal").modal('hide');
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }
                });

                $(document).on('click', '#add_to_cart_btn', function(event){
                    event.preventDefault();
                    addToCart($('#product_sku_id').val(),$('#seller_id').val(),$('#qty').val(),$('#base_sku_price').val(),$('#shipping_type').val(),'product');
                });

                $(document).on('click', '.attr_val_name', function(){

                    $(this).parent().parent().find('.attr_value_name').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));
                    $(this).parent().parent().find('.attr_value_id').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));

                    if ($(this).attr('color') == "color") {
                        $('.attr_clr').removeClass('selected_btn');
                    }
                    if ($(this).attr('color') == "not") {
                        $('.not_111').removeClass('selected_btn');
                    }
                    $(this).addClass('selected_btn');
                    get_price_accordint_to_sku();

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

                var old_html = $("#myTabContent").html();
                $('.var_img_source').hover(function() {
                var logo = $(this).attr("src"); alert(logo)// get logo from data-icon parameter
                $('.var_img_show').attr("src", logo); // change logo
                }, function() {
                $("#myTabContent").html(old_html); // remove logo
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
                                    <button type="button" disabled class="btn_1">{{__('defaultTheme.out_of_stock')}}</button>
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
