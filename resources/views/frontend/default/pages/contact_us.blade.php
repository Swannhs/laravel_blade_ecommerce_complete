@extends('frontend.default.layouts.app')
@section('styles')
    <style>
        .mb-15{
            margin-bottom: 15px!important;
        }
        .customer_img input{
            width: 100%;
            background: #fff;
        }
        .send_query .form-group input{
            text-transform: none!important;
        }
    </style>
@endsection
@section('breadcrumb')
    {{ $contactContent->mainTitle }}
@endsection

@section('content')

    @include('frontend.default.partials._breadcrumb')
    <!-- contact info part here -->
    <section class="contact_info padding_top bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="contact_info_text">
                        <h4>{{ $contactContent->subTitle }}</h4>
                        @php echo $contactContent->description; @endphp
                        <a href="mailto:{{ $contactContent->email }}" class="contact_btn">{{ $contactContent->email }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact info part end -->

    <!-- send query part here -->
    <section class="send_query padding_top bg-white contact_form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">

                    <form id="contactForm" action="#" name="#" class="send_query_form" enctype="multipart/form-data">

                        @if(!empty($row) && !empty($form_data))
                            @php
                                $default_field = [];
                                $custom_field = [];
                                $custom_file = false;
                            @endphp
                            @foreach($form_data as $row)
                                @php
                                    if($row->type != 'header' && $row->type !='paragraph'){
                                        if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                                            $default_field[] = $row->name;
                                        }else{
                                            $custom_field[] = $row->name;
                                            $custom_file  = true;
                                        }
                                        $required = property_exists($row,'required');
                                        $type = property_exists($row,'subtype') ? $row->subtype : $row->type;
                                        $placeholder = property_exists($row,'placeholder') ? $row->placeholder : $row->label;
                                    }
                                @endphp

                                    @if($row->type =='header' || $row->type =='paragraph')
                                        <div class="form-group">
                                            <{{ $row->subtype }}>{{ $row->label }} </{{ $row->subtype }}>
                                        </div>
                                    @elseif($row->type == 'text' || $row->type == 'number' || $row->type == 'email' || $row->type == 'date')
                                        <div class="form-group">
                                            <label for="{{$row->name}}"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                            <input {{$required ? 'required' :''}} type="{{$type}}" id="{{$row->name}}" class="@error($row->name) is-invalid @enderror form-control" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                            @error($row->name)
                                            <span class="text-danger" >{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @elseif($row->type=='select')
                                        <div class="form-group">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <select {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" class="form-control nc_select">
                                                @foreach($row->values as $value)
                                                    <option value="{{$value->value}}" {{old($row->name) == $value->value? 'selected': ''}}>{{$value->label}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first($row->name)}}</span>
                                        </div>

                                    @elseif($row->type == 'date')
                                        <div class="form-group">
                                            <label for="datepicker"> {{$row->label}} @if($required) <span class="text-danger">*</span> @endif</label>
                                            <input {{$required ? 'required' :''}} type="{{$type}}" id="datepicker" class="@error($row->name) form-control is-invalid @enderror" name="{{$row->name}}" value="{{ old($row->name) }}" placeholder="{{$placeholder}}">
                                            @error($row->name)
                                            <span class="text-danger" >{{ $message }}</span>
                                            @enderror
                                        </div>

                                    @elseif($row->type=='textarea')
                                        <div class="form-group">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <textarea class="form-control" {{$required ? 'required' :''}} name="{{$row->name}}" id="{{$row->name}}" placeholder="{{$placeholder}}">{{old($row->name)}}</textarea>
                                            <span class="text-danger">{{$errors->first($row->name)}}</span>
                                        </div>

                                    @elseif($row->type=="radio-group")
                                        <div class="form-group">
                                            <label for="">{{ $row->label }}</label>
                                            <div class="d-flex radio-btn-flex">
                                                @foreach($row->values as $value)
                                                    <label class="primary_bulet_checkbox mr-10">
                                                        <input type="radio" name="{{ $row->name }}" value="{{ $value->value }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <span class="mr-10">{{ $value->label }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif($row->type=="checkbox-group")
                                        <div class="form-group">
                                            <label>{{@$row->label}}</label>
                                            <div class="checkbox">
                                                @foreach($row->values as $value)
                                                    <label class="cs_checkbox mr-10">
                                                        <input  type="checkbox" name="{{ $row->name }}[]" value="{{ $value->value }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p class="mr-10">{{$value->label}}</p>
                                                @endforeach
                                            </div>
                                        </div>

                                    @elseif($row->type =='file')

                                        <div class="form-group customer_img">
                                            <label for={{$row->name}}>{{$row->label}}@if($required) <span class="text-danger">*</span> @endif</label>
                                            <div class="form-group">
                                                <input class="{{$custom_file ? 'custom_file' :''}}" accept="image/*" type="{{$type}}" name="{{$row->name}}" id="{{$row->name}}" >
                                            </div>
                                        </div>
                                        
                                    @elseif($row->type =='checkbox')
                                        <div class="col-md-12 mb-15">
                                            <div class="checkbox">
                                                <label class="cs_checkbox">
                                                    <input id="policyCheck" type="checkbox" checked>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <p>{{$row->label}}</p>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                                <input type="hidden" name="custom_field" value="{{json_encode($custom_field)}}">

                            @else
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
                        @endif
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

        $(document).ready(function() {

            $('#contactForm').on('submit', function(event) {
                event.preventDefault();
                // console.log('ok')
                $("#contactBtn").prop('disabled', true);
                $('#contactBtn').text('{{ __('common.submitting') }}');

                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });

                if($('.custom_file').length > 0){
                    let photo = $('.custom_file')[0].files[0];
                    if (photo) {
                        formData.append($('.custom_file').attr('name'), photo)
                    }
                }
                
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

            function showErrorData(errors){
                $('#contactForm #error_name').text(errors.name);
                $('#contactForm #error_email').text(errors.email);
                $('#contactForm #error_query_type').text(errors.query_type);
                $('#contactForm #error_message').text(errors.message);
            }

            function resetErrorData(){
                $('#contactForm')[0].reset();
                $('#contactForm #error_name').text('');
                $('#contactForm #error_email').text('');
                $('#contactForm #error_query_type').text('');
                $('#contactForm #error_message').text('');
            }
        });
    })(jQuery);


</script>
@endpush
