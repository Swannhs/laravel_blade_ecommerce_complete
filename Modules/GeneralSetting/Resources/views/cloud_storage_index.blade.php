@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center white-box">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(isModuleActive('AmazonS3'))
                            @include('amazons3::setting')
                    @endif

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
                file_storage_form();

                $(document).on('change','.file_storage', function(){
                    file_storage_form();
                });

                function file_storage_form(){
                    let file_storage_type = $('.file_storage:checked').data("type");
                    let aws3Div = $('#aws3_host_div');
                    if (file_storage_type === 'AmazonS3') {
                        aws3Div.show();
                        let hiddenInput = $('<input>').attr({
                            type: 'hidden',
                            id: 'aws3_hidden_field',
                            name: 'aws3',
                            value: 1
                        })
                        hiddenInput.appendTo('#aws3_hidden_div');
                    }
                    else{
                        aws3Div.hide();
                        $('#aws3_hidden_div').html('');
                    }
                }
            });
        })(jQuery);

    </script>
@endpush
