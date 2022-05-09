@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('modules/product/css/product_index.css'))}}">
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">

                <div class="col-md-12 mb-20">
                    <div class="box_header_right">
                        <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                            <ul class="nav nav_list" role="tablist">
                                @if (permissionCheck('product.get-data'))
                                    <li class="nav-item">
                                        <a class="nav-link active show" href="#order_processing_data" role="tab"
                                            data-toggle="tab" id="product_list_id" aria-selected="true">{{__('product.product_list')}}</a>
                                    </li>
                                @endif
                                @if (isModuleActive('MultiVendor'))
                                    @if(permissionCheck('product.request-get-data'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#order_complete_data" role="tab" data-toggle="tab" id="product_request_id"
                                            aria-selected="true">{{__('product.seller_request_product')}}</a>
                                    </li>
                                    @endif
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="#alert_list" role="tab" data-toggle="tab" id="product_alert_id"
                                            aria-selected="true">{{__('product.alert_list')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#stock_out_list" role="tab" data-toggle="tab" id="product_stock_out_id"
                                            aria-selected="true">{{__('product.out_of_stock_list')}}</a>
                                    </li>
                                @endif


                                    <li class="nav-item">
                                        <a class="nav-link" href="#product_disabled_data" role="tab" data-toggle="tab" id="product_disabled_id"
                                            aria-selected="true">{{__('product.disabled_product_list')}}</a>
                                    </li>


                                @if (permissionCheck('product.get-data-sku'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#product_sku_data" role="tab" data-toggle="tab" id="product_sku_id"
                                            aria-selected="true">{{__('product.product_by_sku')}}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-xl-12">
                    <div class="white_box_30px mb_30">
                        <div class="tab-content">
                            @if (permissionCheck('product.get-data'))
                                <div role="tabpanel" class="tab-pane fade active show" id="order_processing_data">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.product_list') }}</h3>
                                            @if (permissionCheck('product.create'))
                                                <ul class="d-flex">
                                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route("product.create")}}"><i class="ti-plus"></i>{{__('product.add_new_product')}}</a></li>
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="product_list_div">
                                                @include('product::products.product_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (isModuleActive('MultiVendor'))
                                @if(permissionCheck('product.request-get-data'))
                                    <div role="tabpanel" class="tab-pane fade" id="order_complete_data">
                                        <div class="box_header common_table_header ">
                                            <div class="main-title d-md-flex">
                                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.seller_request_product')}}</h3>
                                            </div>
                                        </div>
                                        <div class="QA_section QA_section_heading_custom check_box_table">
                                            <div class="QA_table">
                                                <!-- table-responsive -->
                                                <div class="" id="request_product_div">
                                                    @include('product::products.request_product_list')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div role="tabpanel" class="tab-pane fade" id="alert_list">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.alert_list')}}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="alert_product_div">
                                                @include('product::products.alert_product_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="stock_out_list">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.out_of_stock_list')}}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="stockout_product_div">
                                                @include('product::products.stockout_product_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                                <div role="tabpanel" class="tab-pane fade" id="product_disabled_data">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.disabled_product_list')}}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="product_disabled_div">
                                                @include('product::products.disabled_product_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @if (permissionCheck('product.get-data-sku'))
                                <div role="tabpanel" class="tab-pane fade" id="product_sku_data">
                                    <div class="box_header common_table_header ">
                                        <div class="main-title d-md-flex">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.product_by_sku')}}</h3>
                                        </div>
                                    </div>
                                    <div class="QA_section QA_section_heading_custom check_box_table">
                                        <div class="QA_table">
                                            <!-- table-responsive -->
                                            <div class="" id="product_sku_div">
                                                @include('product::products.sku_list')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <input type="hidden" id="module_check" value="{{isModuleActive('MultiVendor')?'true':'false'}}">
    </section>
    <div class="product_detail_view_div">

    </div>
    <div id="sku_modal">
        <div class="modal fade" id="sku_edit">
            <div class="modal-dialog modal_800px modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{__('product.sku_update')}}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body sku_edit_form">

                        <form enctype="multipart/form-data" id="sku_edit_form">
                            <div class="row">

                                <input type="hidden" id="sku_id" name="id" value="">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="selling_price">{{ __('product.selling_price') }} <span class="text-danger">*</span></label>
                                        <input name="selling_price" class="primary_input_field name" id="selling_price"
                                            placeholder="{{ __('product.selling_price') }}" type="text">
                                        <span class="text-danger" id="error_selling_price"></span>
                                    </div>
                                </div>
                                <div class="col-lg-8 product_sku_img_div">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                            for="">{{ __('product.variant_image') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="variant_img_file"
                                                placeholder="{{ __('product.variant_image') }}" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                    for="variant_img">{{ __('common.browse') }} </label>
                                                <input type="file" class="d-none" name="variant_image"
                                                    id="variant_img">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 product_sku_img_div">
                                    <img id="variant_img_div"
                                        src="{{ showImage('backend/img/default.png') }}"
                                        alt="">
                                </div>

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" id="editSKUBtn" class="primary-btn semi_large2 fix-gr-bg"><i
                                                class="ti-check"></i>
                                            {{__('common.update')}}
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


@include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.product '),'form_id' =>
'product_delete_form','modal_id' => 'product_delete_modal', 'delete_item_id' => 'product_delete_id'])

@endsection
@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";

            let module_check = $('#module_check').val();
            $(document).ready(function(){
                if(module_check == 'false'){
                var columnData = [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'product_type', name: 'product_type' },
                    { data: 'brand', name: 'brand.name' },
                    { data: 'logo', name: 'logo' },
                    { data: 'stock', name: 'stock' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' }
                ]
            }else{
                var columnData = [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'product_name', name: 'product_name' },
                    { data: 'product_type', name: 'product_type' },
                    { data: 'brand', name: 'brand.name' },
                    { data: 'logo', name: 'logo' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' }
                ]
            }

            mainProductDataTable();
            requestProductDataTable();
            SKUDataTable();
            disabledProductDataTable();
            alertProductDataTable();
            stockoutProductDataTable();



            $(document).on('submit', '#sku_delete_form', function(event) {
                event.preventDefault();
                $('#sku_delete_modal').modal('hide');
                $('#pre-loader').removeClass('d-none');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());
                let id = $('#delete_item_id').val();
                $.ajax({
                    url: "{{ route('product.sku.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response);
                        toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {

                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }
                });
            });

            $(document).on('submit', '#product_delete_form', function(event) {
                event.preventDefault();
                $('#product_delete_modal').modal('hide');
                $('#pre-loader').removeClass('d-none');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#product_delete_id').val());
                $.ajax({
                    url: "{{ route('product.destroy') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if(response.msg){
                            toastr.warning(response.msg);
                        }else {
                            resetAfterChange(response);
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                        }
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }
                });
            });

            $(document).on('submit','#sku_edit_form', function(event){
                event.preventDefault();
                $("#editSKUBtn").prop('disabled', true);
                $('#editSKUBtn').text('{{ __("common.updating") }}');
                $('#pre-loader').removeClass('d-none');
                $('#error_selling_price').text('');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                let photo = $('#variant_img')[0].files[0];
                if (photo) {
                    formData.append('variant_image', photo);
                }
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('product.sku.update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response)
                        toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                        $("#editSKUBtn").prop('disabled', false);
                        $('#editSKUBtn').text('{{ __("common.update") }}');
                        $('#sku_edit').modal('hide');
                        $('#pre-loader').addClass('d-none');

                    },
                    error: function(response) {
                        $("#editSKUBtn").prop('disabled', false);
                        $('#editSKUBtn').text('{{ __("common.update") }}');
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        $('#pre-loader').addClass('d-none');
                        $('#error_selling_price').text(response.responseJSON.errors.selling_price);
                    }
                });

            });

            $(document).on('click', '.product_detail', function(event){
                event.preventDefault();
                let id = $(this).data('id');

                $('#pre-loader').removeClass('d-none');
                $.post('{{ route('product.show') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
                    console.log(data);
                    $('.product_detail_view_div').html(data);
                    $('#productDetails').modal('show');
                    $('#pre-loader').addClass('d-none');
                });
            });

            $(document).on('click', '.delete_product', function(event){
                event.preventDefault();
                let type = $(this).data('type');
                let id = $(this).data('id');
                if(type == 'admin'){
                    $('#product_delete_id').val(id);
                    $('#product_delete_modal').modal('show');
                }else{
                    $('#product_delete_id').val(id);
                    $('#product_delete_modal').modal('show');
                }
            });

            $(document).on('change', '.sku_status_change', function(event){
                let id = $(this).data('id');
                let status = 0;

                if($(this).prop('checked')){
                    status = 1;
                }
                else{
                    status = 0;
                }

                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', id);
                formData.append('status', status);

                $.ajax({
                    url: "{{ route('product.sku.status') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response);
                        toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                    }
                });
            });

            $(document).on('change', '.product_status_change', function(event){
                let id = $(this).data('id');
                let status = 0;

                if($(this).is(":checked")){
                    status = 1;
                }
                else{
                    status = 0;
                }


                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', id);
                formData.append('status', status);


                $.ajax({
                    url: "{{ route('product.update_active_status') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response);
                        toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                    },
                    error: function(response) {
                        if(response.status == '422'){
                            toastr.error("{{__('common.restricted_in_demo_mode')}}", "{{__('common.error')}}");
                        }else{
                            toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        }
                    }
                });
            });

            $(document).on('change', '.product_approve', function(event){
                let id = $(this).data('id');

                if(this.checked){
                    var is_approved = 1;
                }
                else{
                    var is_approved = 0;
                }
                $('#pre-loader').removeClass('d-none');

                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', id);
                formData.append('is_approved', is_approved);
                $.ajax({
                    url: "{{ route('product.request.approved') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response);
                        toastr.success("{{__('common.approved_successfully')}}", "{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('click', '.edit_sku', function(event){
                event.preventDefault();
                let sku = $(this).data('value');
                if(sku.product.product_type == 1){
                    $('.product_sku_img_div').addClass('d-none');
                }else{
                    $('.product_sku_img_div').removeClass('d-none');
                    if(sku.variant_image != null){
                        let variantImage="{{asset(asset_path(''))}}" + "/"+sku.variant_image;
                        $('#variant_img_div').prop("src", variantImage);
                    }
                }
                $('#sku_edit').modal('show');
                $('#sku_edit_form #sku_id').val(sku.id);
                $('#sku_edit_form #selling_price').val(sku.selling_price);
                $('#error_selling_price').text('');
            });

            $(document).on('change', '#variant_img', function(){
                getFileName($('#variant_img').val(),'#variant_img_file');
                imageChangeWithFile($(this)[0],'#variant_img_div')
            });

            $(document).on('click', '.delete_sku', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#delete_item_id').val(id);
                $('#sku_delete_modal').modal('show');
            });

            function mainProductDataTable(){
                $('#mainProductTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{route('product.get-data')}}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: columnData,

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#logo_title").val(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            orientation: 'landscape',
                            pageSize: 'A4',
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            header: true,
                            customize: function (doc) {
                                doc.content.splice(1, 0, {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    image: "data:image/png;base64," + $("#logo_img").val()
                                });
                            }

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#logo_title").val(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                            visible: false
                    }],
                        responsive: true,
                });
            }

            function disabledProductDataTable(){
                $('#disabledProductTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{route('product.get-data')}}"+'?table=disable'
                    }),
                    "initComplete":function(json){

                    },
                    columns: columnData,

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#logo_title").val(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            orientation: 'landscape',
                            pageSize: 'A4',
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            header: true,
                            customize: function (doc) {
                                doc.content.splice(1, 0, {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    image: "data:image/png;base64," + $("#logo_img").val()
                                });
                            }

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#logo_title").val(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                            visible: false
                    }],
                        responsive: true,
                });
            }

            function alertProductDataTable(){
                $('#alertProductTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{route('product.get-data')}}"+'?table=alert'
                    }),
                    "initComplete":function(json){

                    },
                    columns: columnData,

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#logo_title").val(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            orientation: 'landscape',
                            pageSize: 'A4',
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            header: true,
                            customize: function (doc) {
                                doc.content.splice(1, 0, {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    image: "data:image/png;base64," + $("#logo_img").val()
                                });
                            }

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#logo_title").val(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                            visible: false
                    }],
                        responsive: true,
                });
            }

            function stockoutProductDataTable(){

                $('#stockoutProductTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{route('product.get-data')}}"+'?table=stockout'
                    }),
                    "initComplete":function(json){

                    },
                    columns: columnData,

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#logo_title").val(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            orientation: 'landscape',
                            pageSize: 'A4',
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            header: true,
                            customize: function (doc) {
                                doc.content.splice(1, 0, {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    image: "data:image/png;base64," + $("#logo_img").val()
                                });
                            }

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#logo_title").val(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                            visible: false
                    }],
                        responsive: true,
                });
            }

            function requestProductDataTable(){
                $('#requestProductTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{route('product.request-get-data')}}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id' },
                        { data: 'product_name', name: 'product_name' },
                        { data: 'product_type', name: 'product_type' },
                        { data: 'brand', name: 'brand.name' },
                        { data: 'logo', name: 'logo' },
                        { data: 'seller', name: 'seller' },
                        { data: 'approval', name: 'approval' },
                        { data: 'action', name: 'action' }

                    ],

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#logo_title").val(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#logo_title").val(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            orientation: 'landscape',
                            pageSize: 'A4',
                            margin: [0, 0, 0, 12],
                            alignment: 'center',
                            header: true,
                            customize: function (doc) {
                                doc.content.splice(1, 0, {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    image: "data:image/png;base64," + $("#logo_img").val()
                                });
                            }

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#logo_title").val(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                        ],
                    columnDefs: [{
                            visible: false
                    }],
                        responsive: true,
                });
            }

            function SKUDataTable(){
                $('#SKUTable').DataTable({
                processing: true,
                serverSide: true,
                "ajax": ( {
                    url: "{{route('product.get-data-sku')}}"
                }),
                "initComplete":function(json){

                },
                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'product', name: 'product.product_name' },
                    { data: 'brand', name: 'product.brand.name' },
                    { data: 'purchase_price', name: 'purchase_price' },
                    { data: 'selling_price', name: 'selling_price' },
                    { data: 'logo', name: 'logo' },
                    { data: 'action', name: 'action' }
                ],

                bLengthChange: false,
                "bDestroy": true,
                language: {
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: trans('common.quick_search'),
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>"
                    }
                },
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-files-o"></i>',
                    title: $("#logo_title").val(),
                    titleAttr: 'Copy',
                    exportOptions: {
                        columns: ':visible',
                        columns: ':not(:last-child)',
                    }
                },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Excel',
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },

                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: 'CSV',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: 'PDF',
                        exportOptions: {
                            columns: ':visible',
                            columns: ':not(:last-child)',
                        },
                        orientation: 'landscape',
                        pageSize: 'A4',
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        header: true,
                        customize: function (doc) {
                            doc.content.splice(1, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                image: "data:image/png;base64," + $("#logo_img").val()
                            });
                        }

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: 'Print',
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':not(:last-child)',
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ['colvisRestore']
                    }
                ],
                    columnDefs: [{
                        visible: false
                    }],
                    responsive: true,
                });
            }

            function resetAfterChange(response) {
                $('#product_list_div').empty();
                $('#product_list_div').html(response.ProductList);
                $('#request_product_div').empty();
                $('#request_product_div').html(response.RequestProductList);
                $('#product_sku_div').empty();
                $('#product_sku_div').html(response.ProductSKUList);
                $('#product_disabled_div').empty();
                $('#product_disabled_div').html(response.ProductDisabledList);
                $('#product_alert_div').empty();
                $('#product_alert_div').html(response.ProductAlertList);

                mainProductDataTable();
                requestProductDataTable();
                SKUDataTable();
                disabledProductDataTable();
                alertProductDataTable();
                stockoutProductDataTable();
            }

            function productDeleteModal(id){
                $('#product_delete_id').val(id);
                $('#product_delete_modal').modal('show');
            }

        });

        })(jQuery);


    </script>
@endpush
