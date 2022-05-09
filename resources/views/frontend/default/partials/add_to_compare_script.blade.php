@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function() {
                $(document).on('click', ".addToCompareFromThumnail", function(event) {
                    event.preventDefault();

                    var className = this.className;
                    if ($(this).data('producttype') == 1) {

                        addToCompare($(this).attr('data-product-sku'), $(this).data('producttype'), 'product');
                    }
                    else {
                        $('#pre-loader').show();
                        $.post('{{ route('frontend.item.show_in_modal') }}', {_token:'{{ csrf_token() }}', product_id:$(this).attr('data-product-id')}, function(data){
                            $(".add-product-to-cart-using-modal").html(data);
                            $("#theme_modal").modal('show');
                            $('.nc_select, .select_address, #product_short_list, #paginate_by').niceSelect();
                            $('#pre-loader').hide();
                        });
                    }
                });

                $(document).on('click', '#add_to_compare_btn', function(event){
                    event.preventDefault();
                    let product_sku_class = $(this).data('product_sku_id');
                    let product_sku_id = $(product_sku_class).val();
                    let product_type = $(this).data('product_type');
                    addToCompare(product_sku_id, product_type, 'product');
                });

                $(document).on('click', '.add_to_wishlist', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let is_login = $('#login_check').val();
                    let type = 'product';
                    if(is_login == 1){
                        addToWishlist(product_id,seller_id, type);
                        $(this).addClass('is_wishlist');
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }
                });

            });
        })(jQuery);


    </script>
@endpush
