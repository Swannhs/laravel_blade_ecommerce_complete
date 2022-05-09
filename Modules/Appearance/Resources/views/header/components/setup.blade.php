@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/appearance/css/header_setup.css'))}}">
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">


        <div class="col-md-12 mb-20">
            <div class="">
                <div class="float-none pos_tab_btn">
                    <ul class="nav" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" href="#GeneralSeting" role="tab" data-toggle="tab" id="1"
                                aria-selected="true">{{__('marketing.general_setting')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link show" href="#Setup" role="tab" data-toggle="tab" id="2"
                                aria-selected="false">{{__('common.setup')}}</a>
                        </li>



                    </ul>
                </div>
            </div>
        </div>
    </div>



    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade active show" id="GeneralSeting">
            <div class="container-fluid p-0">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="box_header">
                            <div class="main-title d-flex justify-content-between w-100">
                                <h3 class="mb-0 mr-30">
                                    @if($header->type == 'slider')
                                    {{__('appearance.slider')}}
                                    @elseif($header->type == 'category')
                                    {{__('common.category')}}
                                    @elseif($header->type == 'product')
                                    {{__('common.product')}}
                                    @elseif($header->type == 'new_user_zone')
                                    {{__('marketing.new_user_zone')}}
                                    @endif

                                    {{ __('appearance.section_general_setting') }}</h3>

                            </div>
                        </div>
                        <div class="white_box_50px box_shadow_white mb-40 min-height-400">
                            <form method="POST" id="category_genaral_form">
                                <div class="row">
                                    <input type="hidden" name="id" value="{{$header->id}}">
                                    <input type="hidden" name="section_for" id="section_for" value="{{$header->type}}">
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('appearance.column_size')
                                                }}</label>
                                            <select name="column_size" id="column_size" class="primary_select mb-15"
                                                required="1" data-value="{{$header->column_size}}">
                                                <option disabled selected>{{ __('common.select_one') }}</option>
                                                <option {{$header->column_size == '1 column'?'selected':''}} value="1 column">{{__('appearance.1_column')}}</option>
                                                <option {{$header->column_size == '2 column'?'selected':''}} value="2 column">{{__('appearance.2_column')}}</option>
                                                <option {{$header->column_size == '3 column'?'selected':''}} value="3 column">{{__('appearance.3_column')}}</option>
                                                <option {{$header->column_size == '4 column'?'selected':''}} value="4 column">{{__('appearance.4_column')}}</option>
                                                <option {{$header->column_size == '5 column'?'selected':''}} value="5 column">{{__('appearance.5_column')}}</option>
                                                <option {{$header->column_size == '6 column'?'selected':''}} value="6 column">{{__('appearance.6_column')}}</option>
                                                <option {{$header->column_size == '7 column'?'selected':''}} value="7 column">{{__('appearance.7_column')}}</option>
                                                <option {{$header->column_size == '8 column'?'selected':''}} value="8 column">{{__('appearance.8_column')}}</option>
                                                <option {{$header->column_size == '9 column'?'selected':''}} value="9 column">{{__('appearance.9_column')}}</option>
                                                <option {{$header->column_size == '10 column'?'selected':''}} value="10 column">{{__('appearance.10_column')}}</option>
                                                <option {{$header->column_size == '11 column'?'selected':''}} value="11 column">{{__('appearance.11_column')}}</option>
                                                <option {{$header->column_size == '12 column'?'selected':''}} value="12 column">{{__('appearance.12_column')}}</option>
                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                <li>
                                                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                        <input name="is_enable" id="is_enable" value="1"
                                                            {{$header->is_enable ==1?'checked':''}}
                                                        type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p>{{ __('appearance.enable_this_section') }}</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center">
                                        <div class="d-flex justify-content-center pt_20">
                                            <button type="submit" class="primary-btn fix-gr-bg"><i class="ti-check"></i>
                                                {{ __('common.update') }}
                                            </button>
                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="iframe_div">
                            <iframe id="myFrame" src="{{url('/')}}" frameborder="0" scrolling="no"></iframe>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="Setup">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="box_header">
                            <div class="main-title d-flex justify-content-between w-100">
                                <h3 class="mb-0 mr-30">
                                    @if($header->type == 'slider')
                                    {{__('appearance.slider_section_setup')}}
                                    @elseif($header->type == 'category')
                                    {{__('appearance.category_section_setup')}}
                                    @elseif($header->type == 'product')
                                    {{__('appearance.product_section_setup')}}
                                    @endif

                                </h3>

                            </div>
                        </div>
                    </div>
                    @if($header->type == 'new_user_zone')
                    <div class="col-lg-8">
                        <div class="box_header">
                            <div class="main-title d-flex justify-content-between w-100">
                                <h3 class="mb-0 mr-30">
                                    {{__('appearance.new_user_zone_section_setup')}}

                                </h3>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="white_box_50px box_shadow_white mb-40 min-height-430">
                            <form action="POST" id="element_edit_form">
                                <div class="row">
                                    <input type="hidden" name="header_id" value="{{$header->id}}">
                                    <input type="hidden" id="header_type" value="{{$header->type}}">
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="navigation_label">
                                                {{__('marketing.navigation_label')}} <span
                                                    class="text-danger">*</span></label>
                                            <input class="primary_input_field navigation_label" type="text"
                                                name="navigation_label" id="navigation_label_id" autocomplete="off"
                                                value="{{@$header->newUserZonePanel()->navigation_label}}"
                                                placeholder="{{__('marketing.navigation_label')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="title">
                                                {{__('common.title')}} <span class="text-danger">*</span></label>
                                            <input class="primary_input_field title" type="text" name="title"
                                                autocomplete="off" id="title_id"
                                                value="{{@$header->newUserZonePanel()->title}}"
                                                placeholder="{{__('common.title')}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="pricing">
                                                {{__('frontendCms.pricing')}} <span class="text-danger">*</span></label>
                                            <input class="primary_input_field pricing" type="text" name="pricing"
                                                id="pricing_id" autocomplete="off"
                                                value="{{@$header->newUserZonePanel()->pricing}}"
                                                placeholder="{{__('frontendCms.pricing')}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('marketing.new_user_zone')
                                                }} {{__('common.list')}} <span class="text-danger">*</span></label>
                                            <select name="new_user_zone_id" id="new_user_zone_id"
                                                class="primary_select mb-15">
                                                @foreach ($ZoneLists as $key => $zone)
                                                <option {{$header->newUserZonePanel()->new_user_zone_id ==
                                                    $zone->id?'selected':''}} value="{{ $zone->id }}">{{ $zone->title }}
                                                </option>
                                                @endforeach

                                            </select>
                                            <span class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 text-center">
                                        <button class="primary_btn_2 mt-5" id="widget_form_btn"><i
                                                class="ti-check"></i>{{ __('common.update') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-5">
                        @include('appearance::header.components.create_element',['type' => $header->type])
                    </div>

                    <div class="col-md-7">
                        <div id="item_div">

                            @include('appearance::header.components.element_list')

                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    </div>
</section>
@if($header->type == 'slider')
@include('backEnd.partials._deleteModalForAjax',['item_name' => __('appearance.slider'),'modal_id' =>
'deleteSliderModal','form_id' => 'slider_delete_form','delete_item_id' => 'delete_slider_id','dataDeleteBtn'
=>'sliderDeleteBtn'])

@elseif($header->type == 'category')
@include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.category'),'modal_id' =>
'deleteCategoryModal','form_id' => 'category_delete_form','delete_item_id' => 'delete_category_id','dataDeleteBtn'
=>'categoryDeleteBtn'])

