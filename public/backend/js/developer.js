function CRMTableThreeReactive() {
    // table.page(5).draw('page');
    if ($('.Crm_table_active3').length) {
        $('.Crm_table_active3').DataTable({
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
}

// for automatice slug create
function processSlug(value, slug_id){
    let data =  value.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
    $(slug_id).val('');
    $(slug_id).val(data);
}

function getFileName(value, placeholder){
    if (value) {
        var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
        var filename = value.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        $(placeholder).attr('placeholder', '');
        $(placeholder).attr('placeholder', filename);
    }
}

function imageChangeWithFile(input,srcId) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(srcId)
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function CRMTableTwoReactive() {
    
    if ($('.Crm_table_active2').length) {
      $('.Crm_table_active2').DataTable({
          bLengthChange: false,
          "bDestroy": false,
          language: {
              search: "<i class='ti-close'></i>",
              searchPlaceholder: trans('common.quick_search'),
              paginate: {
                  next: "<i class='ti-arrow-right'></i>",
                  previous: "<i class='ti-arrow-left'></i>"
              }
          },
          columnDefs: [{
              visible: false
          }],
          responsive: true,
          searching: false,
          paging: true,
          info: false
      });
  }
}

$("#sidebar_menu .sortable_li").sort(sort_li).appendTo('#sidebar_menu');
    var elements = $("#sidebar_menu").find("ul");
            $.each(elements, function (index, item) {
                let id_name = $(this).attr('id');
                let selector = $("#" + id_name + " > li");
                selector.sort((a, b) => $(a).data("position") - $(b).data("position")).appendTo("#" + id_name);
            });

    function sort_li(a, b) {
                let status = $(a).data('status');

                if (status != 1)
                {
                    $(a).hide();
                }

                return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;
    }
