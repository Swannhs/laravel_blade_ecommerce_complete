@extends('backEnd.master', ['title' => __('service::install.update')])

@section('mainContent')

<section class="admin-visitor-area up_admin_visitor empty_table_tab">
    <div class="container-fluid p-0">
      <div class="white-box sm_mb_20 sm2_mb_20 md_mb_20 ">
            <div class="main-title">
                <h3 class="mb-30">@lang('setting.Update')</h3>
            </div>
            <div class="card-body">
                @if(gv($product, 'current_version') == gv($product, 'next_release_version') && gv($product, 'name'))
               <div class="row">
                    <div class="col-md-12">
                        @if(gv($product, 'name'))
                        <div class="add-visitor">
                            <table class="display school-table school-table-style width-shadow">
                                <tbody>
                                    <tr>
                                        <td>Current Installed Version</td>
                                        <td>{{ gv($product, 'current_version') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Latest version</td>
                                        <td>{{ gv($product, 'next_release_version') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Release</td>
                                        <td>{{ gv($product, 'next_release_date') }}</td>
                                    </tr>

                                    <tr>
                                            <td> {{__('setting.PHP Version')}}</td>
                                            <td>{{phpversion() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('setting.Curl Enable')}}</td>
                                            <td>@php
                                                    if  (in_array  ('curl', get_loaded_extensions())) {
                                                        echo 'enable';
                                                    }
                                                    else {
                                                        echo 'disable';
                                                    }
                                                @endphp</td>
                                        </tr>


                                        <tr>
                                            <td>{{__('setting.Purchase code')}}</td>
                                            <td>{{__('Verified')}}</td>
                                        </tr>


                                        <tr>
                                            <td>{{__('setting.Install Domain')}}</td>
                                            <td>{{ config('configs')->where('key','system_domain')->first()->value }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('setting.System Activated Date')}}</td>
                                            <td>{{ config('configs')->where('key','system_activated_date')->first()->value }}</td>
                                        </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">

                            <a href="{{ url('/') }}" class="primary-btn fix-gr-bg" > Back To Home </a>



                        </div>
                        @endif
                    </div>
                </div>


                @else
                <div class="row">
                    <div class="col-md-12">
                        @if(gv($product, 'name'))
                        <div class="add-visitor">
                            <table class="display school-table school-table-style width-shadow">
                                <tbody>
                                    <tr>
                                        <td>Current Installed Version</td>
                                        <td>{{ gv($product, 'current_version') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Version Available for Upgrade</td>
                                        <td>{{ gv($product, 'next_release_version') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Release</td>
                                        <td>{{ gv($product, 'next_release_date') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Update Size</td>

                                        <td>{{bytesToSize(gv($product, 'next_release_size'))}}</td>
                                    </tr>

                                    <tr>
                                            <td> {{__('setting.PHP Version')}}</td>
                                            <td>{{phpversion() }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('setting.Curl Enable')}}</td>
                                            <td>@php
                                                    if  (in_array  ('curl', get_loaded_extensions())) {
                                                        echo 'enable';
                                                    }
                                                    else {
                                                        echo 'disable';
                                                    }
                                                @endphp</td>
                                        </tr>


                                        <tr>
                                            <td>{{__('setting.Purchase code')}}</td>
                                            <td>{{__('Verified')}}</td>
                                        </tr>


                                        <tr>
                                            <td>{{__('setting.Install Domain')}}</td>
                                            <td>{{ config('configs')->where('key','system_domain')->first()->value }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{__('setting.System Activated Date')}}</td>
                                            <td>{{ config('configs')->where('key','system_activated_date')->first()->value }}</td>
                                        </tr>
                                    @if(gv($product, 'next_release_change_log'))
                                    <tr>
                                        <td colspan="2">
                                            @php echo gv($product, 'next_release_change_log') @endphp
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">

                            <button type="button" class="primary-btn fix-gr-bg"  data-toggle="modal" data-target="#update_modal" data-modal-size="modal-md">Update</button>


                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>


<div class="modal fade admin-query" id="update_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update System</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid" >
                    <form method="POST" action="{{ route('service.download') }}" id="content_form"  class="form-horizontal">
                        <input type="hidden" name="build" value="{{ gv($product, 'next_release_build') }}">
                        <input type="hidden" name="version" value="{{ gv($product, 'next_release_version') }}">
                        <div class="row" >
                            <div class="col-lg-12">
                                @php echo $update_tips; @endphp
                            </div>
                            <div class="col-md-12" id="download_buttons">
                                <p class="text-center">Are You sure to update  <br> version {{ gv($product, 'next_release_version') }}  <br>
                                    Size of {{ bytesToSize(gv($product, 'next_release_size', 0)) }}
                                </p>
                            </div>
                             <div class="col-md-12" id="on_progress" style="display: none;">
                                <p class="text-center alert alert-danger">Don't perform any action till we are performing update!</p>

                                <p class="text-center">Update Size ({{ bytesToSize(gv($product, 'next_release_size', 0)) }}) - Updating.....</p>

                            </div>
                             <div class="col-lg-12 text-center" >
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button type="submit" class="primary-btn fix-gr-bg submit" id="update">Update</button>
                                    <button type="button" class="primary-btn fix-gr-bg submitting" style="display: none; " disabled="">Updating...</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@php

    $base_path = 'public/vendor/spondonit';

@endphp
@push('scripts')
    <script type="text/javascript" src="{{ asset($base_path . '/js/function.js') }}"></script>
<script>


    $(document).on('click', '#update', function(e) {
        e.preventDefault();
        var form = $('#content_form');
        var url = form.attr('action');


        $('#download_buttons').hide();
        $('#on_progress').show();
        form.find('.submit').hide();
        form.find('.submitting').show();
        const formData = new FormData(form[0]);
        $.ajax({
            url: url,
            method: 'POST',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            data:formData,
            success: function(data) {
                toastr.success(data.message, 'Success');
                if (data.goto) {
                    setTimeout(function() {
                        window.location.href = data.goto;
                    }, 2000);
                }
            },
            error: function(data) {
                form.find('.submit').show();
                form.find('.submitting').hide();
                 $('#on_progress').hide();
                 $('#download_buttons').show();
                ajax_error(data);
            }
        });
    });



</script>
@endpush
