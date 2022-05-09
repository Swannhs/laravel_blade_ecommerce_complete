@extends('backEnd.master')
@section('styles')
    <style>
        .form-rendered #build-wrap {
            display: none;
        }

        .render-wrap {
            display: none;
        }

        .form-rendered .render-wrap {
            display: block;
        }

        #edit-form {
            display: none;
            float: right;
        }

        .form-rendered #edit-form {
            display: block;
        }
        .cb-wrap li.disabled {
            pointer-events: none;
            opacity: .6;
            background: #eef1f6;
        }

        .form-wrap.form-builder .frmb li {
            border: 2px solid transparent;
            padding: 6px;
            box-shadow: none !important;
        }

        .form-wrap.form-builder .frmb>li:hover {
            border: 2px dashed #d6d6d6 !important;
            box-shadow: none !important;
        }
        /*a#frmb-1636541146635-fld-1-copy {*/
        /*    display: none;*/
        /*}*/
        .form-wrap.form-builder .frmb .field-actions .btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        /*.form-wrap.form-builder .frmb .field-actions .btn.copy-button{*/
        /*    display: none !important;*/
        /*}*/
        .form-wrap.form-builder .stage-wrap {
            padding: 0 20px;
        }
        .form-wrap.form-builder .frmb .legend
        {
            font-size: 18px;
            font-weight: 500;
            color: #415094;
        }
        .form-wrap.form-builder .frmb .field-label{
            font-size: 18px !important;
            font-weight: 400 !important;
            color: #415094 !important;
        }
        .form-wrap.form-builder .frmb-control li {
            font-size: 16px;
            font-weight: 400;
            color: #415094;
        }
        .save-template{
            color: white !important;
            height: 35px !important;
        }
        span.label.label-default {
            background: 0 0;
            border: 1px;
            solid: #d2d5dc;
            color: #63686f;
            font-size: 12px;
            font-weight: 400;
            padding: 0.3em 0.7em  0.3em;
            margin-left: 10px;
        }
        .form-wrap.form-builder .form-control{
            padding: 3px  12px !important;
        }
        .form-wrap.form-builder .cb-wrap.pull-left .form-actions {
            padding-top: 20px;
            float: left;
        }
        .radio{
            margin-bottom: 10px;
        }
        .form-wrap.form-builder .frmb .prev-holder input[type=number],input[type=date] {
             width: 100%!important;
        }
    </style>
@endsection

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor white-box">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{$row->name}} {{__('formBuilder.form')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div id="build-wrap"></div>

                    @if($row->id == 1 || $row->id == 2 || $row->id == 3)
                    <div class="col-lg-7 offset-lg-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="primary_input mb-15 ml-25">
                                    <label class="primary_input_label" for="term_link_input"> {{__('formBuilder.terms_page_link')}}</label>
                                    <input  class="primary_input_field"  id="term_link_input" placeholder="{{__('formBuilder.terms_page_link')}}" type="text" >
                                </div>
                                <div class="col-lg-6">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="privacy_link_input"> {{__('formBuilder.privacy_policy_page_link')}}</label>
                                        <input  class="primary_input_field"  id="privacy_link_input" placeholder="{{__('formBuilder.privacy_policy_page_link')}}" type="text" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>


            </div>

        </div>
    </section>
    <input type="hidden" value="{{route('form_builder.builder.update')}}" id="form_builder_url">
    <input type="hidden" value="{{$row->id}}" id="row_id">
@endsection


