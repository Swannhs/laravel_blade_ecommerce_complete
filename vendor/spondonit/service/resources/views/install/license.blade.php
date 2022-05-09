@extends('service::layouts.app_install', ['title' => __('service::install.license')])

@section('content')
<div class="single-report-admit">
    <div class="card-header">
        <h2 class="text-center text-uppercase color-whitesmoke" >{{ __('service::install.license_verification') }}
        </h2>

    </div>
</div>

<div class="card-body">
    <div class="requirements">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('service.license') }}" id="content_form">
                    <div class="form-group">
                        <label class="required" for="access_code">{{ __('service::install.access_code') }}</label>
                        <input type="text" class="form-control " name="access_code" id="access_code"  required="required" autofocus=""  placeholder="{{ __('service::install.access_code') }}" >
                    </div>
                    <div class="form-group">
                        <label class="required" for="envato_email">{{ __('service::install.envato_email') }}</label>
                        <input type="email" class="form-control" name="envato_email" id="envato_email" required="required" placeholder="{{ __('service::install.envato_email') }}" >
                    </div>

                    <div class="form-group">
                        <label class="required" for="installed_domain">{{ __('service::install.installed_domain') }}</label>
                        <input type="text" class="form-control" name="installed_domain" id="installed_domain" required="required" readonly value="{{ app_url() }}" >
                    </div>
                    @if($reinstall)
                   <div class="form-group">
                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12 ">
                            <input name="re_install" type="checkbox">
                            <span class="checkmark"></span>
                            <span class="ml-2">Re install System</span>
                        </label>
                    </div>
                    @endif

                   <button type="submit" class="offset-3 col-sm-6 primary-btn fix-gr-bg mt-40 submit bc-color" >{{ __('service::install.lets_go_next') }}</button>
                   <button type="button" class="offset-3 col-sm-6 primary-btn fix-gr-bg mt-40 submitting bc-color" disabled style="display:none">{{ __('service::install.submitting') }}</button>
                </form>
            </div>



        </div>
    </div>
</div>
@stop

@push('js')
    <script>
        _formValidation('content_form');
         $(document).ready(function(){
            setTimeout(function(){
                $('.preloader h2').text('We are validating your license. Please do not refresh or close the browser')
            }, 2000);
        })
    </script>
@endpush
