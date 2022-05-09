
@push('scripts')

<script>

    (function($){

        "use strict";

        var baseUrl = $('#app_base_url').val();

        $(document).ready(function() {
            $(document).on('submit', '#formData',function(event){
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name,element.value);
                });
                formData.append('_token',"{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('frontendcms.return-exchange.update') }}",
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        resetValidationError('#formData');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        
                        showValidationErrors('#formData',response.responseJSON.errors);
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('keyup', '#mainTitle', function(event){
                processSlug($(this).val(), '#slug');
            });

            function showValidationErrors(formType, errors){
                $(formType +' #error_mainTitle').text(errors.mainTitle);
                $(formType +' #error_slug').text(errors.slug);
                $(formType +' #error_returnTitle').text(errors.returnTitle);
                $(formType +' #error_exchangeTitle').text(errors.exchangeTitle);
                $(formType +' #error_returnDescription').text(errors.returnDescription);
                $(formType +' #error_exchangeDescription').text(errors.exchangeDescription);
            }
            function resetValidationError(formType){
                $(formType +' #error_mainTitle').text('');
                $(formType +' #error_slug').text('');
                $(formType +' #error_returnTitle').text('');
                $(formType +' #error_exchangeTitle').text('');
                $(formType +' #error_returnDescription').text('');
                $(formType +' #error_exchangeDescription').text('');
            }

        });
    })(jQuery);


</script>
@endpush
