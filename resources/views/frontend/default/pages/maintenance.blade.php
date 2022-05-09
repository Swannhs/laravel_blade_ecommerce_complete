@php
$sectionWidgets = \Modules\FooterSetting\Entities\FooterWidget::where('status',1)->get();
$FeatureList = \Modules\FrontendCMS\Entities\Feature::where('status',1)->get();
$subscribeContent = \Modules\FrontendCMS\Entities\SubscribeContent::firstOrFail();
$menus =
\Modules\Menu\Entities\Menu::where('menu_position','main_menu')->where('status',1)->where('has_parent',null)->orderBy('order_by')->get();
$themeColor = Modules\Appearance\Entities\ThemeColor::where('status',1)->first();
$adminColor = Modules\Appearance\Entities\AdminColor::where('is_active',1)->first();
$popupContent = \Modules\FrontendCMS\Entities\SubscribeContent::findOrFail(2);

@endphp

<!DOCTYPE html>
<html lang="en" @if(isRtl()) dir="rtl" class="rtl" @else @endif>

@include('frontend.default.partials._head')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/maintenance.css'))}}" />

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="content_box text-center">
                        <div class="banner_box">
                            <img src="{{showImage(app('general_setting')->maintenance_banner)}}" alt="">
                        </div>
                        <h2>{{app('general_setting')->maintenance_title}}</h2>
                        <h6>{{app('general_setting')->maintenance_subtitle}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('frontend.default.partials._script')
</body>

</html>
