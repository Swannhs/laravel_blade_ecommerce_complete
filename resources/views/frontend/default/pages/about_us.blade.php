@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{$content->mainTitle}}
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/about_us.css'))}}" />

@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')


<!-- about us part here -->
<section class="about_us bg-white padding_top">
    <div class="container">
        <div class="row align-items-center justify-content-around">
            <div class="col-lg-4 col-md-6">
                <div class="about_content">
                    <h2>{{$content->subTitle}}</h2>
                    @php echo $content->mainDescription; @endphp
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="about_img">
                    <img src="{{showImage($content->sec1_image)}}" alt="#" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about us part end -->

<!-- Benefits part -->
<section class="benefits_content padding_top bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section_tittle">
                    <h2>{{$content->benifitTitle}}</h2>
                    @php echo $content->benifitDescription @endphp
                </div>
            </div>
        </div>
        <div class="row">

            @foreach($benefitList as $key => $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="single_benefits_content">
                        <div class="benefit_img_div">
                            <img src="{{showImage($item->image) }}" alt="#">
                        </div>
                        <h4>{{ $item->title }}</h4>

                        <p>{{$item->description}}</p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<!-- Benefits part end -->

<!-- about us part here -->
<section class="about_details bg-white padding_top">
    <div class="container">
        <div class="row align-items-center justify-content-around">
            <div class="col-lg-5 col-md-6">
                <div class="about_img">
                    <img src="{{showImage($content->sec2_image)}}" alt="#" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="about_content">
                    <h2>{{$content->subTitle}}</h2>
                    @php echo $content->mainDescription; @endphp
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about us part end -->

<!-- marcent top content -->
@if(isModuleActive('MultiVendor'))
<section class="marcent_content padding_top bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="marcent_content_iner">
                    <h5>{{$content->sellingTitle}}</h5>
                    @php echo $content->sellingDescription; @endphp
                    <a href="{{url('/merchant')}}" class="btn_1">{{__('defaultTheme.become a merchant')}}</a>
                    <span>{{$content->price}}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- marcent top content end -->


@endsection
