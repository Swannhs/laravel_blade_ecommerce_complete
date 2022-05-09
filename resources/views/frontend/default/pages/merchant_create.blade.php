@extends('frontend.default.auth.layouts.app')
@section('content')
    <section class="pricing_part padding_top bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section_tittle">
                        <h2>{{$content->sellerRegistrationTitle}}</h2>
                        @php echo $content->sellerRegistrationDescription; @endphp
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($commissions as $key => $commission)
                    <div class="col-lg-4 col-md-6">
                        <div class="single_pricing_part @if ($commission->id == 1) product_tricker @endif">
                            @if ($commission->id == 1)
                                <span class="product_tricker_text">Best Value</span>
                            @endif
                            <div class="pricing_header">
                                <h5>{{ $commission->name }}</h5>
                                <h2>{{ single_price($commission->rate) }}</h2>
                                <p>{{ $commission->description }}</p>
                            </div>
                            <a href="{{ route('frontend.merchant-register', base64_encode($commission->id)) }}" class="btn_2">{{ __('defaultTheme.choose_plan') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            $(document).on('click','#termCheck',function(event){

                if($("#termCheck").prop('checked') == true){
                    //do something
                    $('#submitBtn').prop('disabled', false);
                }else{
                    $('#submitBtn').prop('disabled', true);
                }

            });
        });
    })(jQuery);
</script>
@endpush
