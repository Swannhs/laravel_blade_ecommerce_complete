@extends('backEnd.master')
@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor mt-20">
        <div class="container-fluid p-0">
            @if (isset($editData))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{ route('blog.tags.index') }}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </a>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-2">
                                    @if (isset($editData))
                                        @lang('common.edit')
                                    @else
                                        @lang('common.add')
                                    @endif
                                    @lang('blog.blog_tags')
                                </h3>
                            </div>
                            @if (isset($editData))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('blog.tags.update', $editData->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['blog.tags.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">

                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">@lang('common.name')<span
                                                        class="text-danger">*</span></label>
                                                <input name="name" class="primary_input_field name" id="name"
                                                    placeholder="@lang('common.name')" type="text" autocomplete="off"
                                                    value="{{ isset($editData) ? $editData->name : '' }}" required>
                                            </div>
                                            @if ($errors->has('name'))
                                                <span class="alert alert-warning" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">

                                    </div>
                                    @php

                                        if (permissionCheck('blog.tags.store')) {
                                            $tooltipAdd = '';
                                            $disable = '';
                                        } else {
                                            $tooltipAdd = 'You have no permission to add';
                                            $disable = 'disabled';
                                        }

                                        if (permissionCheck('blog.tags.edit')) {
                                            $tooltipUpdate = '';
                                            $disable = '';
                                        } else {
                                            $tooltipUpdate = 'You have no permission to update';
                                            $disable = 'disabled';
                                        }
                                    @endphp
                                    <div class="row mt-40">
                                        @if (isset($editData))
                                            @if (permissionCheck('blog.tags.edit'))
                                                <div class="col-lg-12 text-center tooltip-wrapper"
                                                    data-title="{{ $tooltipUpdate }}">
                                                    <button id="updateBtn" class="primary-btn fix-gr-bg tooltip-wrapper {{ $disable }}"
                                                        {{ @$disable }}>
                                                        <span class="ti-check"></span>
                                                        @lang('common.update')
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-lg-12 text-center">
                                                    <span class="alert alert-warning" role="alert">
                                                        <strong>You don't have this permission</strong>
                                                    </span>
                                                </div>
                                            @endif
                                        @else
                                            @if (permissionCheck('blog.tags.create'))
                                                <div class="col-lg-12 text-center tooltip-wrapper"
                                                    data-title="{{ $tooltipAdd }}">
                                                    <button id="add_btn" class="primary-btn fix-gr-bg tooltip-wrapper {{ $disable }}"
                                                        {{ @$disable }}>
                                                        <span class="ti-check"></span>
                                                        @lang('common.add')
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-lg-12 text-center">
                                                    <span class="alert alert-warning" role="alert">
                                                        <strong>You don't have this permission</strong>
                                                    </span>
                                                </div>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">

                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-2"> @lang('blog.blog_tags')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <div id="model_list">
                                            <table class="table" id="tagTable">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('common.sl')</th>
                                                        <th> @lang('common.name')</th>
                                                        <th width="10%"> @lang('common.action')</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade admin-query" id="deleteItem">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.delete') @lang('common.tag')</h4>
                        <button type="button" class="close"
                            data-dismiss="modal"><i class="ti-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.are_you_sure_to_delete_?')</h4>
                        </div>
                        <div
                            class="mt-40 d-flex justify-content-between">
                            <button type="button"
                                class="primary-btn tr-bg"
                                data-dismiss="modal">@lang('common.cancel')</button>
                            <form id="tag_delete_form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="primary-btn fix-gr-bg" value="@lang('common.delete')" />
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>

        (function($){
            "use strict";

            $(document).ready(function(){
                $('#tagTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{ route('blog.tag.get-data') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id' },
                        { data: 'name', name: 'name' },
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

                $(document).on('click', '.delete_tag', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    showDeleteModal(id);
                });

                function showDeleteModal(id){
                    $('#deleteItem').modal('show');
                    let baseUrl = $('#url').val();
                    let deleteUrl = baseUrl + '/blog/tags/' + id;
                    $('#tag_delete_form').attr('action',deleteUrl);
                }
            });
        })(jQuery);


    </script>
@endpush
