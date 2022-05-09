<script type="text/javascript">

    (function($){
        "use strict";

        $(document).ready(function(){
            $(document).on('click', '#check_shipping_address', function(){

                if (this.checked == true) {
                    $('#check_shipping_address').val("different");
                    $('.shipping_address_div').removeClass('d-none');
                }else {
                    $('#check_shipping_address').val("same");
                    $('.shipping_address_div').addClass('d-none');
                }
            });

            $(document).on('change', '#shipping_address_country', function(event){
                let country = $('#shipping_address_country').val();
                $('#pre-loader').show();
                if(country){
                    let base_url = $('#url').val();
                    let url = base_url + '/seller/profile/get-state?country_id=' +country;

                    $('#shipping_address_state').empty();

                    $('#shipping_address_state').append(
                        `<option value="">Select from options</option>`
                    );
                    $('#shipping_address_state').niceSelect('update');
                    $('#shipping_address_city').empty();
                    $('#shipping_address_city').append(
                        `<option value="">Select from options</option>`
                    );
                    $('#shipping_address_city').niceSelect('update');
                    $.get(url, function(data){

                        $.each(data, function(index, stateObj) {
                            $('#shipping_address_state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                        });

                        $('#shipping_address_state').niceSelect('update');
                        $('#pre-loader').hide();
                    });
                }
            });
            $(document).on('change', '#shipping_address_state', function(event){
                let state = $('#shipping_address_state').val();
                $('#pre-loader').show();
                if(state){
                    let base_url = $('#url').val();
                    let url = base_url + '/seller/profile/get-city?state_id=' +state;


                    $('#shipping_address_city').empty();
                    $('#shipping_address_city').append(
                        `<option value="">Select from options</option>`
                    );
                    $.get(url, function(data){

                        $.each(data, function(index, cityObj) {
                            $('#shipping_address_city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        });

                        $('#shipping_address_city').niceSelect('update');
                        $('#pre-loader').hide();
                    });
                }
            });
            $(document).on('click','#guest_add_submit_btn',function(event){
                $('#pre-loader').show();
                $('#guest_add_submit_btn').prop("disabled", true);
                let name = $('#address_name').val();
                let email = $('#address_email').val();
                let phone_number = $('#address_phone').val();
                let address = $('#address_address').val();
                let city = $('#address_city').val();
                let state = $('#address_state').val();
                let country = $('#address_country').val();
                let postal_code = $('#address_postal_code').val();
                let check_shipping_address = $('#check_shipping_address').val();

                let shipping_address_name = $('#shipping_address_name').val();
                let shipping_address_email = $('#shipping_address_email').val();
                let shipping_address_phone = $('#shipping_address_phone').val();
                let shipping_address_address = $('#shipping_address_address').val();
                let shipping_address_city = $('#shipping_address_city').val();
                let shipping_address_state = $('#shipping_address_state').val();
                let shipping_address_country = $('#shipping_address_country').val();
                let shipping_address_postal_code = $('#shipping_address_postal_code').val();

                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('name', name);
                formData.append('email', email);
                formData.append('phone_number', phone_number);
                formData.append('address', address);
                formData.append('city', city);
                formData.append('state', state);
                formData.append('country', country);
                formData.append('postal_code', postal_code);
                formData.append('check_shipping_address', check_shipping_address);
                formData.append('shipping_address_name', shipping_address_name);
                formData.append('shipping_address_email', shipping_address_email);
                formData.append('shipping_address_phone', shipping_address_phone);
                formData.append('shipping_address_address', shipping_address_address);
                formData.append('shipping_address_city', shipping_address_city);
                formData.append('shipping_address_state', shipping_address_state);
                formData.append('shipping_address_country', shipping_address_country);
                formData.append('shipping_address_postal_code', shipping_address_postal_code);
                formData.append('form', 'normal_form');


                removeErrorGuest();

                $.ajax({
                    url: "{{route('frontend.checkout.guest.address.store')}}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        $('#mainDiv').empty();
                        $('#mainDiv').html(response.MainCheckout);
                        $('#guest_add_submit_btn').prop("disabled", false);
                        $('#pre-loader').hide();

                    },
                    error: function (response) {
                        console.log(response.responseJSON.errors)
                        showValidateGuest(response)
                        $('#guest_add_submit_btn').prop("disabled", false);
                        $('#pre-loader').hide();


                    }
                });

            });
            function showValidateGuest(response){
                $('.new_address_name').text(response.responseJSON.errors.name)
                $('.new_address_email').text(response.responseJSON.errors.email)
                $('.new_address_phone').text(response.responseJSON.errors.phone_number)
                $('.new_address_address').text(response.responseJSON.errors.address)
                $('.new_address_city').text(response.responseJSON.errors.city)
                $('.new_address_state').text(response.responseJSON.errors.state)
                $('.new_address_country').text(response.responseJSON.errors.country)
                $('.new_address_postal_code').text(response.responseJSON.errors.postal_code)
                $('.shipping_address_name').text(response.responseJSON.errors.shipping_address_name)
                $('.shipping_address_email').text(response.responseJSON.errors.shipping_address_email)
                $('.shipping_address_phone').text(response.responseJSON.errors.shipping_address_phone)
                $('.shipping_address_address').text(response.responseJSON.errors.shipping_address_address)
                $('.shipping_address_city').text(response.responseJSON.errors.shipping_address_city)
                $('.shipping_address_state').text(response.responseJSON.errors.shipping_address_state)
                $('.shipping_address_country').text(response.responseJSON.errors.shipping_address_country)
                $('.shipping_address_postal_code').text(response.responseJSON.errors.shipping_address_postal_code)
            }
            function removeErrorGuest(){
                $('.new_address_name').text('')
                $('.new_address_email').text('')
                $('.new_address_phone').text('')
                $('.new_address_address').text('')
                $('.new_address_city').text('')
                $('.new_address_state').text('')
                $('.new_address_country').text('')
                $('.new_address_postal_code').text('')
                $('.shipping_address_name').text('')
                $('.shipping_address_email').text('')
                $('.shipping_address_phone').text('')
                $('.shipping_address_address').text('')
                $('.shipping_address_city').text('')
                $('.shipping_address_state').text('')
                $('.shipping_address_country').text('')
                $('.shipping_address_postal_code').text('')
            }

            $(document).on('click','#guest_shipping_phone_new_btn', function(){
            $('#guest_shipping_phone_new_btn').prop("disabled", true);
            $('#pre-loader').show();
            let phone = $('#guest_shipping_phone_new').val();
            let formData = new FormData();

                formData.append('_token', "{{ csrf_token() }}");
                formData.append('phone', phone);


                $.ajax({
                    url: "{{route('frontend.guest.checkout.phone.change')}}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {

                        $('#mainDiv').empty();
                        $('#mainDiv').html(response.MainCheckout);
                        $('#guest_shipping_phone_new_btn').prop("disabled", false);
                        $('#pre-loader').hide();
                    },
                    error: function (response) {
                        $('#guest_shipping_phone_new_btn').prop("disabled", false);
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').hide();
                    }
                });
            });

            $(document).on('click','#guest_shipping_email_new_btn', function(){
            $('#guest_shipping_email_new_btn').prop("disabled", true);
            $('#pre-loader').show();
            let email = $('#guest_shipping_email_new').val();
            let formData = new FormData();

                formData.append('_token', "{{ csrf_token() }}");
                formData.append('email', email);


                $.ajax({
                    url: "{{route('frontend.guest.checkout.email.change')}}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {

                        $('#mainDiv').empty();
                        $('#mainDiv').html(response.MainCheckout);
                        $('#guest_shipping_email_new_btn').prop("disabled", false);
                        $('#pre-loader').hide();
                    },
                    error: function (response) {
                        $('#guest_shipping_email_new_btn').prop("disabled", false);
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').hide();
                    }
                });
            });
        });
    })(jQuery);


</script>
