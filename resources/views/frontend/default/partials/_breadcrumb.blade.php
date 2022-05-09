@php
    $actual_link = \Illuminate\Support\Facades\URL::current();
    $base_url = url('/');
@endphp
<!-- breadcrumb part here -->
<section class="breadcrumb_cs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_content d-flex justify-content-between align-items-center">
                    <h2> @yield('breadcrumb') </h2>
                    <div class="troggle_btn">
                        <label class='toggle-label'>
                            <input id="bredCumb_switch" type='checkbox' />
                            <span class='back'>
                                <span class='toggle'></span>
                                <span class='label {{$actual_link == $base_url?'on':'off'}}'>{{ __('common.home') }} </span>
                                <span class='label {{$actual_link != $base_url?'on':'off'}}'> {{isset($name)?$name:'This Page'}} </span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb part end -->
