@extends('frontend.default.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/notification.css'))}}" />

@endsection
@section('breadcrumb')
{{ __('common.notifications') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
                <div class="coupons_item">
                    <div class="single_coupons_item cart_part">
                        <div class="table-responsive">
                            <table class="table table-hover red-header">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.sl') }}</th>
                                        <th scope="col">{{ __('common.title') }}</th>
                                        <th scope="col">{{ __('common.date') }}</th>
                                        <th scope="col">{{ __('common.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="cart_table_body">
                                    @foreach ($notifications as $notification)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ ucfirst($notification->title) }}</td>
                                        <td>{{ date(app('general_setting')->dateFormat->format, strtotime($notification->created_at)) }}</td>
                                        <td>

                                            @if ($notification->url != "#")
                                            <a href="{{$notification->url}}" class="btn_1 nowrap">{{__('common.view')}}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
@endpush
