<div class="row">
    <div class="col-lg-12">
        <h4 class="ml-10">{{__('marketing.add_coupon_for_free_shipping')}}</h4>
        <hr>
    </div>
    <div class="col-lg-12">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="coupon_code">{{ __('marketing.coupon_code') }} <span
                    class="text-danger">*</span></label>
            <input class="primary_input_field" type="text" id="coupon_code" name="coupon_code"
                autocomplete="off" value="" placeholder="{{ __('marketing.coupon_code') }}">
            <span class="text-danger" id="error_coupon_code"></span>
        </div>


    </div>

    <div class="col-lg-12">
        <div class="primary_input mb-15">
            <label class="primary_input_label" for="">{{__('common.date')}} <span
                class="text-danger">*</span></label>
            <div class="primary_datepicker_input">
                <div class="no-gutters input-right-icon">
                    <div class="col">
                        <div class="">
                            <input placeholder="{{__('common.date')}}" class="primary_input_field primary-input form-control" id="date" type="text" name="date" autocomplete="off" readonly>
                        </div>
                        <input type="hidden" name="start_date" id="start_date" value="">
                        <input type="hidden" name="end_date" id="end_date" value="">
                    </div>
                    <button class="" type="button">
                        <i class="ti-calendar" id="start-date-icon"></i>
                    </button>
                </div>
            </div>
            <span class="text-danger" id="error_date"></span>
        </div>


    </div>
    <div class="col-lg-12">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="maximum_discount">{{ __('marketing.maximum_discount') }} </label>
            <input class="primary_input_field" name="maximum_discount" id="maximum_discount" placeholder="" type="number" min="0" step="{{step_decimal()}}" value="">
            <span class="text-danger" id="error_maximum_discount"></span>
        </div>

    </div>
    <div class="col-lg-12">
        <div class="primary_input">
            <ul id="theme_nav" class="permission_list sms_list ">
                <li>
                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                        <input name="is_multiple" id="is_multiple" value="1" type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                    <p>{{ __('marketing.allow_multiple_buy') }}</p>
                </li>
            </ul>
            <span class="text-danger" id="is_featured_error"></span>
        </div>
    </div>


</div>
