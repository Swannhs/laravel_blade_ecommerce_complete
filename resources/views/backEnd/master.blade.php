<!DOCTYPE html>
<html dir="{{isRtl()?'rtl':''}}" class="{{isRtl()?'rtl':''}}">

@php
$adminColor = Modules\Appearance\Entities\AdminColor::where('is_active',1)->first();


if(Auth::user()->role->type == "superadmin"){
    $notifications = Modules\OrderManage\Entities\CustomerNotification::where('super_admin_read_status',0)->where(function($query){
        $query->whereNotNull('seller_id')
                ->orWhere('customer_id',Auth::id());
            })->get();
}else{
    $notifications= Modules\OrderManage\Entities\CustomerNotification::where('read_status',0)
    ->where(function($query){
        $query->where('seller_id',Auth::id())
                ->orWhere('customer_id',Auth::id());
    })->get();
}

if($adminColor->background_type == "image"){
    $background = "url(".asset(asset_path($adminColor->background_image)).") no-repeat center";
}else{
    $background = $adminColor->background_color;
}
if($adminColor->color_mode == "solid"){
    $gradient1 = $adminColor->solid_color;
    $gradient2 = $adminColor->solid_color;
    $gradient3 = $adminColor->solid_color;
}else{
    $gradient1 = $adminColor->gradient_color_one;
    $gradient2 = $adminColor->gradient_color_two;
    $gradient3 = $adminColor->gradient_color_three;
}
@endphp
<style>

    :root {
    --background: {{ $background }};
    --base_color: {{ $adminColor->base_color }};

    --gradient_1: {{ $gradient1 }};
    --gradient_2: {{ $gradient2 }};
    --gradient_3: {{ $gradient3 }};
    --text-color: {{ $adminColor->text_color }};
    --border_color: {{ $adminColor->border_color }};
    --scroll_color: {{ $adminColor->scroll_color }};
    --bg_white: {{ $adminColor->background_white }};

    --bg_black: {{ $adminColor->background_black }};
    --input__bg: {{  $adminColor->input_background  }};
    --text_white: {{ $adminColor->text_white }};
    --text_black: {{ $adminColor->text_black }};
    --success: {{ $adminColor->success_color }};
    --danger: {{ $adminColor->danger_color }};
    --warning: {{ $adminColor->warning_color }};
    }
</style>

@include('backEnd.partials._header')

<body class="admin">

    {{-- loader --}}
    <div id="pre-loader" class="d-none">
        <div class="loader">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
    </div>

    <input type="hidden" id="url" value="{{url('/')}}">

    <div class="main-wrapper min_height_600">
        <!-- Sidebar  -->
        @if(isModuleActive('Affiliate') && auth()->user()->role->type == 'affiliate' || isModuleActive('Affiliate') && auth()->user()->role->type == 'customer')
            @include('affiliate::_sidebar')
        @else
            @include('backEnd.partials._sidebar')
        @endif

        <!-- Page Content  -->
        <div id="main-content">
            @include('backEnd.partials._menu')


            @section('mainContent')
            @show
            @include('backEnd.partials._invoice_modal')
        </div>

    </div>


    @include('backEnd.partials._footer')

    @include('backEnd.partials._modal')

    @include('backEnd.partials._scripts')

</body>

</html>
