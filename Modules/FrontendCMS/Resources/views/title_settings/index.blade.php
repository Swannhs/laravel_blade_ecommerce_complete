@extends('backEnd.master')

@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="white_box_30px">
                <form action="{{ route('frontendcms.title_settings.update') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="box_header">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30" >{{ __('frontendCms.related_sale_setting') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{__('common.up_sale_product_display_title')}}</label>
                                <input class="primary_input_field" placeholder="{{__('common.up_sale_product_display_title')}}" type="text" id="up_sale_product_display_title" name="up_sale_product_display_title" value="{{ app('general_setting')->up_sale_product_display_title }}">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{__('common.cross_sale_product_display_title')}}</label>
                                <input class="primary_input_field" placeholder="{{__('common.cross_sale_product_display_title')}}" type="text" id="cross_sale_product_display_title" name="cross_sale_product_display_title" value="{{ app('general_setting')->cross_sale_product_display_title }}">
                            </div>
                        </div>
                    </div>
                    @if (permissionCheck('frontendcms.title_settings.update'))
                        <div class="submit_btn text-center">
                            <button class="primary_btn_2" type="submit"> <i class="ti-check" dusk="save"></i>{{ __('common.save') }}</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>

    </section>
@endsection
