<form method="POST" action="" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"
id="{{$form_id}}">

    <div class="white-box">
        <div class="add-visitor">
            <div class="row">

                <div class="col-lg-12">
                    <input type="hidden" id="item_id" name="id" value="" />
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                        <input class="primary_input_field" type="text" id="name" name="name" autocomplete="off" value="" placeholder="{{__('common.name')}}">
                        <span class="text-danger" id="error_name"></span>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="monthly_cost">{{__('frontendCms.monthly_cost')}} <span class="text-danger">*</span></label>
                        <input class="primary_input_field" type="number" step="{{step_decimal()}}" name="monthly_cost" id="monthly_cost" min="0" autocomplete="off" value="0">
                        <span class="text-danger" id="error_monthly_cost"></span>
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="yearly_cost">{{__('frontendCms.yearly_cost')}} <span class="text-danger">*</span></label>
                        <input class="primary_input_field"  type="number" name="yearly_cost" id="yearly_cost" step="{{step_decimal()}}" min="0" autocomplete="off" value="0">
                        <span class="text-danger" id="error_yearly_cost"></span>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label"for="team_size">{{__('frontendCms.team_size')}}</label>
                        <input class="primary_input_field" type="number" id="team_size" name="team_size" step="1" min="0" autocomplete="off" value="0">
                        <span class="text-danger" id="error_team_size"></span>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="stock_limit">{{__('frontendCms.stock_limit')}}</label>
                        <input class="primary_input_field" type="number" id="stock_limit" step="1" min="0" name="stock_limit" autocomplete="off" value="0">
                        <span class="text-danger" id="error_stock_limit"></span>
                    </div>
                    
                </div>
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                       <label class="primary_input_label" for="transaction_fee">{{__('frontendCms.transaction_fee')}} (%)</label>
                       <input class="primary_input_field" type="number" id="transaction_fee" value="0" step="{{step_decimal()}}" min="0" max="100" name="transaction_fee" autocomplete="off">
                       <span class="text-danger" id="error_transaction_fee"></span>
                    </div>
                    
                </div>
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                       <label class="primary_input_label" for="best_for">{{__('frontendCms.best_for')}}</label>
                        <input class="primary_input_field" type="text" id="best_for" name="best_for" autocomplete="off" placeholder="{{__('frontendCms.best_for')}}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('common.status') }} <span class="text-danger">*</span></label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                    <input name="status" id="status_active" value="1" checked="true" class="active"
                                        type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                    <input name="status" value="0" id="status_inactive" class="de_active" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                        <span class="text-danger" id="status_error"></span>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="primary_input">
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                    <input name="is_featured" id="is_featured" value="1" type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('frontendCms.is_featured') }}</p>
                            </li>
                        </ul>
                        <span class="text-danger" id="is_featured_error"></span>
                    </div>
                </div>

            </div>
            <div class="row mt-40">
                <div class="col-lg-12 text-center">
                <button id="{{ $btn_id }}" type="submit" class="primary-btn fix-gr-bg" data-toggle="tooltip" title=""
                        data-original-title="">
                        <span class="ti-check"></span>
                        {{$button_name}} </button>
                </div>
            </div>
        </div>
    </div>
</form>
