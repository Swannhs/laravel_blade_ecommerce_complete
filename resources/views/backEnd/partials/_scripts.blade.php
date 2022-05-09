<script src="{{asset(asset_path('backend/js/loadah.min.js'))}}"></script>
<script>

    window._locale = '{{ app()->getLocale() }}';
    window._translations = {!! cache('translations') !!};

    window.trans = function(string, args) {

        let jsLang = $.parseJSON(window._translations[window._locale]);


        let enLang = $.parseJSON(window._translations.en);
        let value = _.get(jsLang, string);

        if(typeof value == 'undefined'){
            value = _.get(enLang, string);
        }

        _.eachRight(args, (paramVal, paramKey) => {
            value = paramVal.replace(`:${paramKey}`, value);
        });

        if(typeof value == 'undefined'){
            return string;
        }

        return value;


    }
</script>
<script src="{{asset(asset_path('backend/vendors/js/jquery-ui.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/jquery.data-tables.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/dataTables.buttons.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/buttons.flash.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/jszip.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/pdfmake.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/vfs_fonts.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/buttons.html5.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/buttons.print.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/dataTables.responsive.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/buttons.colVis.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/popper.js'))}}"></script>


@if(isRtl())
<script src="{{asset(asset_path('backend/js/bootstrap.rtl.min.js')) }}"></script>
@else
<script src="{{asset(asset_path('backend/js/bootstrap.min.js')) }}"></script>
@endif

<script src="{{asset(asset_path('backend/vendors/js/nice-select.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/jquery.magnific-popup.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/fastselect.standalone.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/raphael-min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/morris.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/ckeditor.js'))}}"></script>

<script type="text/javascript" src="{{asset(asset_path('backend/vendors/js/toastr.min.js'))}}"></script>

<script type="text/javascript" src="{{asset(asset_path('backend/vendors/js/moment.min.js'))}}"></script>

<script src="{{asset(asset_path('backend/vendors/js/bootstrap_datetimepicker.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/js/bootstrap-datepicker.min.js'))}}"></script>

<script src="{{asset(asset_path('backend/vendors/js/daterangepicker.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/tagsinput/tagsinput.js'))}}"></script>
<!-- summernote  -->
<script src="{{asset(asset_path('backend/vendors/text_editor/summernote-bs4.js'))}}"></script>

<!-- nestable  -->
<script src="{{asset(asset_path('backend/vendors/nestable/jquery.nestable.js'))}}"></script>

<script src="{{asset(asset_path('backend/vendors/chartlist/Chart.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/js/active_chart.js'))}}"></script>

<!-- metisMenu js  -->
<script src="{{asset(asset_path('backend/js/metisMenu.js'))}}"></script>

<!-- CALENDER JS  -->
<script src="{{asset(asset_path('backend/vendors/calender_js/core/main.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/calender_js/daygrid/main.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/calender_js/timegrid/main.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/calender_js/interaction/main.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/calender_js/list/main.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/calender_js/activation.js'))}}"></script>
<!-- progressbar  -->
<script src="{{asset(asset_path('backend/vendors/progressbar/circle-progress.min.js'))}}"></script>
<!-- color picker  -->
<script src="{{asset(asset_path('backend/vendors/color_picker/colorpicker.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/color_picker/activation_colorpicker.js'))}}"></script>


<script type="text/javascript" src="{{asset(asset_path('backend/js/jquery.validate.min.js'))}}"></script>
<script src="{{asset(asset_path('backend/vendors/select2/js/select2.min.js'))}}"></script>

<script src="{{asset(asset_path('backend/js/main.js'))}}"></script>

<script src="{{asset(asset_path('backend/vendors/spectrum-2.0.5/dist/spectrum.min.js'))}}"></script>

<script src="{{asset(asset_path('backend/js/developer.js'))}}"></script>

<!-- laraberg -->

<script src="{{ asset(asset_path('backend/vendors/laraberg/js/react.production.min.js')) }}"></script>
<script src="{{ asset(asset_path('backend/vendors/laraberg/js/react-dom.production.min.js')) }}"></script>
<script src="{{ asset(asset_path('backend/vendors/laraberg/js/laraberg.js')) }}"></script>

