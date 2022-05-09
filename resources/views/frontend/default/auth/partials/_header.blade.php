<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{app('general_setting')->site_title}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{asset(asset_path(app('general_setting')->favicon))}}" type="image/png">
    <!-- Bootstrap CSS -->

    @if(isRtl())
        <link rel="stylesheet" href="{{asset(asset_path('frontend/default/compile_css/rtl_app.css'))}}" />
    @else
        <link rel="stylesheet"  href="{{asset(asset_path('frontend/default/compile_css/app.css'))}}" />
    @endif

    @section('styles')
     @show
    <!-- jquery -->
    <script src="{{ asset(asset_path('frontend/default/compile_js/app.js')) }}"></script>



    <style>
        .text-danger {
            color: #dc3545 !important;
        }
        .toast-success {
            background-color: {{ $themeColor->success_color }}!important;
        }

        .toast-error{
            background-color: {{ $themeColor->danger_color }}!important;
        }
        .toast-warning{
            background-color: {{ $themeColor->warning_color }}!important;
        }
    </style>

</head>
