@extends('backEnd.master')
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                        <div class="col-12">
                            @include('generalsetting::page_components.smtp_setting')
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";

            $(document).ready(function() {
                smtp_form();
                $('.summernote').summernote({
                    placeholder: '',
                    tabsize: 2,
                    height: 500,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                $(document).on('change','.mail_gateway', function(){
                    smtp_form();
                });
                function smtp_form(){
                    var mail_mailer = $('.mail_gateway:checked').val();
                    if (mail_mailer == 'smtp') {
                        $('#sendmail').hide();
                        $('#smtp').show();
                    }
                    else if (mail_mailer == 'sendmail') {
                        $('#smtp').hide();
                        $('#sendmail').show();
                    }
                }
            });
        })(jQuery);

    </script>
@endpush
