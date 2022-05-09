@extends('frontend.default.layouts.app')

@section('breadcrumb')
    {{$content->mainTitle}}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/marchant.css'))}}" />


@endsection

@section('content')

@include('frontend.default.partials._breadcrumb',['name'=> __('common.merchants')])
    <!-- marcent top content -->
    <section class="marcent_content padding_top bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="marcent_content_iner">
                        <h5>{{$content->subTitle}}</h5>
                        @php echo $content->Maindescription; @endphp
                        <a href="#register" class="btn_1">{{__('defaultTheme.become a merchant')}}</a>
                        <span>{{$content->pricing}}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- marcent top content end -->

    <!-- Benefits part -->
    <section class="benefits_content padding_top bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="section_tittle">
                        <h2>{{$content->benifitTitle}}</h2>
                        @php echo $content->benifitDescription; @endphp
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

    <!-- work process part here -->
    <section class="work_process padding_top bg-white">
      <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section_tittle">
                <h2>{{$content->howitworkTitle}}</h2>
                    @php echo $content->howitworkDescription; @endphp
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-10">

            <div id="timeline">


                @foreach($workProcessList as $key => $item)
                    <div class="timeline-item">
                        <div class="timeline-content work_process_single {{$item->position == 1 ? 'left_float':'right_float'}}">
                            <div class="work_img_div">
                                <img src="{{showImage($item->image)}}" alt="#">
                            </div>
                            <h4>{{ $item->title }}</h4>
                            @php echo $item->description; @endphp
                        </div>
                    </div>
                @endforeach

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- work process part end -->

    <!-- Benefits part -->
    <section class="pricing_part padding_top bg-white"  id="register">
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
                                <h2>
                                    @if ($commission->id == 1)
                                    {{ single_price($commission->rate) }}
                                    @endif
                                </h2>
                                <p>{{ $commission->description }}</p>
                            </div>
                            <a href="{{ route('frontend.merchant-register', base64_encode($commission->id)) }}" class="btn_2">{{ __('defaultTheme.choose_plan') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Benefits part end -->

    <!-- accordion part here -->
    <section class="ferquently_question_part section_padding">
      <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="section_tittle">
                <h2>{{$content->faqTitle}}</h2>
                    @php echo $content->faqDescription; @endphp
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-10 col-xl-6">
            <div class="ferquently_question_iner">

              @foreach($faqList as $key => $item)
              <div class="single_ferquently_question">
              <button class="accordion">{{$item->title}}</button>
                  <div class="panel">
                  <p>{{$item->description}}</p>
                  </div>
              </div>
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- accordion part end -->

    <!-- send query part here -->
    <section class="send_query section_padding">
      <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_tittle">
                    <h2>{{ $content->queryTitle }}</h2>
                    @php echo $content->queryDescription @endphp
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-10 col-xl-8">
            <form action="#" id="contactForm" name="#" class="send_query_form">

              <div class="form-group">
                <label for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" placeholder="{{__('defaultTheme.enter_name')}}" class="form-control">
                <span class="text-danger"  id="error_name"></span>
            </div>

            <div class="form-group">
                <label for="email">{{__('defaultTheme.email_address')}} <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" placeholder="{{__('defaultTheme.enter_email_address')}}" class="form-control">
                <span class="text-danger"  id="error_email"></span>
            </div>
            <div class="form-group">
                <label for="query_type">{{__('defaultTheme.inquery_type')}} <span class="text-danger">*</span></label>
                <select name="query_type" id="query_type" class="form-control nc_select">
                    @foreach($QueryList as $key => $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>

            </div>
            <span class="text-danger"  id="error_query_type"></span>
            <div class="form-group">
                <label for="textarea">{{__('defaultTheme.message')}} <span class="text-danger">*</span></label>
                <textarea name="message" id="message" placeholder="{{__('defaultTheme.write_messages')}}"></textarea>
                <span class="text-danger"  id="error_message"></span>
            </div>
            <div class="send_query_btn">
                <button id="contactBtn" type="submit" class="btn_1">{{__('defaultTheme.send_message')}}</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- send query part end -->

@endsection

@push('scripts')
<script>

    (function($){
        "use strict";
        $(document).ready(function(){

            $('#contactForm').on('submit', function(event) {
                event.preventDefault();
                console.log('ok')
                $("#contactBtn").prop('disabled', true);
                $('#contactBtn').text('{{ __('common.submitting') }}');

                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('contact.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        toastr.success("{{__('defaultTheme.message_sent_successfully')}}","{{__('common.success')}}");
                        $("#contactBtn").prop('disabled', false);
                        $('#contactBtn').text("{{ __('defaultTheme.send_message') }}");
                        resetErrorData();

                    },
                    error: function(response) {
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        $("#contactBtn").prop('disabled', false);
                        $('#contactBtn').text("{{ __('defaultTheme.send_message') }}");
                        showErrorData(response.responseJSON.errors)

                    }
                });
            });


            $('#pricingToggle').on('change', function(){
                this.value = this.checked ? 1 : 0;


                if(this.value == 1){
                    $('.monthly_price_div').addClass('d-none');
                    $('.yearly_price_div').removeClass('d-none');
                }
                if(this.value == 0){
                    $('.yearly_price_div').addClass('d-none');
                    $('.monthly_price_div').removeClass('d-none');
                }
            });

            function showErrorData(errors){
                $('#contactForm #error_name').text(errors.name)
                $('#contactForm #error_email').text(errors.email)
                $('#contactForm #error_query_type').text(errors.query_type)
                $('#contactForm #error_message').text(errors.message)
            }

            function resetErrorData(){
                $('#contactForm')[0].reset();
                $('#contactForm #error_name').text('')
                $('#contactForm #error_email').text('')
                $('#contactForm #error_query_type').text('')
                $('#contactForm #error_message').text('')
            }
        });
    })(jQuery);

</script>

@endpush
