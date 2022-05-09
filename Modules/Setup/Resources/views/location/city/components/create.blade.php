
<div class="main-title">
    <h3 class="mb-20">
        {{__('common.add')}} {{__('common.city')}}</h3>
</div>



<form enctype="multipart/form-data" id="create_form">
    <div class="white-box">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label"
                        for="name">{{ __('common.name') }} <span class="text-danger">*</span></label>
                    <input name="name" class="primary_input_field name"
                        id="name" placeholder="{{ __('common.name') }}"
                        type="text">
                    <span class="text-danger"  id="error_name"></span>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.country') }} {{__('common.list')}}</label>
                    <select name="country" id="country" class="primary_select mb-15">
                        <option value="" selected disabled>{{__('common.select_one')}}</option>
                        @foreach ($countries as $key => $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach

                    </select>
                    <span class="text-danger"  id="error_country"></span>
                </div>
            </div>

            <div class="col-lg-12" id="stateDiv">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.state') }} {{__('common.list')}}</label>
                    <select name="state" id="state" class="primary_select mb-15">
                        <option value="" selected disabled>{{__('common.select_one')}}</option>
                        

                    </select>
                    <span class="text-danger"  id="error_state"></span>
                </div>
            </div>
    
    
            <div class="col-xl-12">
                <div class="primary_input">
                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option"
                                   class="primary_checkbox d-flex mr-12">
                                <input name="status" id="status_active" value="1" checked="true" class="active" type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.active') }}</p>
                        </li>
                        <li>
                            <label data-id="color_option"
                                   class="primary_checkbox d-flex mr-12">
                                <input name="status" value="0" id="status_inactive"  class="de_active"
                                       type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.inactive') }}</p>
                        </li>
                    </ul>
                    <span class="text-danger" id="status_error"></span>
                </div>
            </div>
    
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center pt_20">
                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                            class="ti-check"></i>
                            {{ __('common.save') }}
                    </button>
                </div>
            </div>
    
        </div>
    </div>
</form>
