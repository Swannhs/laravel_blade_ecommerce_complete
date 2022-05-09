<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">
                {{ __('marketing.create_bulk_sms') }} </h3>
        </div>
    </div>
</div>
<div class="row">
    <div id="formHtml" class="col-lg-12">
        <div class="white-box">
            <form action="" id="add_form">
                <div class="add-visitor">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="title">{{ __('common.title') }} <span
                                        class="text-danger">*</span></label>
                                <input class="primary_input_field" type="text" id="title" name="title"
                                    autocomplete="off" value="" placeholder="{{ __('common.title') }}">
                                <span class="text-danger" id="error_title"></span>
                            </div>



                        </div>

                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="message">{{ __('common.message') }}
                                    <span class="text-danger">*</span></label>

                                <textarea name="message" id="message" cols="30" class="form-control primary_input_field" placeholder="{{ __('common.message') }}"
                                    rows="10">{{$template->value}}</textarea>
                                <span class="text-danger" id="error_message"></span>
                            </div>


                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="publish_date">{{ __('marketing.publish_on') }} <span
                                    class="text-danger">*</span></label>
                                <div class="primary_datepicker_input">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{__('common.date')}}"
                                                    class="primary_input_field primary-input date form-control"
                                                    id="publish_date" type="text" name="publish_date"
                                                    value="{{date('m/d/Y')}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="text-danger" id="error_publish_date"></span>
                            </div>

                        </div>



                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{ __('marketing.send_to') }} <span
                                    class="text-danger">*</span></label>
                                <select name="send_to" id="send_to" class="primary_select mb-15">
                                    <option disabled selected>{{ __('common.select') }}</option>
                                    <option value="1">{{__('marketing.all_user')}}</option>
                                    <option value="2">{{__('marketing.role_wise')}}</option>
                                    <option value="3">{{__('marketing.multiple_role_select_user')}}</option>

                                </select>
                                <span class="text-danger" id="error_send_to"></span>
                            </div>


                        </div>
                        <div id="all_user_div" class="col-lg-12 d-none">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="all_user">{{ __('marketing.all_user') }} <span
                                    class="text-danger">*</span></label>
                                <select name="all_user[]" id="all_user" class="primary_select mb-15"
                                    multiple>
                                    <option disabled>{{ __('common.select') }}</option>
                                    @if(isModuleActive('MultiVendor'))
                                        @foreach ($users as $key => $user)
                                            <option selected value="{{ $user->id }}">
                                                {{ $user->username }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($users->where('role_id','!=',5)->where('role_id','!=', 6) as $key => $user)
                                            <option selected value="{{ $user->id }}">
                                                {{ $user->username }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" id="error_all_user"></span>
                            </div>

                        </div>
                        <div id="select_role_div" class="col-lg-12 d-none">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="role">{{ __('common.select_role') }} <span
                                    class="text-danger">*</span></label>
                                <select name="role" id="role" class="primary_select mb-15">
                                    <option disabled selected>{{ __('common.select') }}</option>
                                    @if(isModuleActive('MultiVendor'))
                                        @foreach ($roles as $key => $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($roles->where('type','!=','seller') as $key => $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" id="error_role"></span>
                            </div>

                        </div>
                        <div id="select_role_user_div" class="col-lg-12 d-none">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="">{{ __('marketing.selected_role_user') }} <span
                                    class="text-danger">*</span></label>
                                <select name="role_user[]" id="role_user" class="primary_select mb-15"
                                    multiple>
                                    <option disabled>{{ __('common.select') }}</option>

                                </select>
                                <span class="text-danger" id="error_role_user"></span>
                            </div>

                        </div>
                        <div id="multiple_role_div" class="col-lg-12 d-none">
                            <label>{{__('marketing.message_to')}} <span
                                class="text-danger">*</span></label>
                            <br>
                            <div class="">
                                <input type="checkbox" checked id="role_all" class="common-checkbox" value=""
                                    name="">
                                <label for="role_all">{{__('common.all')}}</label>
                            </div>
                            @if(isModuleActive('MultiVendor'))
                                @foreach ($roles as $key => $role)
                                    <div class="">
                                        <input type="checkbox" checked id="role_{{ $role->id }}"
                                            class="common-checkbox multi_check" value="{{ $role->id }}"
                                            name="role_list[]">
                                        <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($roles->where('type', '!=', 'seller') as $key => $role)
                                    <div class="">
                                        <input type="checkbox" checked id="role_{{ $role->id }}"
                                            class="common-checkbox multi_check" value="{{ $role->id }}"
                                            name="role_list[]">
                                        <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                            <span class="text-danger" id="error_role_list"></span>

                        </div>


                    </div>
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                data-toggle="tooltip" title="" data-original-title="">
                                <span class="ti-check"></span>
                                {{ __('marketing.save_test_sms') }} </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<div id="testSMSDiv">

</div>

