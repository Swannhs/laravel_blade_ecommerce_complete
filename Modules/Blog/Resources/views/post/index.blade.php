@extends('backEnd.master')

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('blog.blog_list')}}</h3>
                            @if(permissionCheck('blog.posts.create'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('blog.posts.create') }}" id="add_new_btn"><i class="ti-plus"></i>{{ __('blog.add_new_blog') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table class="table" id="postTable">
                                 <thead>
                                     <tr>
                                        <th scope="col">@lang('common.sl')</th>
                                         <th scope="col">@lang('common.title')</th>
                                         <th scope="col">@lang('blog.author')</th>
                                         <th scope="col">@lang('blog.is_approved')</th>
                                         <th>@lang('common.status')</th>
                                         <th scope="col">@lang('blog.published_at')</th>
                                         <th scope="col">@lang('common.action')</th>
                                     </tr>
                                 </thead>

                             </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade admin-query" id="deleteItem" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.delete') @lang('blog.blog') @lang('blog.post')</h4>
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
                                <input type="submit" class="primary-btn fix-gr-bg" value="@lang('common.delete')"/>
                            </form>
                        </div>
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

        $(document).ready(function(){
            $('#postTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{ route('blog.post.get-data') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id' },
                        { data: 'title', name: 'title' },
                        { data: 'author', name: 'author' },
                        { data: 'approved', name: 'approved' },
                        { data: 'status', name: 'status' },
                        { data: 'published_at', name: 'published_at' },
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

            $(document).on('click', '.delete_post', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                showDeleteModal(id);
            });

            function showDeleteModal(id){
                $('#deleteItem').modal('show');
                let baseUrl = $('#url').val();
                let deleteUrl = baseUrl + '/blog/posts/' + id;
                $('#delete_form').attr('action',deleteUrl);

            }

            $(document).on('change', '.approved', function(event){
                let item = $(this).data('value');
                approvalChange(item);
            });
            function approvalChange(item) {
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', item.id);
                formData.append('is_approved', item.is_approved);
                $('#pre-loader').removeClass('d-none');

                $.ajax({
                    url: "{{ route('blog.post.approval') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                    toastr.success("{{__('common.successful')}}", "{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {

                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
            }

            $(document).on('change', '.status_change', function(){
                let item = $(this).data('value');
                statusChange(item);
            });

            function statusChange(item) {
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', item.id);
                formData.append('status', item.status);
                $('#pre-loader').removeClass('d-none');

                $.ajax({
                    url: "{{ route('blog.post.status.update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        toastr.success("{{__('common.status_change_message')}}","{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');

                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
            }
        });
    })(jQuery);


</script>
@endpush
