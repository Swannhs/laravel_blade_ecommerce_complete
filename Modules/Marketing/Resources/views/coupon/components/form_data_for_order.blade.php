<div class="row">
    <div class="col-lg-12">
        <h4 class="ml-10">{{__('marketing.add_coupon_based_on_order')}}</h4>
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
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="minimum_shopping">{{ __('marketing.minimum_shopping') }} <span
                    class="text-danger">*</span></label>
            <input class="primary_input_field" id="minimum_shopping" name="minimum_shopping"
                autocomplete="off"  placeholder="" type="number" min="0" step="{{step_decimal()}}" value="">
            <span class="text-danger" id="error_minimum_shopping"></span>
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
            <input class="primary_input_field" id="maximum_discount" name="maximum_discount"
                autocomplete="off"  placeholder="" type="number" min="0" step="{{step_decimal()}}" value="">
                <span class="text-danger" id="error_maximum_discount"></span>
        </div>


    </div>
    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="discount">{{ __('common.discount') }} <span
                    class="text-danger">*</span></label>
            <input class="primary_input_field" name="discount" id="discount" placeholder="" type="number" min="0" step="{{step_decimal()}}" value="0">
            <span class="text-danger" id="error_discount"></span>
        </div>



    </div>

    <div class="col-lg-6">
        <div class="primary_input mb-25">
            <label class="primary_input_label" for="discount_type">{{ __('common.discount_type') }} <span
                    class="text-danger">*</span></label>
            <div class="primary_input mb-25">
                <select class="primary_select mb-25" name="discount_type" id="discount_type">
                    <option  value="1">{{ __('common.amount') }}</option>
                    <option   value="0">{{ __('common.percentage') }}</option>
                </select>
                <span class="text-danger" id="error_discount_type"></span>
            </div>
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