@elseif($header->type == 'product')
@include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.products'),'modal_id' =>
'deleteProductModal','form_id' => 'product_delete_form','delete_item_id' => 'delete_product_id','dataDeleteBtn'
=>'productDeleteBtn'])
@endif


@endsection

@push('scripts')
<script>
    (function($){
            "use strict";

            $(document).ready(function() {
                $(document).on('change', '#column_size', function(){
                    let form = $('#section_for').val();
                    let column_size = $(this).data('value');
                    let value = $('#column_size').val();
                    let column = '';
                    if(value == '1 column'){
                        column = 'col-xl-1 col-lg-12 col-md-12';
                    }
                    if(value == '2 column'){
                        column = 'col-xl-2 col-lg-12 col-md-12';
                    }
                    if(value == '3 column'){
                        column = 'col-xl-3 col-lg-12 col-md-12';
                    }
                    if(value == '4 column'){
                        column = 'col-xl-4 col-lg-12 col-md-12';
                    }
                    if(value == '5 column'){
                        column = 'col-xl-5 col-lg-12 col-md-12';
                    }
                    if(value == '6 column'){
                        column = 'col-xl-6 col-lg-12 col-md-12';
                    }
                    if(value == '7 column'){
                        column = 'col-xl-7 col-lg-12 col-md-12';
                    }
                    if(value == '8 column'){
                        column = 'col-xl-8 col-lg-12 col-md-12';
                    }
                    if(value == '9 column'){
                        column = 'col-xl-9 col-lg-12 col-md-12';
                    }
                    if(value == '10 column'){
                        column = 'col-xl-10 col-lg-12 col-md-12';
                    }
                    if(value == '11 column'){
                        column = 'col-xl-11 col-lg-12 col-md-12';
                    }
                    if(value == '12 column'){
                        column = 'col-xl-12 col-lg-12 col-md-12';
                    }

                    if ($('#is_enable').is(":checked")){
                        column += '';

                    }else{
                        column += ' d-none';

                    }
                    $("#myFrame").contents().find('#'+form).removeAttr('class');
                    $("#myFrame").contents().find('#'+form).attr('class',column);
                });


                $(document).on('change','#is_enable',function(event){
                        let val = 0;
                        let form = $('#section_for').val();

                        if ($('#is_enable').is(":checked")){
                            val = 1;
                            $("#myFrame").contents().find('#'+form).removeClass('d-none');
                        }else{
                            val = 0;
                            $("#myFrame").contents().find('#'+form).addClass('d-none');
                        }


                });

                $(document).on('mouseover','body',function(){
                    $('#categoryDiv').sortable({
                        cursor:"move",
                        update: function(event, ui){
                            let ids = $(this).sortable('toArray',{ attribute: 'data-id'});
                            if(ids.length > 0){
                                let data = {
                                    '_token' :'{{ csrf_token() }}',
                                    'ids' : ids,
                                    'header_id' : '{{$header->id}}'
                                }
                                $.post("{{ route('appearance.header.setup.sort-element') }}", data, function(data){

                                });
                            }
                        }
                    }).disableSelection();

                    $('#productDiv').sortable({
                        cursor:"move",
                        update: function(event, ui){
                            let ids = $(this).sortable('toArray',{ attribute: 'data-id'});
                            if(ids.length > 0){
                                let data = {
                                    '_token' :'{{ csrf_token() }}',
                                    'ids' : ids,
                                    'header_id' : '{{$header->id}}'
                                }
                                $.post("{{ route('appearance.header.setup.sort-element') }}", data, function(data){

                                });
                            }
                        }
                    }).disableSelection();

                    $('#sliderDiv').sortable({
                        cursor:"move",
                        update: function(event, ui){
                            let ids = $(this).sortable('toArray',{ attribute: 'data-id'});
                            if(ids.length > 0){
                                let data = {
                                    '_token' :'{{ csrf_token() }}',
                                    'ids' : ids,
                                    'header_id' : '{{$header->id}}'
                                }
                                $.post("{{ route('appearance.header.setup.sort-element') }}", data, function(data){

                                });
                            }
                        }
                    }).disableSelection();

                });

                $(document).on('submit', '#category_genaral_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('appearance.header.update') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}")
                            $('#pre-loader').addClass('d-none');
                            document.getElementById('myFrame').contentWindow.location.reload();
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}');
                        }
                    });
                });

                $(document).on('submit', '#add_element_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });


                    let form = $(this)[0];
                    let header_type = form.create_header_type.value;
                    formData.append('_token', "{{ csrf_token() }}");

                    if(header_type =='slider'){
                        let slider_image = $('#slider_image')[0].files[0];
                        let name = form.name.value;
                        let data_type = form.data_type.value;
                        if(slider_image){
                            formData.append('slider_image',slider_image);
                        }
                        if(slider_image && name != '' && data_type != null){

                            $.ajax({
                                url: "{{ route('appearance.header.setup.add-element') }}",
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: formData,
                                success: function(response) {
                                    toastr.success("{{__('common.added_successfully')}}")
                                    $('#pre-loader').addClass('d-none');

                                    reloadWithData(response);
                                    slider_form_reset();
                                    form.reset();

                                },
                                error: function(response) {
                                    if(response.responseJSON.error){
                                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                        $('#pre-loader').addClass('d-none');
                                        return false;
                                    }

                                    $('#pre-loader').addClass('d-none');
                                    toastr.error('{{ __("common.error_message") }}');
                                }
                            });
                        }else{
                            if(name == ''){
                                toastr.error("{{__('appearance.name_required')}}", "{{__('common.error')}}");
                            }
                            if(!slider_image){
                                toastr.error("{{__('appearance.slider_image_required')}}", "{{__('common.error')}}");
                            }
                            if(data_type == 'url' && $('#url').val() != ''){
                                toastr.error("{{__('appearance.url_is_required')}}", "{{__('common.error')}}");
                            }
                            if(data_type == null){
                                toastr.error("{{__('appearance.slider_type_is_required')}}", "{{__('common.error')}}");
                            }
                            $('#pre-loader').addClass('d-none');
                        }


                    }

                    if(header_type == 'category'){

                        let category = $('#category').val();
                        if(category.length > 0){
                            $.ajax({
                                url: "{{ route('appearance.header.setup.add-element') }}",
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: formData,
                                success: function(response) {
                                    toastr.success("{{__('common.added_successfully')}}")
                                    $('#pre-loader').addClass('d-none');
                                    reloadWithData(response);

                                    $('#category').val('');
                                    $('#category').niceSelect('update');

                                },
                                error: function(response) {
                                    if(response.responseJSON.error){
                                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                        $('#pre-loader').addClass('d-none');
                                        return false;
                                    }

                                    $('#pre-loader').addClass('d-none');
                                    toastr.error('{{ __("common.error_message") }}');
                                }
                            });
                        }else{
                            toastr.error("{{__('appearance.category_required')}}", "{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    }

                    if(header_type == 'product'){
                        let product = $('#product').val();
                        if(product.length > 0){
                            $.ajax({
                                url: "{{ route('appearance.header.setup.add-element') }}",
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: formData,
                                success: function(response) {
                                    toastr.success("{{__('common.added_successfully')}}")
                                    $('#pre-loader').addClass('d-none');
                                    reloadWithData(response);

                                    $('#product').val('');
                                    $('#product').niceSelect('update');


                                },
                                error: function(response) {

                                    if(response.responseJSON.error){
                                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                        $('#pre-loader').addClass('d-none');
                                        return false;
                                    }

                                    $('#pre-loader').addClass('d-none');
                                    toastr.error('{{ __("common.error_message") }}');
                                }
                            });
                        }else{
                            toastr.error("{{__('appearance.product_required')}}", "{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    }


                });

                $(document).on('change', '.element_list_data_type', function(event){
                    let element_list_data_type = $(this).val();
                    let data_div = $(this).data('id');

                    if(element_list_data_type != null){
                        $('#pre-loader').removeClass('d-none');
                        let data = {
                            '_token' : '{{csrf_token()}}',
                            'data_type' : element_list_data_type
                        }

                        $.post("{{route('appearance.header.get-slider-type-data')}}", data, function(response){
                            $('#pre-loader').addClass('d-none');

                            $(data_div).html(response);
                            $(data_div +' .primary_input select').niceSelect();
                        });
                    }
                });

                $(document).on('submit', '#element_edit_form', function(event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    let header_type = $(this)[0].header_type.value;

                    if(header_type == 'slider'){
                        let slider_image = $(this)[0][6].files[0];
                        if(slider_image){
                            formData.append('slider_image',slider_image);
                        }
                    }
                    if(header_type == 'new_user_zone'){
                        let new_user_zone_id = $('#new_user_zone_id').val();
                        let navigation_label_id = $('#navigation_label_id').val();
                        let title_id = $('#title_id').val();
                        let pricing_id = $('#pricing_id').val();
                        if(navigation_label_id == ''){
                            $('#pre-loader').addClass('d-none');
                            toastr.error("{{ __('appearance.navigation_label_is_required') }}");
                            return false;
                        }
                        if(title_id == ''){
                            $('#pre-loader').addClass('d-none');
                            toastr.error("{{ __('appearance.title_is_required') }}");
                            return false;
                        }

                        if(pricing_id == ''){
                            $('#pre-loader').addClass('d-none');
                            toastr.error("{{ __('appearance.priding_is_required') }}");
                            return false;
                        }
                        if(new_user_zone_id == null){
                            $('#pre-loader').addClass('d-none');
                            toastr.error("{{ __('appearance.new_user_zone_is_required') }}");
                            return false;
                        }

                    }

                    if(header_type == 'category'){

                        if(formElement.title == ''){
                            toastr.error("{{ __('appearance.navigation_field_is_required') }}");

                            return false;
                        }
                    }

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('appearance.header.setup.update-element') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}")
                            $('#pre-loader').addClass('d-none');
                            reloadWithData(response);
                        },
                        error: function(response) {

                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}');
                        }
                    });
                });

                $(document).on('submit', '#category_delete_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteCategoryModal').modal('hide');
                    let id = $('#delete_category_id').val();
                    let data = {
                        'id' : id,
                        '_token' : '{{ csrf_token() }}',
                        'header_id':'{{$header->id}}'
                    }
                    $.post("{{ route('appearance.header.setup.delete-element') }}",data, function(data){

                        toastr.success("{{__('common.deleted_successfully')}}")
                        $('#pre-loader').addClass('d-none');
                        reloadWithData(data);
                    })
                    .fail(function(response) {
                        if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                        });
                });
                $(document).on('submit', '#product_delete_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteProductModal').modal('hide');
                    let id = $('#delete_product_id').val();
                    let data = {
                        'id' : id,
                        '_token' : '{{ csrf_token() }}',
                        'header_id':'{{$header->id}}'
                    }
                    $.post("{{ route('appearance.header.setup.delete-element') }}",data, function(data){

                        toastr.success("{{__('common.deleted_successfully')}}")
                        $('#pre-loader').addClass('d-none');
                        reloadWithData(data);
                    })
                    .fail(function(response) {
                        if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }

                    });
                });

                $(document).on('submit', '#slider_delete_form', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#deleteSliderModal').modal('hide');
                    let id = $('#delete_slider_id').val();
                    let data = {
                        'id' : id,
                        '_token' : '{{ csrf_token() }}',
                        'header_id':'{{$header->id}}'
                    }
                    $.post("{{ route('appearance.header.setup.delete-element') }}",data, function(data){

                        toastr.success("{{__('common.deleted_successfully')}}")
                        $('#pre-loader').addClass('d-none');
                        reloadWithData(data);
                    })
                    .fail(function(response) {
                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                    });
                });

                $(document).on('click', '.category_delete_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    if(id != null){
                        $('#delete_category_id').val(id);
                        $('#deleteCategoryModal').modal('show');

                    }else{
                        toastr.error('{{ __("common.error_message") }}')
                    }
                });

                $(document).on('click', '.product_delete_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    if(id != null){
                        $('#delete_product_id').val(id);
                        $('#deleteProductModal').modal('show');

                    }else{
                        toastr.error('{{ __("common.error_message") }}')
                    }
                });

                $(document).on('click', '.slider_delete_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    if(id != null){
                        $('#delete_slider_id').val(id);
                        $('#deleteSliderModal').modal('show');

                    }else{
                        toastr.error('{{ __("common.error_message") }}')
                    }
                });

                $(document).on('change', '#slider_image', function(event){
                    getFileName($(this).val(),'#banner_image_file');
                    imageChangeWithFile($(this)[0],'#MetaImgDiv');
                });

                $(document).on('change', '.slider_image_edit', function(event){

                    let img_id = $(this).data('img_id');
                    let name_id = $(this).data('name_id');
                    getFileName($(this).val(),name_id);
                    imageChangeWithFile($(this)[0],img_id);
                });

                $(document).on('change', '#slider_for', function(event){
                    let data_type = $('#slider_for').val();

                    if(data_type != null){
                        $('#pre-loader').removeClass('d-none');
                        let data = {
                            '_token' : '{{csrf_token()}}',
                            'data_type' : data_type
                        }
                        $.post("{{route('appearance.header.get-slider-type-data')}}", data, function(response){
                            $('#pre-loader').addClass('d-none');
                            $('#slider_for_data_div').html(response);
                            $('.slider_drop').niceSelect();
                        });
                    }
                });


                function slider_form_reset(){

                    $('#createSliderImgDiv').html(
                        `<img id="MetaImgDiv"
                        src="{{ showImage('backend/img/default.png') }}" alt="">`
                    );

                    $('#sliderImgFileDiv').html(
                        `<div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('appearance.slider_image') }} (1920 x 500) <span class="text-danger">*</span></label>
                            <div class="primary_file_uploader">
                                <input class="primary-input" type="text" id="banner_image_file"
                                    placeholder="{{__('common.browse')}} {{__('common.image')}}" readonly="">
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                        for="slider_image">{{ __('common.browse') }} </label>
                                    <input type="file" class="d-none" name="slider_image" id="slider_image">
                                </button>
                            </div>
                        </div>

                        <span class="text-danger" id="error_slider_image"></span>`
                    );
                    $('#slider_for_data_div').empty();
                    $('#slider_data_type_div').html(

                        `
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('appearance.slider_for') }}</label>
                            <select name="data_type" id="slider_for" class="primary_select mb-15">
                                <option value="" selected disabled>Select One</option>
                                <option value="product">For Product</option>
                                <option value="category">For Category</option>
                                <option value="brand">For Brand</option>
                                <option value="tag">For Tag</option>
                                <option value="url">For URL(Not Support in Mobile APP)</option>
                            </select>
                            <span class="text-danger" id="error_slider_data_type"></span>
                        </div>
                        `
                    );
                    $('#slider_for').niceSelect();
                }

                function reloadWithData(response){
                    $('#item_div').empty();
                    $('#item_div').html(response);
                    $('.category').niceSelect();
                    $('.product').niceSelect();
                    $('.slider_drop').niceSelect();
                }


            });
        })(jQuery);


</script>
@endpush
