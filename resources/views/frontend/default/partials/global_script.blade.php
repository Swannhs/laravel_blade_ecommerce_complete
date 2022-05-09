<script>
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
        $('#pre-loader').show();

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
                    $('#pre-loader').hide();
                    $('#add_to_cart_btn').prop('disabled',false);
                    $('#add_to_cart_btn').html("{{__('defaultTheme.add_to_cart')}}");
                }else{
                    toastr.success("{{__('defaultTheme.product_successfully_added_to_cart')}}", "{{__('common.success')}}");
                    if (window.location.pathname.split( '/' ) == ",my-wishlist") {
                        location.reload();
                    }
                    $('#add_to_cart_btn').prop('disabled',false);
                    $('#add_to_cart_btn').html("{{__('defaultTheme.add_to_cart')}}");

                    $('#cart_inner').empty();
                    $('#cart_inner').html(response);
                    if ($(".add-product-to-cart-using-modal").length){
                        $('.add_to_cart_modal').modal('hide');
                    }
                    $('#pre-loader').hide();
                }
            },
            error: function (response) {
                toastr.error("{{__('defaultTheme.product_not_added')}}","{{__('common.error')}}");
                $('#add_to_cart_btn').prop('disabled',false);
                $('#add_to_cart_btn').html("{{__('defaultTheme.add_to_cart')}}");
                $('#pre-loader').hide();
            }
        });
    }
    function cartProductDelete(id,p_id,btn_id){
        $('#pre-loader').show();
        $(btn_id).prop("disabled", true);
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('id', id);
        formData.append('p_id', p_id);

        var base_url = $('#url').val();
        $.ajax({
            url: base_url + "/cart/delete",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                toastr.success("{{__('defaultTheme.product_successfully_deleted_from_cart')}}", "{{__('common.success')}}");
                $('#cart_details_div').empty();
                $('#cart_details_div').html(response.MainCart);
                $(btn_id).prop("disabled", false);

                $('#cart_inner').empty();
                $('#cart_inner').html(response.SubmenuCart);
                $('#pre-loader').hide();

            },
            error: function (response) {
                $(btn_id).prop("disabled", false);
                $('#pre-loader').hide();

            }
        });
    }
    function deleteAlItem(){
        $('#delete_all_btn').prop("disabled", true);
        $('#pre-loader').show();
        var base_url = $('#url').val();
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        $.ajax({
            url: base_url + "/cart/delete-all",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                toastr.success("{{__('defaultTheme.product_successfully_deleted_from_cart')}}", "{{__('common.success')}}");
                $('#cart_details_div').empty();
                $('#cart_details_div').html(response.MainCart);
                $('#delete_all_btn').prop("disabled", false);
                $('#cart_inner').empty();
                $('#cart_inner').html(response.SubmenuCart);
                $('#pre-loader').hide();

            },
            error: function (response) {
                $('#delete_all_btn').prop("disabled", false);
                $('#pre-loader').hide();
            }
        });
    }
    function addToWishlist(seller_product_id, seller_id, type) {
        $('#wishlist_btn').addClass('wishlist_disabled');
        $('#wishlist_btn').html("{{__('defaultTheme.adding')}}");
        $('#pre-loader').show();

        $.post('{{ route('frontend.wishlist.store') }}', {_token:'{{ csrf_token() }}', seller_product_id:seller_product_id, seller_id:seller_id, type: type}, function(data){
            if(data.result == 1){
                toastr.success("{{__('defaultTheme.successfully_added_to_wishlist')}}","{{__('common.success')}}");
                $('#wishlist_btn').removeClass('wishlist_disabled');
                $('#wishlist_btn').html("{{__('defaultTheme.add_to_wishlist')}}");
                $('.wishlist_count').text(data.totalItems);
            }else if(data.result == 3){
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
                if(response.msg == 'done'){
                    toastr.success("{{__('defaultTheme.product_added_to_compare_list_successfully')}}","{{__('common.success')}}")
                    $("#theme_modal").modal('hide');
                    $('.compare_count').text(response.totalItems);
                }else{
                    toastr.error("{{__('defaultTheme.not_added')}}","{{__('common.error')}}")

                }
                $('#pre-loader').hide();
            });
        }
    }

    function getFileName(value, placeholder){
        if (value) {
            var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
            var filename = value.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $(placeholder).attr('placeholder', '');
            $(placeholder).attr('placeholder', filename);
        }
    }


    function imageChangeWithFile(input,srcId){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(srcId)
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>