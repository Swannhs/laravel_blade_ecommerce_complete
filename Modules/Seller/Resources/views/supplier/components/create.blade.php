@extends('backEnd.master')

@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100">
                        <h3 class="mb-0 mr-30">{{ __('seller.create_supplier') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-40">
                <div class="white_box_50px box_shadow_white">
                    <form method="POST" action="{{route('seller.supplier.store')}}" enctype="multipart/form-data" id="">
                        @csrf
                        <div class="row">

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="name">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                    <input name="name" class="primary_input_field name" id="name"
                                        placeholder="{{ __('common.name') }}" type="text" value="{{old('name')}}" required>
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">

                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                        for="">{{ __('common.profile_picture') }}</label>
                                    <div class="primary_file_uploader">
                                        <input class="primary-input" type="text" id="photo_file"
                                            placeholder="{{ __('common.browse_file') }}" readonly="">
                                        <button class="" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="photo"><span
                                                    class="ripple rippleEffect browse_file_label"></span>{{ __('common.browse') }}</label>
                                            <input name="photo" type="file" class="d-none"
                                                id="photo"
                                                onchange="getFileName(this.value,'#photo_file'),imageChangeWithFile(this,'#imgDiv34')">
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                <div class="logo_img">
                                   <img id="imgDiv34"
                                   src="{{ asset(asset_path('backend/img/default.png')) }}"
                                   alt="">
                                </div>
                           </div>

                           <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="business_name">{{ __('seller.business_name') }}</label>
                                    <input name="business_name" class="primary_input_field email" id="business_name"
                                        placeholder="{{ __('seller.business_name') }}" type="text" value="{{old('business_name')}}">
                                    <span class="text-danger" id="error_business_name"></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="tax_number">{{ __('common.tax_number') }}</label>
                                    <input name="tax_number" class="primary_input_field tax_number" id="tax_number"
                                        placeholder="{{ __('common.tax_number') }}" type="text" value="{{old('tax_number')}}">
                                    <span class="text-danger" id="error_tax_number"></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="opening_balance">{{ __('common.opening_balance') }}</label>
                                    <input name="opening_balance" class="primary_input_field opening_balance" id="opening_balance"
                                        placeholder="{{ __('common.opening_balance') }}" type="number" min="0" step="0.01" value="{{old('tax_number')?old('tax_number'):0}}">
                                    <span class="text-danger" id="error_"></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="payterm">{{ __('seller.pay_term') }}</label>
                                    <input name="payterm" class="primary_input_field email" id="payterm"
                                        placeholder="" type="text" value="{{old('payterm')}}">
                                    <span class="text-danger" id="error_email"></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="payterm_condition">{{ __('seller.pay_term_condition') }} </label>
                                    <select class="primary_select mb-25" name="payterm_condition" id="payterm_condition">
                                        <option value="" selected disabled>{{ __('common.select') }}</option>
                                        <option value="1">{{ __('common.month') }}</option>
                                        <option value="2">{{ __('common.days') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="email">{{ __('common.email_address') }}</label>
                                    <input name="email" class="primary_input_field email" id="email"
                                        placeholder="{{ __('common.email_address') }}" type="text" value="{{old('email')}}">
                                    <span class="text-danger" id="error_email"></span>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="phone_number">{{ __('common.phone_number') }} <span class="text-danger">*</span></label>
                                    <input name="phone_number" class="primary_input_field phone" id="phone_number"
                                        placeholder="" type="text" required value="{{old('phone_number')}}">
                                        @error('phone_number')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="alternate_phone_number">{{ __('seller.alternate_contact_no') }}</label>
                                    <input name="alternate_phone_number" class="primary_input_field phone" id="alternate_phone_number"
                                        placeholder="" type="text" value="{{old('alternate_phone_number')}}">
                                    <span class="text-danger" id="error_phone"></span>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="url">{{ __('common.url') }} </label>
                                    <input name="url" class="primary_input_field phone" id="url"
                                        placeholder="{{ __('common.url') }}" type="text" value="{{old('url')}}">
                                    <span class="text-danger" id="error_url"></span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="address">{{ __('common.address') }} </label>
                                    <input name="address" class="primary_input_field phone" id="address"
                                        placeholder="{{ __('common.address') }}" type="text" value="{{old('address')}}">
                                    <span class="text-danger" id="error_address"></span>
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="primary_input_label" for="country">{{ __('common.country_region') }}<span class="text-danger">*</span></label>
                                <select name="country" class="primary_select mb-25">
                                    @foreach($countries as $country)
                                    <option  value="{{$country->code}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="primary_input_label" for="state">{{ __('common.state') }}<span class="text-danger">*</span></label>
                                <select name="state" class="primary_select mb-25">
                                    <option value="dha">{{ __('Dhaka') }}</option>
                                    <option value="chi">{{ __('Chittagong') }}</option>
                                </select>
                                @error('state')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label class="primary_input_label" for="city">{{ __('common.city') }}<span class="text-danger">*</span></label>
                                <select name="city" class="primary_select mb-25">
                                    <option value="sv">{{ __('Savar') }}</option>
                                    <option value="dha">{{ __('Dhaka') }}</option>
                                </select>
                                @error('city')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="postcode">{{__('common.postcode')}}</label>
                                    <input name="postcode" class="primary_input_field" placeholder="-" type="text"
                                           value="{{ old('business_postcode')? old('postcode'):'' }}">
                                           @error('postcode')
                                           <span class="text-danger">{{$message}}</span>
                                           @enderror
                                </div>

                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                    <ul id="theme_nav" class="permission_list sms_list ">
                                        <li>
                                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                <input name="status" id="status_active" value="1" checked="true"
                                                    class="active" type="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{ __('common.active') }}</p>
                                        </li>
                                        <li>
                                            <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                <input name="status" value="0" id="status_inactive" class="de_active"
                                                    type="radio">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>{{ __('common.inactive') }}</p>
                                        </li>
                                    </ul>
                                    <span class="text-danger" id="error_status"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="primary_input mb-35">
                                    <label class="primary_input_label"
                                        for="">{{ __('common.description') }}</label>
                                    <textarea name="description"
                                        class="lms_summernote"></textarea>
                                </div>
                                <span class="text-danger"  id="error_description"></span>
                            </div>

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                                            class="ti-check"></i>
                                        {{__('common.save')}}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</section>
@endsection

@push('scripts')

    <script>
        function imageChangeWithFile(input, srcId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(srcId)
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

@endpush
