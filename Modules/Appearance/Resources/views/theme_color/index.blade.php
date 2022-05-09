@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/frontend_style.css'))}}" />
<style>
    .min-height-630 {
        min-height: 630px;
    }

    #myFrame {
        -moz-transform: scale(0.80);
        -moz-transform-orgin: 0 0;
        -o-transform: scale(0.80);
        -o-transform-origin: 0 0;
        -webkit-transform: scale(0.80);
        -webkit-transform-origin: 0 0;
        position: absolute;
        height: 130%;
        width: 120%;
    }

    @media (max-width: 1440px) {
        #myFrame {
            -moz-transform: scale(0.60);
            -moz-transform-orgin: 0 0;
            -o-transform: scale(0.60);
            -o-transform-origin: 0 0;
            -webkit-transform: scale(0.60);
            -webkit-transform-origin: 0 0;
            position: absolute;
            height: 170%;
            width: 165%;
        }
    }

    @media (max-width: 780px) {
        .iframe_div{
            min-height: 900px;
        }
        #myFrame {
            width: 125%;
        }
    }
    @media (max-width: 540px) {
        .iframe_div{
            min-height: 900px;
        }
        #myFrame {
            width: 155%;
        }
    }
</style>
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100">
                        <h3 class="mb-0 mr-30"> {{ __('appearance.color') }} {{__('appearance.scheme')}} </h3>

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="white_box_50px box_shadow_white mb-40 min-height-630">
                    <form action="{{ route('appearance.themeColor.update',$themeColor->id)}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="background_color">{{__('common.select')}}
                                        {{ __('appearance.color') }} {{__('appearance.scheme')}} <span
                                            class="text-danger">*</span></label>
                                    <select id="color_theme" required class="primary_select mb-15"
                                        name="color_theme_id">
                                        @foreach ($themeColors as $color)
                                        <option @if ($themeColor->id == $color->id )
                                            selected
                                            @endif value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                        for="background_color">{{__('marketing.background_color')}} <span
                                            class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="background_color"
                                        class="form-control" name="background_color" autocomplete="off"
                                        value="{{ $themeColor->background_color }}">
                                    @error('background_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="base_color">{{__('appearance.base_color')}}
                                        <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="base_color"
                                        class="form-control" name="base_color" autocomplete="off"
                                        value="{{ $themeColor->base_color }}">
                                    @error('base_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="text_color">{{__('appearance.text')}}
                                        {{__('appearance.color')}}
                                        <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="text_color"
                                        class="form-control" name="text_color" autocomplete="off"
                                        value="{{ $themeColor->text_color }}">
                                    @error('text_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="feature_color">{{__('appearance.feature')}}
                                        {{__('appearance.area')}}
                                        {{__('appearance.color')}}
                                        <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="feature_color"
                                        class="form-control" name="feature_color" autocomplete="off"
                                        value="{{ $themeColor->feature_color }}">
                                    @error('feature_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="footer_color">{{__('appearance.footer')}}
                                        {{__('appearance.area')}}
                                        {{__('appearance.color')}}
                                        <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="footer_color"
                                        class="form-control" name="footer_color" autocomplete="off"
                                        value="{{ $themeColor->footer_color }}">
                                    @error('footer_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="navbar_color">{{__('appearance.navbar')}}
                                        {{__('appearance.area')}}
                                        {{__('appearance.color')}}
                                        <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="navbar_color"
                                        class="form-control" name="navbar_color" autocomplete="off"
                                        value="{{ $themeColor->navbar_color }}">
                                    @error('navbar_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="menu_color">{{__('appearance.menu')}}
                                        {{__('appearance.area')}}
                                        {{__('appearance.color')}}
                                        <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="menu_color"
                                        class="form-control" name="menu_color" autocomplete="off"
                                        value="{{ $themeColor->menu_color }}">
                                    @error('menu_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="border_color">{{__('appearance.border')}}
                                        {{__('appearance.color')}} <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="border_color"
                                        class="form-control" name="border_color" autocomplete="off"
                                        value="{{ $themeColor->border_color }}">
                                    @error('border_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="success_color">{{__('common.success')}}
                                        {{__('appearance.color')}} <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="success_color"
                                        class="form-control" name="success_color" autocomplete="off"
                                        value="{{ $themeColor->success_color }}">
                                    @error('success_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="warning_color">{{__('common.warning')}}
                                        {{__('appearance.color')}} <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="warning_color"
                                        class="form-control" name="warning_color" autocomplete="off"
                                        value="{{ $themeColor->warning_color }}">
                                    @error('warning_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="danger_color">{{__('common.danger')}}
                                        {{__('appearance.color')}} <span class="text-danger">*</span></label>
                                    <input required class="primary_input_field" type="color" id="danger_color"
                                        class="form-control" name="danger_color" autocomplete="off"
                                        value="{{ $themeColor->danger_color }}">
                                    @error('danger_color')
                                    <span class="text-danger" id="error_background_color">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row justify-content-center">
                            @if ($themeColor->id != 1)
                            <div class="primary_input">
                                <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                        class="ti-check"></i>{{ __('common.update') }}</button>
                            </div>
                            @endif
                            &nbsp;&nbsp;

                            @if ($themeColor->status)
                            <button class="primary-btn tr-bg" disabled href="#"
                                dusk="Add New">{{__('common.activated')}}</button>
                            @else
                            <div class="primary_input">
                                <a href="{{route('appearance.themeColor.activate',$themeColor->id)}}"
                                    class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                        class="ti-check"></i>{{ __('common.activate') }}</a>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="iframe_div">
                    <iframe id="myFrame" src="{{url('/')}}" frameborder="0"></iframe>
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
            $(document).ready(function () {
                let iframe = document.getElementById("myFrame");

                $(document).on('change','#color_theme',function(){
                    var id = $('#color_theme').val();
                    window.location = "{{ route('appearance.themeColor.index') }}?id="+id;
                });

                setColorOnSchemeChange();



                $(document).on('input', '#background_color', function(){
                    setBackgroundColor();
                });

                $(document).on('input', '#base_color', function(){
                    setBaseColor();
                });
                $(document).on('input', '#text_color', function(){
                    setTextColor();
                });
                $(document).on('input', '#feature_color', function(){
                    setFeatureColor();
                });
                $(document).on('input', '#footer_color', function(){
                    setFooterColor();
                });
                $(document).on('input', '#navbar_color', function(){
                    setNavbarColor();
                });
                $(document).on('input', '#menu_color', function(){
                   setMenuColor();
                });
                $(document).on('input', '#border_color', function(){
                    setBorderColor();
                });
            });

            function setColorOnSchemeChange(){
                setBaseColor();
                setFeatureColor();
                setBackgroundColor();
                setFooterColor();
                setNavbarColor();
                setMenuColor();
                setBorderColor();
                setTextColor();
            }


            function setFeatureColor(){
                $('#myFrame').contents().find('.project_estimate').css('background-color', $("#feature_color").val());
            }
            function setBackgroundColor(){
                $('#myFrame').contents().find('body').css('background-color', $("#background_color").val());
            }
            function setFooterColor(){
                $('#myFrame').contents().find('.footer_part').css('background-color', $("#footer_color").val());
            }
            function setNavbarColor(){
                $('#myFrame').contents().find('.header_part .main_menu').css('background-color', $("#navbar_color").val());
            }
            function setMenuColor(){
                $('#myFrame').contents().find('.side-menu').css('background-color', $("#menu_color").val());
                $('#myFrame').contents().find('.nav li a').css('background-color', $("#menu_color").val());
            }

            function setBorderColor(){
                $('#myFrame').contents().find('.category_box_input').css('border-color', $("#border_color").val());
                $('#myFrame').contents().find('.header_part .main_menu .category_box .select2-container--default .select2-selection--single').css('border', $("#border_color").val());
            }

            function setBaseColor(){
                $('#myFrame').contents().find('.input-group-append').css('background-color', $("#base_color").val());
                $('#myFrame').contents().find('.product_btn').css('background-color', $("#base_color").val());
                $('#myFrame').contents().find('.load_more_btn_homepage').css('background-color', $("#base_color").val());
                $('#myFrame').contents().find('.input-group-text').css('background-color', $("#base_color").val());
            }

            function setTextColor(){
                $('#myFrame').contents().find('h1').css('color', $("#text_color").val());
                $('#myFrame').contents().find('h2').css('color', $("#text_color").val());
                $('#myFrame').contents().find('h3').css('color', $("#text_color").val());
                $('#myFrame').contents().find('h4').css('color', $("#text_color").val());
                $('#myFrame').contents().find('h5').css('color', $("#text_color").val());
                $('#myFrame').contents().find('h6').css('color', $("#text_color").val());
                $('#myFrame').contents().find('p').css('color', $("#text_color").val());
                $('#myFrame').contents().find('a').css('color', $("#text_color").val());
                $('#myFrame').contents().find('.header_part .sub_menu .left_sub_menu .select_option a span').css('color', $("#text_color").val());
            }
    })(jQuery);
</script>
@endpush
