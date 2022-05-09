<!DOCTYPE html>
<html lang="en" @if(isRtl()) dir="rtl" class="rtl" @else @endif>
    @php
    $themeColor = Modules\Appearance\Entities\ThemeColor::where('status',1)->first();
@endphp
<style>

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
</style>
@include('frontend.default.auth.partials._header')

<body>
    <input type="hidden" id="url" value="{{url('/')}}">
    @section('content')
        @show

    @include('frontend.default.auth.partials._scripts')
</body>

</html>
