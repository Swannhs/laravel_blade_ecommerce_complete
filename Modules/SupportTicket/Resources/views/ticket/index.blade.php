@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/supportticket/css/style.css'))}}" />

@endsection
@section('mainContent')
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row justify-content-between p-3">
            <div class="bc-pages">
                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('ticket.support_ticket')}}</h3>
            </div>
            @if(permissionCheck('ticket.tickets.create'))
            <div class="bc-pages">
                <a href="{{ route('ticket.tickets.create') }}" id="add_new" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    {{__('common.add_new')}}
                </a>
            </div>
            @endif
        </div>

            <form action="{{ route('ticket.tickets.index') }}" method="get">
                <div class="white-box">
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.category') }} *</label>
                                <select name="category_id" id="category_id" class="primary_select mb-15">
                                    <option value="" selected>{{__('common.select_one')}}</option>
                                    @foreach ($CategoryList as $key => $item)
                                    <option {{isset($category_id)?$category_id == $item->id?'selected':'':''}}
                                        value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach

                                </select>
                                @if ($errors->has('category_id'))
                                <span class="text-danger"
                                    id="error_category_id">{{ $errors->first('category_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('ticket.priority') }}</label>
                                <select name="priority_id" id="priority_id" class="primary_select mb-15">
                                    <option value="" selected>{{__('common.select_one')}}</option>
                                    @foreach ($PriorityList as $key => $item)
                                    <option {{isset($priority_id)?$priority_id == $item->id?'selected':'':''}}
                                        value="{{ $item->id }}">{{ $item->name }} </option>
                                    @endforeach

                                </select>
                                @if ($errors->has('priority_id'))
                                <span class="text-danger"
                                    id="error_priority_id">{{ $errors->first('priority_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                <select name="status_id" id="status_id" class="primary_select mb-15">
                                    <option value="" selected>{{__('common.select_one')}}</option>
                                    @foreach ($StatusList as $key => $status)
                                    <option {{isset($status_id)?$status_id == $status->id?'selected':'':''}}
                                        value="{{ $status->id }}">{{ $status->name }} </option>
                                    @endforeach

                                </select>
                                @if ($errors->has('status_id'))
                                <span class="text-danger" id="error_status_id">{{ $errors->first('status_id') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 mt-20 text-right">
                            <button type="submit" id="search_btn" class="primary-btn small fix-gr-bg">
                                <span class="ti-search pr-2"></span>
                                {{__('common.search')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            @if (permissionCheck('ticket.tickets.get-data'))
            <div class="col-lg-12 mt-20 no-gutters">
                <div class="main-title">
                    <h3 class="mb-0">{{__('ticket.ticket_list')}}</h3>
                </div>
            </div>
            <div class="col-lg-12">

                <div class="row  mt-40">
                    <div class="col-lg-12">

                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">

                                <div class="">
                                    <div id="model_list">
                                        <table id="dataListTable" class="table">
                                            <thead>
                                                @if(session()->has('message-success') != "" ||
                                                session()->get('message-danger') != "")
                                                <tr>
                                                    <td colspan="7">
                                                        @if(session()->has('message-success'))
                                                        <div class="alert alert-success">
                                                            {{ session()->get('message-success') }}
                                                        </div>
                                                        @elseif(session()->has('message-danger'))
                                                        <div class="alert alert-danger">
                                                            {{ session()->get('message-danger') }}
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>

                                                    <th scope="col" width="5%">{{__('common.sl')}}</th>
                                                    <th scope="col" width="15%">{{__('ticket.subject')}}</th>
                                                    <th scope="col" width="10%">{{__('common.category')}}</th>
                                                    <th scope="col" width="15%">{{__('common.user_name')}}</th>
                                                    <th scope="col" width="10%">{{__('ticket.priority')}}</th>
                                                    <th scope="col" width="10%">{{__('ticket.user_agent')}}</th>
                                                    <th scope="col" width="10%">{{__('common.status')}}</th>
                                                    <th scope="col" width="15%">{{__('ticket.agent_asign')}}</th>
                                                    <th scope="col" width="10%">{{__('common.action')}}</th>
                                                </tr>
                                            </thead>





                                        </table>
                                        <div class="modal fade admin-query" id="deleteItem">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{__('common.delete')}}
                                                            {{__('ticket.ticket')}}</h4>
                                                        <button type="button" class="close" data-dismiss="modal"><i
                                                                class="ti-close "></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>{{__('common.are_you_sure_to_delete_?')}}</h4>
                                                        </div>
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg"
                                                                data-dismiss="modal">{{__('common.cancel')}}</button>
                                                            <form id="deleteForm"
                                                                action="{{route('ticket.tickets.destroy')}}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" id="dataId" name="id">
                                                                <input type="submit" class="primary-btn fix-gr-bg"
                                                                    value="Delete" />
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif
            <input type="hidden" name="url" id="url2"
            @if(strpos($_SERVER['REQUEST_URI'], '?' )==true) value="{{explode('?',$_SERVER['REQUEST_URI'])[1]}}" @else value="0" @endif>
        </div>
    </div>
</section>


@endsection

@push('scripts')
<script type="text/javascript">
    (function($){
        "use strict";

        $(document).ready(function(){

            $(document).on('click', '#search_btn', function(event){

                let category = $('#category_id').val();
                let priority = $('#priority_id').val();
                let status = $('#status_id').val();
                if(category == '' && priority == '' && status == ''){
                    event.preventDefault();
                    toastr.error("{{__('ticket.please_at_least_one_item')}}");
                }
            });

            var url = $('#url2').val();
            if (url == 0) {
                var new_url = "{{ route('ticket.get-data') }}";
            }else {
                var base_url = $('#url').val();
                var new_url = base_url + '/admin/ticket/search?' + url;
            }

            $('#dataListTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: new_url
                    }),
                    "initComplete":function(json){
                        $('.niceSelect').niceSelect();
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id' },
                        { data: 'subject', name: 'subject' },
                        { data: 'category', name: 'category.name' },
                        { data: 'username', name: 'username' },
                        { data: 'priority', name: 'priority.name' },
                        { data: 'assign_user', name: 'assign_user' },
                        { data: 'status', name: 'status.name' },
                        { data: 'assign_aggent', name: 'assign_aggent' },
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

            $(document).on('click', '.delete_ticket', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#deleteItem').modal('show');
                $('#dataId').val(id);
            });

        });
    })(jQuery);

</script>

@endpush