<script src="{{asset(asset_path('backend/js/parsley.min.js'))}}"></script>

<script src="{{asset(asset_path('backend/js/new_search.js'))}}"></script>
<script src="{{asset(asset_path('backend/js/sweetalert.js'))}}"></script>

@php echo Toastr::message(); @endphp



<script type="text/javascript">
    (function($){
        "use strict";

        $(document).ready(function(){

            @if(Session::has('messege'))
                let type = "{{Session::get('alert-type','info')}}";
                switch(type){
                    case 'info':
                        toastr.info("{{ Session::get('messege') }}");
                        break;
                    case 'success':
                        toastr.success("{{ Session::get('messege') }}");
                        break;
                    case 'warning':
                        toastr.warning("{{ Session::get('messege') }}");
                        break;
                    case 'error':
                        toastr.error("{{ Session::get('messege') }}");
                        break;
                }
            @endif

            var baseUrl = "{{url('/')}}";
            $.ajaxSetup({
                beforeSend: function(xhr, options) {

                    if (!(new RegExp('^(http(s)?[:]//)','i')).test(options.url)) {
                        options.url = baseUrl + options.url;
                    }
                }
            });

           $(document).on('change', '#language_select', function(){
                $('#pre-loader').removeClass('d-none');
                let lang = $(this).val();
                let data = {
                    'lang'   : lang,
                    '_token' : "{{ csrf_token() }}"
                }
                $.post("{{route('frontend.locale')}}", data, function(response){
                    $('#pre-loader').addClass('d-none');
                    toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                    location.reload(true);
                });
           });

           // for select2 multiple dropdown in send email/Sms in Individual Tab
            $("#selectStaffss").select2();
            $("#checkbox").on('click',function () {
                if ($("#checkbox").is(':checked')) {
                    $("#selectStaffss > option").prop("selected", "selected");
                    $("#selectStaffss").trigger("change");
                } else {
                    $("#selectStaffss > option").removeAttr("selected");
                    $("#selectStaffss").trigger("change");
                }
            });

            // for select2 multiple dropdown in send email/Sms in Class tab
            $("#selectSectionss").select2();
            $("#checkbox_section").on('click',function () {
                if ($("#checkbox_section").is(':checked')) {
                    $("#selectSectionss > option").prop("selected", "selected");
                    $("#selectSectionss").trigger("change");
                } else {
                    $("#selectSectionss > option").removeAttr("selected");
                    $("#selectSectionss").trigger("change");
                }
            });

            $('.close_modal').on('click', function() {
                $('.custom_notification').removeClass('open_notification');
            });
            $('.notification_icon').on('click', function() {
                $('.custom_notification').addClass('open_notification');
            });
            $(document).on('click',function(event) {
                if (!$(event.target).closest(".custom_notification").length) {
                    $("body").find(".custom_notification").removeClass("open_notification");
                }
            });


            $('#languageChange').on('change', function () {
                var str = $('#languageChange').val();
                var url = $('#url').val();
                var formData = {
                    id: $(this).val()
                };
                // get section for student
                $.ajax({
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    url: url + '/' + 'language-change',
                    success: function (data) {
                        url= url + '/' + 'locale'+ '/' + data[0].language_universal;
                        window.location.href = url;
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

            $(document).on("click", "#delete", function(e){
                e.preventDefault();
                var link = $(this).attr("href");
                swal({
                    title: "Do you Want to delete?",
                    text: "Once You Delete, This will be Permanently Deleted!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = link;
                    } else {
                        swal("Safe Data!");
                    }
                });
            });


            $("#search").focusout(function() {
                $('#livesearch').delay(500).fadeOut('slow');
            });


        });

        toastr.options = {
            newestOnTop : true,
            closeButton :true,
            progressBar : true,
            positionClass : "{{ $adminColor->toastr_position }}",
            preventDuplicates: false,
            showMethod: 'slideDown',
            timeOut : "{{ $adminColor->toastr_time }}",
        };



    })(jQuery);

</script>


@include('backEnd.partials.global_script')

@stack('scripts')
@stack('scripts_after')

