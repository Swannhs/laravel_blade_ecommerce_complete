<head>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="{{asset(asset_path(app('general_setting')->favicon))}}" type="image/png" />
    <title id="header_title">@yield('page-title', app('general_setting')->site_title)</title>
    <meta name="_token" content="@php echo csrf_token(); @endphp" />
    @laravelPWA
    <!-- Bootstrap CSS -->
    @if(isRtl())
        <link rel="stylesheet" href="{{ asset(asset_path('backend/css/rtl/bootstrap.rtl.min.css')) }}" />
    @else
        <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/bootstrap.min.css')) }}" />
    @endif
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/jquery-ui.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/jquery.data-tables.css')) }}">
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/buttons.dataTables.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/rowReorder.dataTables.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/responsive.dataTables.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/bootstrap-datepicker.min.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/bootstrap-datetimepicker.min.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/daterangepicker.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/font_awesome/css/all.min.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/text_editor/summernote-bs4.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('backend/vendors/themefy_icon/themify-icons.css'))}}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/flaticon.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/fnt.min.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/nice-select.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/magnific-popup.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/fastselect.min.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/toastr.min.css')) }}" />
    <link rel="stylesheet" href="{{asset(asset_path('backend/vendors/select2/css/select2.min.css'))}}" />

    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/calender_js/core/main.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/calender_js/daygrid/main.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/calender_js/timegrid/main.css')) }}" />
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/calender_js/list/main.css')) }}" />
    <!-- color picker  -->
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/colorpicker.min.css')) }}" />

    {{-- metsimenu --}}
    <link rel="stylesheet" href="{{ asset(asset_path('backend/css/metisMenu.css')) }}" />

    <link rel="stylesheet" href="{{ asset(asset_path('backend/css/loade.css')) }}" />

    @if(isRtl())
        <link rel="stylesheet" href="{{asset(asset_path('backend/css/rtl/style.css'))}}" />
        <link rel="stylesheet" href="{{asset(asset_path('backend/css/rtl/infix.css'))}}" />
    @else

        @if ($adminColor->id == 1)
            <link rel="stylesheet" href="{{ asset(asset_path('backend/css/backend_static_style.css')) }}" />
        @else
            <link rel="stylesheet" href="{{ asset(asset_path('backend/css/backend_style.css')) }}" />
        @endif
        <link rel="stylesheet" href="{{ asset(asset_path('backend/css/infix.css')) }}" />

    @endif

    @if ($adminColor->id == 1)
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/vendors_static_style.css')) }}" />
    @else
    <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/vendors_style.css')) }}" />
    @endif

    <link rel="stylesheet" type="text/css" href="{{ asset(asset_path('backend/vendors/spectrum-2.0.5/dist/spectrum.min.css')) }}">
    <!-- laraberg -->
    <link rel="stylesheet" href="{{asset(asset_path('backend/vendors/laraberg/css/laraberg.css'))}}">
    <link rel="stylesheet" href="{{asset(asset_path('backend/css/parsley.css'))}}" />


    <link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_global.css'))}}" />
    <style>
        /* for toastr dynamic start*/
        .toast-success {
            background-color: {{ $adminColor->success_color }}!important;
        }

        .toast-message {
            color: {{ $adminColor->text_white }};
        }

        .toast-title {
            color: {{$adminColor->text_white}};

        }

        .toast {
            color: {{ $adminColor->text_white }};
        }

        .toast-error {
            background-color: {{$adminColor->danger_color}}!important;
        }

        .toast-warning {
            background-color: {{$adminColor->warning_color}}!important;
        }
    </style>
    @if(isRtl())
        <style>
            .demo_addons{
                float: left!important;
                margin-left: 30px!important;
            }    
        </style>
    @endif
    

    @section('styles')
    @show
    <!-- jquery -->
    <script src="{{ asset(asset_path('backend/vendors/js/jquery-3.6.0.min.js')) }}"></script>

</head>
