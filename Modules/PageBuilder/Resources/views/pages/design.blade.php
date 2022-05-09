<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Page Builder</title>
    <link rel="icon" href="{{asset(asset_path(app('general_setting')->favicon))}}" type="image/png">
{{--    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/bootstrap-3.4.1/css/bootstrap.min.css" data-type="keditor-style" />--}}
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/css/keditor.css" data-type="keditor-style" />
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/css/keditor-components.css" data-type="keditor-style" />
<!-- End of KEditor styles -->
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/code-prettify/src/prettify.css" />
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/css/examples.css" />
    @php
        $themeColor = Modules\Appearance\Entities\ThemeColor::where('status',1)->first();
    @endphp
    <style data-type="keditor-style">
        :root {
            --background_color : {{ $themeColor->background_color }};
            --base_color : {{ $themeColor->base_color }};
            --text_color : {{ $themeColor->text_color }};
            --feature_color : {{ $themeColor->feature_color }};
            --footer_color : {{ $themeColor->footer_color }};
            --navbar_color : {{ $themeColor->navbar_color }};
            --menu_color : {{ $themeColor->menu_color }};
            --border_color : {{ $themeColor->border_color }};
            --success_color : {{ $themeColor->success_color }};
            --warning_color : {{ $themeColor->warning_color }};
            --danger_color : {{ $themeColor->danger_color }};
        }
        .default_select{
            color: var(--text_color);
            border-color: var(--border_color);
            width: 100%;
            font-weight: 300;
        }
        .keditor-topbar {
            font: 14px/1.42857143 Helvetica Neue,Helvetica,Arial,sans-serif;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background: #1b1d27;
            display: flex!important;
        }

        div.cke_float[id*=cke_keditor-ui-] {
            top: 50px!important;
        }
        .keditor-content-area-inner{
            margin-top: 30px!important;
        }
        a:hover {
            color: var(--background_color) !important;
        }
    </style>
    <link rel="stylesheet" data-type="keditor-style" href="{{asset(asset_path('frontend/default/compile_css/app.css'))}}" />
    <link rel="stylesheet" data-type="keditor-style" href="{{asset('Modules/PageBuilder/Resources/assets/css/affiliate.css')}}">
    <link rel="stylesheet"  href="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/font-awesome-4.7.0/css/font-awesome.min.css" data-type="keditor-style" />


</head>

<body>
<div data-keditor="html">
    <div id="content-area">
        {!! $row->description !!}
    </div>

</div>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/jquery-1.11.3/jquery-1.11.3.min.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/bootstrap-3.4.1/js/bootstrap.min.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/ckeditor-4.11.4/ckeditor.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/formBuilder-2.5.3/form-builder.min.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/formBuilder-2.5.3/form-render.min.js"></script>
<!-- Start of KEditor scripts -->
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/js/keditor.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/dist/js/keditor-components.js"></script>
<!-- End of KEditor scripts -->
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/code-prettify/src/prettify.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/js-beautify-1.7.5/js/lib/beautify.js"></script>
<script  src="{{asset('Modules/PageBuilder/Resources/assets')}}/keditor/plugins/js-beautify-1.7.5/js/lib/beautify-html.js"></script>
<script  data-keditor="script">
    $(function () {
        $('#content-area').keditor({
            snippetsUrl: '{{route('page_builder.snippet')}}',
            title: 'Design {{$row->title}} Page',

            extraTopbarItems: {
                pageSetting: {
                    html: '<a href="{{route('page_builder.pages.index')}}" title="Back" class="btn-page-setting" data-extra-setting="pageSetting"><i class="fa fa-fw fa-arrow-left"></i></a>'
                }
            },
            onSave: function (content) {
                var url = '{{ route("page_builder.pages.design.update",":id") }}';
                url = url.replace(':id', {{$row->id}});
                $.ajax({
                    url: url,
                    type: "PUT",
                    data: {
                        'body': content,
                        _token: "{{csrf_token()}}"
                    },
                    success: function (data) {
                        location.reload();
                    }
                });
            },
        });
    });

</script>
</body>
</html>


