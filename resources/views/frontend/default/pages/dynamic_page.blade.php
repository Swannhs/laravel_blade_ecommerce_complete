@extends('frontend.default.layouts.app')
@if($pageData->is_page_builder == 1)

@section('styles')
    @if($pageData->module == 'Affiliate')
        <link rel="stylesheet" type="text/css" href="{{asset('Modules/PageBuilder/Resources/assets/css/affiliate.css')}}">
    @endif
    <style>
        .row{
            margin: 0!important;
        }
        a:hover {
            color: var(--background_color) !important;
        }
    </style>
@endsection


@section('content')

    @php echo $pageData->description; @endphp

@endsection

@else

@section('breadcrumb')
    @php

        $arr = explode(' ',trim($pageData->title));
    @endphp
    {{$pageData->title}}
@endsection

@section('content')

    @include('frontend.default.partials._breadcrumb')

    <!-- policy part here -->
    <section class="policy_part return_part padding_top bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="policy_part_iner">
                        @php echo $pageData->description; @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- policy part end -->

@endsection

@endif
