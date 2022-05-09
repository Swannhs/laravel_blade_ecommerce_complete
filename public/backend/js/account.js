//For Account module


function hidePreloader (){
    "use strict";
    $('.preloader img').fadeOut();
    $('.preloader').fadeOut();
}

function showPreloader (){
    "use strict";
    $('.preloader img').fadeIn();
    $('.preloader').fadeIn();
}

function showFormSubmitting(form){
    "use strict";
    let submit = form.find('.submit');
    let submitting = form.find('.submitting');
    submit.hide();
    submitting.show();
    showPreloader();
}

function hideFormSubmitting(form){
    "use strict";
    hidePreloader();
    let submit = form.find('.submit');
    let submitting = form.find('.submitting');
    submit.show();
    submitting.hide();
}

function ajax_error(data) {
    "use strict";
    if (data.status === 404) {
        toastr.error("{{__('common.not_found')}}","{{__('common.error')}}");
        return;
    } else if (data.status === 500) {
       toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
        return;
    } else if (data.status === 200) {
        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
        return;
    }
    let jsonValue = $.parseJSON(data.responseText);
    let errors = jsonValue.errors;
    if (errors) {
        let i = 0;
        $.each(errors, function(key, value) {
            let first_item = Object.keys(errors)[i];
            let error_el_id = $('#' + first_item);
            if (error_el_id.length > 0) {
                error_el_id.parsley().addError('ajax', {
                    message: value,
                    updateClass: true
                });
            }
            toastr.error(value, 'Validation Error');
            i++;
        });
    } else {
        toastr.error(jsonValue.message, 'Opps!');
    }
}

function jsUcfirst(string) {
    "use strict";
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function _formValidation(form_id = 'content_form', modal = null, dataTable = null) {

    const form = $('#' + form_id);

    if (!form.length) {
        return;
    }

    form.parsley().on('field:validated', function() {
        $('.parsley-ajax').remove();
        const ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });
    form.on('submit', function(e) {
        e.preventDefault();
        $('.parsley-ajax').remove();
        showFormSubmitting(form);
        const submit_url = form.attr('action');
        const method = form.attr('method');
        //Start Ajax
        const formData = new FormData(form[0]);
        $.ajax({
            url: submit_url,
            type: method,
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                form.trigger("reset");
                form.find("input:text:visible:first").focus();
                toastr.success(data.message, 'Success');

                if (typeof(LaravelDataTables) != 'undefined' && LaravelDataTables[dataTable]){
                    LaravelDataTables[dataTable].ajax.reload();
                }

                if (modal && $(modal).length){
                    $(modal).modal('hide');
                }
                if (data.goto) {
                    window.location.href = data.goto;
                } else if(data.reload) {
                    window.location.href = '';
                }
                hideFormSubmitting(form);
            },
            error: function(data) {
                ajax_error(data);

                if (form.find("input[name='_method']").length) {
                    if (form.find("input[name='_method']").val().toLowerCase() === 'delete') {
                        $(modal).modal('hide');
                    }
                }
                hideFormSubmitting(form);
            }
        });
    });
}

function startDatatable(){
    "use strict";

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
        buttons: [
            {
                extend: 'copyHtml5',
                text: '<i class="fa fa-file"></i>',
                title : $("#logo_title").val(),
                titleAttr: 'Copy',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel"></i>',
                titleAttr: 'Excel',
                title : $("#logo_title").val(),
                margin: [10 ,10 ,10, 0],
                exportOptions: {
                    columns: ":visible",
                    columns: ':not(:last-child)',
                },

            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-excel"></i>',
                titleAttr: 'CSV',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf"></i>',
                title : $("#logo_title").val(),
                titleAttr: 'PDF',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                },
                orientation: 'landscape',
                pageSize: 'A4',
                margin: [ 0, 0, 0, 12 ],
                alignment: 'center',
                header: true,
                customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/png;base64,'+$("#logo_img").val()
                    } );
                }

            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Print',
                title : $("#logo_title").val(),
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

$(function(){
    "use strict";

    $('body').on('shown.bs.modal', '.modal', function() {
        if ($().niceSelect){
            $(this).find('.nice-select').each(function() {
                var dropdownParent = $(document.body);
                if ($(this).parents('.modal:first').length !== 0)
                    dropdownParent = $(this).parents('.modal:first');
                $(this).niceSelect();
            });
        }

        if ($().summernote){
            if ($(this).find('.summernote').length){
                $('.summernote').summernote({
                    height:200,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });
            }
        }

        if ($('.date').length > 0 && $().datepicker) {
            $('.date').datepicker({
                Default: {
                    leftArrow: '<i class="fa fa-long-arrow-left"></i>',
                    rightArrow: '<i class="fa fa-long-arrow-right"></i>'
                },
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                toggleActive: false
            });

            $(document).on('click', '.date-icon', function() {
                $(this).parent().parent().find('.date').focus();
            });
        }

        $('[data-toggle="tooltip"]').tooltip()

    });

    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        showPreloader();
        let container = '.' + $(this).data('container');
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                hidePreloader();
                $(container)
                    .html(result)
                    .modal('show');

                $(container).on('shown.bs.modal', function() {
                    $('input:text:visible:first', this).focus();
                })
            },
            error: function(data) {
                hidePreloader();
                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
            }
        });
    });

    $(document).on('click', '.delete_item', function(e) {
        e.preventDefault();
        let url = $(this).data('href');
        $('#delete_modal').modal('show');

        $('#delete_modal_form').attr('action', url);
    });

    $(document).on('change', '#chart_of_account_form #parent_id', function(){
        let val = $(this).val();
        var field =  $('#type');
        if (val){
            field.attr('disabled', true).niceSelect('update');
            $.ajax({
                url: APP_URL +'/'+'account/chart-of-accounts/'+val,
                dataType: 'json',
                success: function(data){
                    field.val(data.type);
                    field.niceSelect('update');
                }
            });
        } else{
            field.attr('disabled', false).niceSelect('update');
        }
    });

    $(document).on('change', '#payment_method', function(){
        let val = $(this).val();
        var field =  $('#bank_account_id');
        if (val === 'Bank'){
            $('#bank_column').show();
            $("label[for='bank_account_id']").addClass('required');
            field.attr('disabled', false).attr('required', true).niceSelect('update');
        } else{
            $('#bank_column').hide();
            $("label[for='bank_account_id']").removeClass('required');
            field.attr('disabled', true).attr('required', false).niceSelect('update');
        }
    });

    $(document).on('change', '.input-file', function (e){
        $(this).parent().parent().find('.input-placeholder').val(e.target.files[0].name);
    });

    if ($('.Crm_table_active3').length) {
        startDatatable();
    }

    $(document).ready(function(){
        setTimeout(function(){

        $('.dataTables_length label select').niceSelect();
        $(function() {
        $('.dataTables_length label .nice-select').addClass('dataTable_select');
        });
        $('.dataTables_length label .nice-select').on('click', function(){
        $(this).toggleClass('open_selectlist');
        })
        }, 1000);
    });
})

function amountFormat(amount){
    return amount.toFixed(2)
}
