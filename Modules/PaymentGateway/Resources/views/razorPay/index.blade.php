<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isRtl())
        <link rel="stylesheet" href="{{ asset(asset_path('backend/css/rtl/bootstrap.rtl.min.css')) }}" />
    @else
        <link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/bootstrap.min.css')) }}" />
    @endif
    <script src="{{ asset(asset_path('backend/vendors/js/jquery-3.6.0.min.js')) }}"></script>
	@if(isRtl())
        <script src="{{asset(asset_path('backend/js/bootstrap.rtl.min.js')) }}"></script>
    @else
        <script src="{{asset(asset_path('backend/js/bootstrap.min.js')) }}"></script>
    @endif
    @yield('style')
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ __('common.error') }}!</strong> {{ $message }}
                </div>
            @endif
            @php echo Session::forget('error'); @endphp
            @if($message = Session::get('success'))
                <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ __('common.success') }}!</strong> {{ $message }}
                </div>
            @endif
            @php echo Session::forget('success'); @endphp
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <form action="{{route('razorpay.payment')}}" method="POST" >
                        <!-- Note that the amount is in paise = 50 INR -->
                        <!--amount need to be in paisa-->
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ env("RAZOR_KEY") }}"
                                data-amount="1000"
                                data-buttontext="Pay 10 INR"
                                data-name="Laravelcode"
                                data-description="Order Value"
                                data-image="{{asset(asset_path(app('general_setting')->logo)) }}"
                                data-prefill.name="name"
                                data-prefill.email="email"
                                data-theme.color="#ff7529">
                        </script>
                        <input type="hidden" name="_token" value="@php echo csrf_token(); @endphp">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
