<script src="{{ asset(asset_path('frontend/default/compile_js/app.js')) }}"></script>

<script>

    window._locale = '{{ app()->getLocale() }}';
    window._translations = {!! cache('translations') !!};

    window.trans = function(string, args) {

        let jsLang = $.parseJSON(window._translations[window._locale]);


        let enLang = $.parseJSON(window._translations.en);
        let value = _.get(jsLang, string);

        if(typeof value == 'undefined'){
            value = _.get(enLang, string);
        }

        _.eachRight(args, (paramVal, paramKey) => {
            value = paramVal.replace(`:${paramKey}`, value);
        });

        if(typeof value == 'undefined'){
            return string;
        }

        return value;


    }
</script>




@php echo Toastr::message(); @endphp

<script>

    (function($){
        "use strict";
        $(document).ready(function(){

            @if(Session::has('messege'))
                let type = "{{Session::get('alert-type','info')}}";
                switch(type){
                    case 'info':
                        toastr.info("{{ Session::get('messege') }}");
                        break;
                    case 'success':
                        toastr.success("{{ Session::get('messege') }}");
                        break;
                    case 'warning':
                        toastr.warning("{{ Session::get('messege') }}");
                        break;
                    case 'error':
                        toastr.error("{{ Session::get('messege') }}");
                        break;
                }
            @endif

            checkSearchItem();

            function checkSearchItem(){
                var url_string = location.href;
                var url = new URL(url_string);
                var c = url.searchParams.get("item");
                if(c == 'search'){
                    $('.category_box_input').val(localStorage.getItem('search_item'));
                }else{
                    localStorage.removeItem('search_item');
                }
            }

            setTimeout(function () {
                $("#subscriptionDiv").removeClass('d-none');
            }, {{ $popupContent->second }}*1000);
            $(document).on('submit','#subscriptionForm', function(event) {
                event.preventDefault();
                $("#subscribeBtn").prop('disabled', true);
                $('#subscribeBtn').text('{{ __("common.submitting") }}');

                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $('.message_div').html('');
                $('.message_div').addClass('d-none');
                $.ajax({
                    url: "{{ route('subscription.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        $('.message_div').removeClass('d-none');
                        $('.message_div').removeClass('error_color');
                        $('.message_div').addClass('success_color');
                        $('.message_div').html(`
                            <span class="text-success">{{__('defaultTheme.subscribe_successfully')}}</span>
                        `);
                        $("#subscribeBtn").prop('disabled', false);
                        $('#subscribeBtn').text("{{ __('defaultTheme.subscribe') }}");
                        $('#subscription_email_id').val('');
                    },
                    error: function(response) {
                        $('.message_div').removeClass('d-none');
                        $('.message_div').addClass('error_color');
                        $('.message_div').html(`
                            <span class="text-danger">${response.responseJSON.errors.email}</span>
                        `);
                        $("#subscribeBtn").prop('disabled', false);
                        $('#subscribeBtn').text("{{ __('defaultTheme.subscribe') }}");
                    }
                });
            });

            // modal subscription
            $(document).on('submit','#modalSubscriptionForm', function(event) {
                event.preventDefault();
                $("#modalSubscribeBtn").prop('disabled', true);
                $('#modalSubscribeBtn').text('{{ __("common.submitting") }}');

                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $('.message_div_modal').html('');
                $('.message_div_modal').addClass('d-none');
                $.ajax({
                    url: "{{ route('subscription.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        toastr.success("{{__('defaultTheme.subscribe_successfully')}}", "{{__('common.success')}}");
                        $("#modalSubscribeBtn").prop('disabled', false);
                        $('#modalSubscribeBtn').text("{{ __('defaultTheme.subscribe') }}");
                        $('#modalSubscription_email_id').val('');
                        $("#subscriptionModal").hide();
                    },
                    error: function(response) {
                        $('.message_div_modal').removeClass('d-none');
                        $('.message_div_modal').addClass('error_color');
                        $('.message_div_modal').html(`
                            <span class="text-danger">${response.responseJSON.errors.email}</span>
                        `);
                        $("#modalSubscribeBtn").prop('disabled', false);
                        $('#subscribeBtn').text("{{ __('defaultTheme.subscribe') }}");
                    }
                });
            });

            $(document).on('click', '.remove_from_submenu_btn', function(event){
                let id = $(this).data('id');
                let product_id = $(this).data('product_id');
                let btn = $(this).data('btn');
                cartProductDelete(id,product_id, btn);

            });

            $(document).on('click', '.log_out', function(event){
                event.preventDefault();
                $('#logout-form').submit();
            });

            $(document).on('focus', '#subscription_email_id', function(event){
                $(this).attr('placeholder','');
            });

            $(document).on('blur', '#subscription_email_id', function(event){
                $(this).attr('placeholder','{{__("defaultTheme.enter_email_address")}}');
            });




            // 2nd script tag

            var ENDPOINT = "{{ url('/') }}";
            var Cpage = 1;
            $(document).on('click', '.load_more_btn_homepage', function(event){
                event.preventDefault();
                Cpage++;
                var new_url = '/get-more-products?page=';
                var tbl_name = ".dataApp";
                infinteLoadMore(Cpage, new_url, tbl_name);
            });

            function infinteLoadMore(page, new_url, tbl_name) {
                $.ajax({
                    url: ENDPOINT + new_url + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('#pre-loader').show();
                    }
                })
                .done(function (response) {
                    if (response.length == 0) {
                        $(".load_more_btn_homepage").addClass('d-none');
                        toastr.warning("{{__('defaultTheme.no_more_data_to_show')}}");
                        $('#pre-loader').hide();
                        return;
                    }
                    $('#pre-loader').hide();
                    $(tbl_name).append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    $('#pre-loader').hide();
                });
            }

            var typingTimer;
            var doneTypingInterval = 300;
            var $input = $('.category_box_input');
            var $inputCategory = $('.category_id option:selected');

            //on keyup, start the countdown
            $input.on('keyup', function () {
                if ($input.val().length > 0) {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
                }
                else {
                    $(".search_item").html('');

                }
            });

            $(document).on('submit','#search_form', function(event){
                event.preventDefault();
                var input_data = $('.category_box_input').val();
                var genUrl = "{{url('/category')}}"+'/'+input_data+'?item=search&category='+$('.category_id option:selected').val();

                let search_items = {};
                search_items = JSON.parse(localStorage.getItem('search_history'));
                if(search_items != null){
                    if(search_items.hasOwnProperty(input_data)){
                        var newjson = search_items;
                    }else{
                        if(input_data != ''){
                            var new_data = {
                                [input_data]: genUrl
                            }
                            var newjson = {
                                ...new_data,
                                ...search_items

                            }
                        }else{
                            var newjson = search_items;
                        }
                    }
                }else{
                    if(input_data != ''){
                        var newjson = {
                            [input_data]:genUrl
                        }
                    }else{
                        var newjson = search_items;
                    }
                }
                localStorage.setItem('search_history', JSON.stringify(newjson));
                localStorage.setItem('search_item',input_data);
                location.replace(genUrl);
            });

            $(document).on('focus', '.category_box_input', function(){
                if($(this).val() == ''){
                    if(localStorage.getItem('search_history') != null && localStorage.getItem('search_history') != undefined){
                        $('.search_item').html('');
                        var search_item = JSON.parse(localStorage.getItem('search_history'));
                        var elementData = "";
                        if(Object.keys(search_item).length > 0){
                            $('#search_history').html(`
                                <div class='search_product_info search_history'>
                                    <p>search history</p>
                                    <strong id='clear_search'>Clear</strong>
                                    </div>
                                <div class="tags_list d-flex flex-column seach_list_padding search_history_list">
                                    
                                </div>
                            `);
                            var count_limit = 1;
                            $.each(search_item, function(key, val) {
                                if(count_limit >=7){
                                    return false;
                                }
                                elementData += '<a href="'+val+'">'+key+'</a>';
                                count_limit ++;

                            });
                        }
                        $(".search_history_list").html(elementData);
                        $("#search_items").show();
                    }else{
                        if($(".search_history_list a").length > 0){
                            $("#search_items").show();
                        }
                    }
                }else{
                    $("#search_items").show();
                    if ($input.val().length > 0) {
                        clearTimeout(typingTimer);
                        typingTimer = setTimeout(doneTyping, doneTypingInterval);
                    }
                }
            });
            $(document).on('keyup','.category_box_input', function(){
                $("#search_items").show();
            });

            $(document).on('click', '#clear_search', function(){
                localStorage.removeItem('search_history');
                // var search_item = JSON.parse(localStorage.getItem('search_history'));
                // var elementData = "";
                // jQuery.each(search_item, function(key, val) {
                //     elementData += "<li><div class='search_product_info'><a href='"+val+"' class='product_link'>"+key+"</a></div></li>";
                // });
                $("#search_history").html('');
                $("#search_items").hide();
            });

            var focus_check = false;
            $("#search_items").bind("mouseover",function() {
                focus_check = true;
            }).bind("mouseout",function() {
                focus_check = false;
            });

            $(document).on('blur', '.category_box_input', function(){

                if(!focus_check) {
                    $("#search_items").hide();
                }
            });

            $(document).on('click', '.store_link', function(event){
                event.preventDefault();
                if($(this).data('type') == 'product'){
                    var input_data = $(this).find('.search_product_name').text();
                }else{
                    var input_data = $(this).text();
                }
                var genUrl = $(this).attr('href');
                let search_items = {};
                search_items = JSON.parse(localStorage.getItem('search_history'));
                if(search_items != null){
                    if(search_items.hasOwnProperty(input_data)){
                        var newjson = search_items;
                    }else{
                        if(input_data != ''){
                            var new_data = {
                                [input_data]: genUrl
                            }
                            var newjson = {
                                ...new_data,
                                ...search_items

                            }
                        }else{
                            var newjson = search_items;
                        }
                    }
                }else{
                    if(input_data != ''){
                        var newjson = {
                            [input_data]:genUrl
                        }
                    }else{
                        var newjson = search_items;
                    }
                }
                localStorage.setItem('search_history', JSON.stringify(newjson));
                localStorage.setItem('search_item',input_data);
                location.replace(genUrl);
            });



            //on keydown, clear the countdown
            $input.on('keydown', function () {
                clearTimeout(typingTimer);
            });



            //user is "finished typing," do something
            function doneTyping () {

                $.ajax({
                    url: ENDPOINT + '/ajax-search-product',
                    datatype: "json",
                    type: "post",
                    data: {
                        _token: '{{ csrf_token() }}',
                        cat_id: $('.category_id option:selected').val(),
                        keyword: $input.val(),
                    }
                })
                .done(function (response) {
                    $("#tag_search").html('');
                    $("#category_search").html('');
                    $('.search_item').html('');
                    var tagData = "";
                    var categoryData = "";
                    var productData = "";
                    var sellerData = "";
                    if(response.tags.length > 0){
                        $("#tag_search").html(`
                            <div class="tag_box">
                                    <a href="javascript:void(0)" class="search_title ">popular Suggestions</a>
                            </div>
                            <div class="tags_list d-flex flex-column seach_list_padding"></div>
                        `);
                        response.tags.forEach((item) => {
                            var page_url = ENDPOINT + '/category/' + item.name + '?item=search&category_id='+$('.category_id option:selected').val();
                            tagData += '<a class="store_link" data-type="tag" href="'+page_url+'">'+item.name+'</a>';
                        });
                    }

                    if(response.categories.length > 0){
                        $('#category_search').html(`
                            <div class="tag_box">
                                <a href="javascript:void(0)" class="search_title">Category Suggestions</a>
                            </div>
                            <div class="search_category_list d-flex  flex-column seach_list_padding"></div>
                        `);
                        response.categories.forEach((item) => {
                            var page_url = ENDPOINT + '/category/' + item.slug + '?item=category';
                            categoryData += '<a class="store_link" data-type="category" href="'+page_url+'">'+item.name+'</a>';
                        });
                    }
                    if(response.products.length > 0){
                        $('#product_search').html(`
                            <div class="tag_box">
                                    <a href="javascript:void(0)" class="search_title">Products</a>
                            </div>
                            <div class="Products_list d-flex  flex-column seach_list_padding" id="search_product_list"></div>
                        `);
                        response.products.forEach((item) => {
                            var price_list = '';
                            var stock = '';
                            if(item.hasDiscount){
                                price_list = `
                                    <span class="prev_prise ">${currency_format(item.selling_price)}</span>
                                    <span class="current_prise">${currency_format(item.discount_price)}</span>
                                `;
                            }else{
                                price_list = `<span class="current_prise">${currency_format(item.selling_price)}</span>`;
                            }
                            if(item.stock){
                                stock = `<div class="product_available">In Stock</div>`;
                            }else{
                                stock = `<div class="product_stockout">Stock Out</div>`;
                            }
                            productData += `
                                <a data-type="product" href="${item.url}" class="store_link product_search_single d-flex align-items-center mb_10 gap_10">
                                    <div class="product_info d-flex align-items-center flex-fill gap_10">
                                        <div class="thumb">
                                                <img src="${item.thumb_img}" alt="">
                                        </div>
                                        <div class="product_info_text">
                                            <h4 class="m-0 search_product_name">${item.product_name}</h4>
                                            <div class="prise_tag d-flex align-items-center gap_10">
                                                ${price_list}
                                            </div>
                                        </div>
                                        </div>
                                    ${stock}
                                </a>
                            `;
                        });
                    }
                    if(response.sellers != undefined){
                        if(response.sellers.length > 0){
                            $('#seller_search').html(`
                                <div class="tag_box">
                                    <a href="#" class="search_title">Shops</a>
                                </div>
                                <div class="shop_list d-flex  flex-column  seach_list_padding" id="search_seller_list"></div>
                            `);

                            response.sellers.forEach((item) => {
                                var url = ENDPOINT + '/seller-profile/'+item.slug;
                                sellerData += `
                                    <a href="${url}" data-type="product" class="store_link product_search_single d-flex align-items-center gap_10">
                                        <div class="product_info flex-fill d-flex gap_10 mb_10 align-items-center">
                                            <div class="thumb">
                                                <img src="${item.avater}" alt="">
                                            </div>
                                            <div class="product_info_text">
                                                <h4 class="m-0 search_product_name">${item.first_name}</h4>
                                                <p class="m-0">${item.address}</p>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            });

                        }
                    }
                    

                    if(response.tags.length < 1 && response.products.length < 1 && response.categories.length < 1){
                        $('.search_item').html('');
                        var keyword = $input.val();
                        $('#search_empty_list').html(`
                            <div class="search_empty_list_div">
                                <p>Nothing Found for "<strong class="search_keyword">${keyword}</strong>"</p>
                            </div>
                        `);

                    }

                    $(".tags_list").html(tagData);
                    $(".search_category_list").html(categoryData);
                    $("#search_product_list").html(productData);
                    if(response.sellers != undefined){
                        $("#search_seller_list").html(sellerData);
                    }
                    if ($input.val()) {
                        $('#tag_search').highlight($input.val());
                        $('#category_search').highlight($input.val());
                        $('#product_search').highlight($input.val());
                        $('#seller_search').highlight($input.val());
                    }
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {

                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                });
            }


            $(document).on('change','#bredCumb_switch', function(){
                window.location.href = $('#url').val();
            });

        });

        toastr.options = {
            newestOnTop : true,
            closeButton :true,
            progressBar : true,
            positionClass : "{{$adminColor->toastr_position}}",
            preventDuplicates: false,
            showMethod: 'slideDown',
            timeOut : "{{$adminColor->toastr_time}}",
        };

    })(jQuery);

</script>
@include('frontend.default.partials.global_script')