@push('scripts')
    <script src="{{asset('Modules/FormBuilder/Resources/assets/js/form-builder.min.js')}}"></script>

    <script>
        (function($) {
            "use strict";
            let _token = $('meta[name=_token]').attr('content') ;
            $(document).ready(function(){
                var buildWrap = document.getElementById('build-wrap');
                var formData = <?php
//                                    echo $formData;
                                    echo json_encode($formData) ;
                                ?> ;

                // if(formData.length){
                //     formData = formData.replace(/=\\/gm, "=''");
                // }

                var fbOptions = {
                    dataType: 'json',
                    stickyControls: {
                        enable: false,
                    },
                    disableHTMLLabels: false
                };

                if (formData && formData.length) {
                    fbOptions.formData = formData;
                }

                fbOptions.disabledActionButtons = [
                    'data',
                    'clear',

                ];
                fbOptions.disabledAttrs = [
                    'max',
                    'maxlength',
                    'min',
                    'access',
                ];

                fbOptions.disableFields = [
                    'autocomplete',
                    'button',
                ];

                fbOptions.controlPosition = 'left';

                fbOptions.controlOrder = [
                    'header',
                    'paragraph',
                    'file',
                ];


                // fbOptions.typeUserDisabledAttrs = {
                //     'checkbox': [
                //         'access',
                //         // 'className',
                //         'description',
                //         'inline',
                //         'max',
                //         'maxlength',
                //         'min',
                //         'multiple',
                //         // 'options',
                //         'other',
                //         'placeholder',
                //         'required',
                //         'rows',
                //         'step',
                //         'style',
                //         'subtype',
                //         'toggle',
                //         'value'
                //     ]
                // }

                fbOptions.typeUserEvents = {
                    'text': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'input');
                        },
                        onchange: function(fId) {
                            console.log(fId)
                        },
                    },
                    'number': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'input');
                        },
                    },
                    'email': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'input');
                        },
                    },
                    'color': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'input');
                        },
                    },
                    'date': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'input');
                        },
                    },
                    'datetime-local': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'datetime-local');
                        },
                    },
                    'select': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'select');
                        },
                    },
                    'file': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'file');
                            // set file upload field name to be always file-input
                            $(fId).find('.name-wrap .input-wrap input').val('file_input')
                            // Used in delete
                            setTimeout(function(){
                                $(fId).find('.fb-file input[type="file"]').attr('name','file_input')
                            },500);
                        },
                    },
                    'textarea': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'textarea');
                        },
                    },
                    'checkbox-group': {
                        onadd: function(fId) {
                            do_form_field_restrictions(fId, 'checkbox-group');
                        },
                    },
                }

                $(document).on('keyup','.fld-name',function (){
                    let fieldName = $(this).val();
                    checkFieldName(fieldName);

                });
                $(document).on('change','#term_link_input',function() {
                    let link = $(this).val();
                    $('.term_link_set').attr("href", link);

                });
                $(document).on('change','#privacy_link_input',function() {
                    let link = $(this).val();
                    $('.policy_link_set').attr("href", link);

                });


                var formBuilder = $(buildWrap).formBuilder(fbOptions);

                $(document).on('click','.save-template',function() {
                    var url = $('#form_builder_url').val();
                    var rowID = $('#row_id').val();
                    $(".save-template").html('Saving...')
                    $.post(url,{
                        formData:formBuilder.formData,
                        id:rowID,
                        _token:_token,
                    }).done(function(response){
                        $(".save-template").html('Save')
                        setTimeout(function() {
                            toastr.success(response.message, "Success", {
                                timeOut: 5000,
                            });
                        }, 500);
                    }).fail(function(response){
                        $(".save-template").html('Save');
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                    });
                });

                function do_form_field_restrictions(fId, type) {
                    var _field = $(fId);
                    var _preview_name;
                    var s = $('.cb-wrap .ui-sortable');

                    if (type == 'checkbox-group') {
                        _preview_name = _field.find('input[type="checkbox"]').eq(0).attr('name');
                    } else if (type == 'file') {
                        setTimeout(function() {
                            s.find('li').eq(2).addClass('disabled');
                        }, 50);
                    } else {
                        var check = _field.find('[type="'+type+'"]');
                        if(check.length == 0) {
                            check = _field.find(type);
                        }
                        _preview_name = check.attr('name');
                    }

                    if(type != 'file') {
                        var pos = _preview_name.lastIndexOf('-');
                        _preview_name = _preview_name.substr(0, pos);
                        // console.log(_preview_name);
                        $('[data-type="' + _preview_name + '"]:not(.form-field)').addClass('disabled');
                    }

                    $('.frmb-control li[type="'+_preview_name+'"]').removeClass('text-danger');

                    if(typeof(mustRequiredFields) != 'undefined' && $.inArray(_preview_name,mustRequiredFields) != -1){
                        _field.find('.required-wrap input[type="checkbox"]').prop('disabled',true);
                    }
                    setTimeout(function() {
                        s.sortable({ cancel: '.disabled' });
                        s.sortable('refresh');
                    }, 80);
                }


                function checkFieldName(fName)
                {
                    let allFieldName = [];
                    $.each($('.fld-name'),function(){
                        allFieldName.push($(this).val());
                    });
                    let time = getOccurrence(allFieldName,fName);

                    if(time > 1){
                        toastr.warning('Field Name Must Be Unique');
                        $('.save-template').prop('disabled', true).css({"opacity": 0.50,"cursor": "not-allowed"});
                    }else {
                        $('.save-template').prop('disabled', false).css({"opacity": 1,"cursor": "pointer"});
                    }
                }

                function getOccurrence(array, value) {
                    return array.filter((v) => (v === value)).length;
                }


                setTimeout(function(){
                    $(".form-builder-save" ).wrap( "<div class='btn-bottom-toolbar text-right'></div>" );
                    let btnToolbar = $('body').find('#tab_form_build .btn-bottom-toolbar');
                    btnToolbar = $('#tab_form_build').append(btnToolbar);
                    btnToolbar.find('.btn').addClass('btn-info');
                },100);

            });
        })(jQuery);

    </script>


@endpush

