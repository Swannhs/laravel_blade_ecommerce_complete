<script>
    
    // add to cart
    function addToCart(product_sku_id, seller_id, qty, price, shipping_type, type) {
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

        var base_url = $('#url').val();
        $.ajax({
            url: base_url + "/cart/store",
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
                    if (window.location.pathname.split( '/' ) == ",my-wishlist") {
                        location.reload();
                    }
                    $('#add_to_cart_btn').prop('disabled',false);
                    $('#add_to_cart_btn').html("{{__('defaultTheme.add_to_cart')}}");

                    $('#cart_inner').html(response);
                    if ($(".add-product-to-cart-using-modal").length){
                        $('.add_to_cart_modal').modal('hide');
                    }
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
    }

    // add to wishlist
    function addToWishlist(seller_product_id, seller_id, type) {
        $('#wishlist_btn').addClass('wishlist_disabled');
        $('#wishlist_btn').html("{{__('defaultTheme.adding')}}");
        $('#pre-loader').show();

        $.post('{{ route('frontend.wishlist.store') }}', {_token:'{{ csrf_token() }}', seller_product_id:seller_product_id, seller_id:seller_id, type: type}, function(data){
            if(data == 1){
                toastr.success("{{__('defaultTheme.successfully_added_to_wishlist')}}","{{__('common.success')}}");
                $('#wishlist_btn').removeClass('wishlist_disabled');
                $('#wishlist_btn').html("{{__('defaultTheme.add_to_wishlist')}}");
            }else if(data == 3){
                toastr.warning("{{__('defaultTheme.product_already_in_wishList')}}","{{__('defaultTheme.thanks')}}");
                $('#wishlist_btn').removeClass('wishlist_disabled');
                $('#wishlist_btn').html("{{__('defaultTheme.add_to_wishlist')}}");
            }
            else{
                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                $('#wishlist_btn').removeClass('wishlist_disabled');
                $('#wishlist_btn').html("{{__('defaultTheme.add_to_wishlist')}}");
            }
            $('#pre-loader').hide();
        });
    }
    function wishlistToggle(id){
        $('#'+id).addClass('is_wishlist');
    }

    // add to comparegit 
    function addToCompare(product_sku_id, product_type, type){
        if(product_sku_id && type){
            $('#pre-loader').show();
            let data = {
                '_token' : '{{ csrf_token() }}',
                'product_sku_id' : product_sku_id,
                'data_type' : type,
                'product_type' : product_type
            }

            $.post("{{route('frontend.compare.store')}}", data, function(response){
                if(response == 1){
                    toastr.success("{{__('defaultTheme.product_added_to_compare_list_successfully')}}","{{__('common.success')}}")
                    $("#theme_modal").modal('hide');
                }else{
                    toastr.error("{{__('defaultTheme.not_added')}}","{{__('common.error')}}")

                }
                $('#pre-loader').hide();
            });
        }
    }


</script>