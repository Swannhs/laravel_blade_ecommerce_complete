@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{$data->mainTitle}}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<section class="return_part padding_top bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="single_return_part">
                    <h5>{{$data->returnTitle}}</h5>
                    @php echo $data->returnDescription; @endphp
                    <a href="{{url('/contact-us')}}" class="btn_1">{{ __('common.contact_us') }}</a>
                </div>
                <div class="exchange_part">
                    <h5>{{$data->exchangeTitle}}</h5>
                    @php echo $data->exchangeDescription; @endphp
                    <a href="{{url('/contact-us')}}" class="btn_2">{{ __('common.contact_us') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
