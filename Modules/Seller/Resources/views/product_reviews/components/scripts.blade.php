@push('scripts')
    <script>

        (function($){
            "use strict";
            $(document).ready(function(){

                approveReviewDatatable();

                $(document).on('submit','#ReplyForm', function(event){
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    $('#reply_modal').modal('hide');
                    $('#error_review').text('')

                    var formElement = $(this).serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ route('seller.product-reviews.reply.store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            reloadWithData(response);
                            toastr.success("{{__('review.replied_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                            $('#pre-loader').addClass('d-none');
                            toastr.error('{{ __("common.error_message") }}','{{__("common.error")}}');
                            $('#error_review').text(response.responseJSON.errors.review)
                        }
                    });
                });

                $(document).on('click', '.reply_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    ProductReviewReply(id);
                });

                function reloadWithData(response){
                    $('#item_table').empty();
                    $('#item_table').html(response.TableData);
                    approveReviewDatatable();
                }

                function approveReviewDatatable(){
                    var url = "{{route('seller.product-reviews.get-data')}}";
                    $('#approveReviewTable').DataTable({
                        processing: true,
                        serverSide: true,
                        "ajax": ( {
                            url: url
                        }),
                        "initComplete":function(json){

                        },
                        columns: [
                            { data: 'DT_RowIndex', name: 'id' },
                            { data: 'rating', name: 'rating' },
                            { data: 'customer_feedback', name: 'customer_feedback' },
                            { data: 'customer_time', name: 'customer_time' },
                            { data: 'reply', name: 'reply' }

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

                function ProductReviewReply(id){
                    $('#pre-loader').removeClass('d-none');
                    let base_url = $('#url').val();
                    let url = base_url + '/seller/product-reviews/reply?id=' + id;
                    $.get(url, function(data) {
                        $('#replyModalDiv').empty();
                        $('#replyModalDiv').html(data);
                        $('#reply_modal').modal('show');
                        $('#pre-loader').addClass('d-none');
                    });
                }

            });
        })(jQuery);

    </script>
@endpush
