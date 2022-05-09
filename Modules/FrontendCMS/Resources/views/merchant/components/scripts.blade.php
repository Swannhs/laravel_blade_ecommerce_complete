@push('scripts')

    <script>

        (function($){

            "use strict";

            $(document).ready(function() {
                $(document).on('submit', '#formData', function(event) {
                    event.preventDefault();
                    resetValidationErrors();

                    $("#mainSubmit").prop('disabled', true);
                    $('#mainSubmit').text('{{ __("common.updating") }}');
                    $('#pre-loader').removeClass('d-none');


                    let id = $('#mainId').val();
                    let mainTitle = $('#mainTitle').val();
                    let subTitle = $('#subTitle').val();
                    let slug = $('#mainSlug').val();
                    let pricing = $('#pricing').val();
                    let Maindescription = $('#Maindescription').val();
                    let benifitTitle = $('#benifitTitle').val();
                    let benifitDescription = $('#benifitDescription').val();
                    let pricingTitle = $('#pricingTitle').val();
                    let pricingDescription = $('#pricingDescription').val();
                    let sellerRegistrationTitle = $('#sellerRegistrationTitle').val();
                    let sellerRegistrationDescription = $('#sellerRegistrationDescription').val();
                    let howitworkTitle = $('#howitworkTitle').val();
                    let howitworkDescription = $('#howitworkDescription').val();
                    let queryTitle = $('#queryTitle').val();
                    let queryDescription = $('#queryDescription').val();
                    let faqTitle = $('#faqTitle').val();
                    let faqDescription = $('#faqDescription').val();
                    let pricing_id = $('#pricing_id').val();

                    var formData = new FormData();

                    formData.append('id', id);
                    formData.append('mainTitle', mainTitle);
                    formData.append('subTitle', subTitle);
                    formData.append('slug', slug);
                    formData.append('pricing', pricing);
                    formData.append('Maindescription', Maindescription);
                    formData.append('benifitTitle', benifitTitle);
                    formData.append('benifitDescription', benifitDescription);
                    formData.append('pricingTitle', pricingTitle);
                    formData.append('pricingDescription', pricingDescription);
                    formData.append('sellerRegistrationTitle', sellerRegistrationTitle);
                    formData.append('sellerRegistrationDescription', sellerRegistrationDescription);
                    formData.append('howitworkTitle', howitworkTitle);
                    formData.append('howitworkDescription', howitworkDescription);
                    formData.append('queryTitle', queryTitle);
                    formData.append('queryDescription', queryDescription);
                    formData.append('faqTitle', faqTitle);
                    formData.append('faqDescription', faqDescription);
                    formData.append('pricing_id', pricing_id);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('frontendcms.merchant-content.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")

                            $('#mainSubmit').text('{{__("common.update")}}');
                            $("#mainSubmit").prop('disabled', false);
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $("#mainSubmit").prop('disabled', false);
                            $('#mainSubmit').text('{{__("common.update")}}');
                            showValidationErrors('#formData', response.responseJSON.errors);
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });


                $(document).on('keyup', '#mainTitle', function(event){
                    processSlug($(this).val(), '#mainSlug');
                });


                function showValidationErrors(formType, errors) {
                    $(formType + ' #error_mainTitle').text(errors.mainTitle);
                    $(formType + ' #error_subTitle').text(errors.subTitle);
                    $(formType + ' #error_mainDescription').text(errors.Maindescription);
                    $(formType + ' #error_slug').text(errors.slug);
                    $(formType + ' #error_pricing').text(errors.pricing);
                    $(formType + ' #error_benifitTitle').text(errors.benifitTitle);
                    $(formType + ' #error_benifitDescription').text(errors.benifitDescription);
                    $(formType + ' #error_howitworkTitle').text(errors.howitworkTitle);
                    $(formType + ' #error_howitworkDescription').text(errors.howitworkDescription);
                    $(formType + ' #error_pricintTitle').text(errors.pricintTitle);
                    $(formType + ' #error_pricingDescription').text(errors.pricingDescription);
                    $(formType + ' #error_queryTitle').text(errors.queryTitle);
                    $(formType + ' #error_queryDescription').text(errors.queryDescription);
                    $(formType + ' #error_faqTitle').text(errors.faqTitle);
                    $(formType + ' #error_faqDescription').text(errors.faqDescription);
                    $(formType + ' #error_sellerRegistrationTitle').text(errors.sellerRegistrationTitle);
                    $(formType + ' #error_sellerRegistrationDescription').text(errors.sellerRegistrationDescription);
                }

                function resetValidationErrors() {
                    $('#formData' + ' #error_mainTitle').text('');
                    $('#formData' + ' #error_subTitle').text('');
                    $('#formData' + ' #error_mainDescription').text('');
                    $('#formData' + ' #error_slug').text('');
                    $('#formData' + ' #error_pricing').text('');
                    $('#formData' + ' #error_benifitTitle').text('');
                    $('#formData' + ' #error_benifitDescription').text('');
                    $('#formData' + ' #error_howitworkTitle').text('');
                    $('#formData' + ' #error_howitworkDescription').text('');
                    $('#formData' + ' #error_pricintTitle').text('');
                    $('#formData' + ' #error_pricingDescription').text('');
                    $('#formData' + ' #error_queryTitle').text('');
                    $('#formData' + ' #error_queryDescription').text('');
                    $('#formData' + ' #error_faqTitle').text('');
                    $('#formData' + ' #error_faqDescription').text('');
                    $('#formData' + ' #error_sellerRegistrationTitle').text('');
                    $('#formData' + ' #error_sellerRegistrationDescription').text('');
                }


            });

        })(jQuery);


        function showValidationErrorsForBenefit(formType, errors) {
            $(formType + ' #create_error_title').text(errors.title);
            $(formType + ' #create_error_slug').text(errors.slug);
            $(formType + ' #create_error_image').text(errors.image);
            $(formType + ' #create_error_description').text(errors.description);
        }

        function resetValidationErrorsForBenefit(formType) {
            $(formType + ' #create_error_title').text('');
            $(formType + ' #create_error_slug').text('');
            $(formType + ' #create_error_image').text('');
            $(formType + ' #create_error_description').text('');
        }


        function resetForm() {
            $('form')[1].reset();
        }


    </script>
    @include('frontendcms::merchant.benefit.scripts')
    @include('frontendcms::merchant.working_process.scripts')
    @include('frontendcms::merchant.faq.scripts')

@endpush
