@extends('backEnd.master')
@section('page-title', app('general_setting')->site_title)

@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0 mb-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.dashboard')}}  {{ __('appearance.color') }}</h3>
                        <ul class="d-flex">
                            <li><a class="primary-btn radius_30px mr-10 fix-gr-bg text-white"
                                    href="{{route('appearance.color.create')}}" dusk="Add New"><i
                                        class="ti-plus"></i>{{__('common.add_new')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <div class="">
                            <table id="colorTable" class="table Crm_table_active3">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.sl') }}</th>
                                        <th scope="col">{{ __('common.title') }}</th>
                                        <th scope="col">{{ __('common.type') }}</th>
                                        <th width="25%" scope="col">{{ __('appearance.color') }}</th>
                                        <th scope="col">{{ __('appearance.background') }}</th>
                                        <th scope="col">{{ __('common.status') }}</th>
                                        <th scope="col">{{ __('common.action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div class="modal fade admin-query" id="deleteItem" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.delete')</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.are_you_sure_to_delete_?')</h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                            <form id="delete_form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="primary-btn fix-gr-bg" value="">@lang('common.delete')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Activate Modal --}}
        <div class="modal fade admin-query" id="activateItem" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.activate')</h4>
                        <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.are_you_sure_to_activate')</h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                            <form id="activate_form" action="" method="POST">
                                @csrf
                                <button type="submit" class="primary-btn fix-gr-bg" value="">@lang('common.activate')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('backEnd.partials.delete_modal')
@endsection

@push('scripts')
<script>
    (function($){
            "use strict";
            $(document).ready(function(){


                $('#colorTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{ route('appearance.color.get_data') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                            { data: 'DT_RowIndex', name: 'id' },
                                { data: 'title', name: 'title' },
                                { data: 'type', name: 'type' },
                                { data: 'color', name: 'color' },
                                { data: 'background', name: 'background' },
                                { data: 'status', name: 'status' },
                                { data: 'action', name: 'action' },
                            ],

                    bLengthChange: false,
                    "order": [[ 5, "desc" ]],
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


                $(document).on('click', '.delete-item', function(event){
                    event.preventDefault();
                    let url = $(this).data('value');
                    confirm_modal(url);
                })
                $(document).on('click', '.activate_post', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                showActivateModal(id);
                });

                function showActivateModal(id){
                    $('#activateItem').modal('show');
                    let baseUrl = $('#url').val();
                    let activateUrl = baseUrl + '/appearance/color-activate/' + id;
                    $('#activate_form').attr('action',activateUrl);

                }

            });
        })(jQuery);
</script>
@endpush
