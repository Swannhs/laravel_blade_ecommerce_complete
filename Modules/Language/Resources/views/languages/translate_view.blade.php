@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/language/css/style.css'))}}" />
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
                <div class="col-lg-4 mb_30 col-md-4">
                    <div class="box_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0" >{{ $language->name }} {{ __('language.translation') }} </h3>
                        </div>
                    </div>
                    <div class="white-box">
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" name="id" id="id" value="{{ $language->id }}">
                                <div class="primary_input mb_15">
                                    <label class="primary_input_label" for=""> {{ __('common.choose_file') }}</label>
                                    <select name="file_name" id="file_name" class="primary_select mb-15">
                                        
                                        @foreach ( $files as $key => $value)
                                            @if ( $key > 1 )
                                                <option value="{{ $value }}"
                                                        @if ($key == 2) selected @endif>{{ substr($value, 0, -4) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 mt-50" id="translate_form">
                    <div class="row justify-content-center mt-30 demo_wait">
                        <svg version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                            <circle fill="#7c32ff" stroke="none" cx="6" cy="50" r="6">
                                <animate
                                    attributeName="opacity"
                                    dur="1s"
                                    values="0;1;0"
                                    repeatCount="indefinite"
                                    begin="0.1"/>
                            </circle>
                            <circle fill="#7c32ff" stroke="none" cx="26" cy="50" r="6">
                                <animate
                                    attributeName="opacity"
                                    dur="1s"
                                    values="0;1;0"
                                    repeatCount="indefinite"
                                    begin="0.2"/>
                            </circle>
                            <circle fill="#7c32ff" stroke="none" cx="46" cy="50" r="6">
                                <animate
                                    attributeName="opacity"
                                    dur="1s"
                                    values="0;1;0"
                                    repeatCount="indefinite"
                                    begin="0.3"/>
                            </circle>
                        </svg>

                    </div>
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

            $(document).ready(function(){
                getTranslateFile();

                $(document).on('change', '#file_name', function(){
                    $('#pre-loader').removeClass('d-none');
                    getTranslateFile();

                });

                function getTranslateFile(){

                    var file_name = $('#file_name').val();
                    var id = $('#id').val();
                    $.post("{{ route('language.get_translate_file') }}", {_token:'{{ csrf_token() }}', file_name:file_name, id:id}, function(data){
                        $('#translate_form').html(data);
                        $('#pre-loader').addClass('d-none');
                    });
                }

            });
        })(jQuery);

    </script>
@endpush
