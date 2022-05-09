<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">
                {{ __('marketing.update_bulk_sms') }} </h3>
        </div>
    </div>
</div>
<div class="row">
    <div id="formHtml" class="col-lg-12">
        <div class="white-box">
            <form action="" id="edit_form">
                <div class="add-visitor">
                    <div class="row">
                        <input type="hidden" name="id" value="{{$message->id}}">
                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="title">{{ __('common.title') }} <span
                                        class="text-danger">*</span></label>
                                <input class="primary_input_field" type="text" id="title" name="title"
                                    autocomplete="off" value="{{$message->title}}" placeholder="{{ __('common.title') }}">
                                <span class="text-danger" id="error_title"></span>
                            </div>
                            
                            
                            
                        </div>
            
                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="message">{{ __('common.message') }}
                                    <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" cols="30" class="form-control primary_input_field" placeholder="{{ __('common.message') }}"
                                    rows="10">{{$message->message}}</textarea>
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
                                                <input placeholder="{{ __('common.date') }}"
                                                    class="primary_input_field primary-input date form-control"
                                                    id="publish_date" type="text" name="publish_date"
                                                    value="{{date('m/d/Y',strtotime($message->publish_date))}}" autocomplete="off" required>
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
                                    <option {{$message->send_type == 1?'selected':''}} value="1">{{__('marketing.all_user')}}</option>
                                    <option {{$message->send_type == 2?'selected':''}} value="2">{{__('marketing.role_wise')}}</option>
                                    <option {{$message->send_type == 3?'selected':''}} value="3">{{__('marketing.multiple_role_select_user')}}</option>
            
                                </select>
                                <span class="text-danger" id="error_send_to"></span>
                            </div>
                            
                        </div>
                        <div id="all_user_div" class="col-lg-12 {{$message->send_type == 1?'':'d-none'}}">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="all_user">{{ __('marketing.all_user') }} <span
                                    class="text-danger">*</span></label>
                                <select name="all_user[]" id="all_user" class="primary_select mb-15"
                                    multiple>
                                    <option disabled>{{ __('common.select') }}</option>
                                    @php
                                        $selectedUsers = json_decode($message->send_user_ids);
                                    @endphp
                                    @if(isModuleActive('MultiVendor'))
                                        @foreach ($users as $key => $user)
                                            <option @if(in_array($user->id,$selectedUsers)) selected @endif value="{{ $user->id }}">
                                                    {{ $user->username}}</option>
                                        @endforeach
                                    @else
                                        @foreach ($users->where('role_id','!=',5)->where('role_id','!=', 6) as $key => $user)
                                            <option @if(in_array($user->id,$selectedUsers)) selected @endif value="{{ $user->id }}">
                                                    {{ $user->username}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" id="error_all_user"></span>
                            </div>
                            
                        </div>
                        <div id="select_role_div" class="col-lg-12 {{$message->send_type == 2?'':'d-none'}}">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="role">{{ __('common.select_role') }} <span
                                    class="text-danger">*</span></label>
                                <select name="role" id="role" class="primary_select mb-15">
                                    <option disabled selected>{{ __('common.select') }}</option>
                                    @if(isModuleActive('MultiVendor'))
                                        @foreach ($roles as $key => $role)
                                            <option {{$message->single_role_id == $role->id?'selected':''}}  value="{{ $role->id }}">{{ $role->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($roles->where('type', '!=', 'seller') as $key => $role)
                                            <option {{$message->single_role_id == $role->id?'selected':''}}  value="{{ $role->id }}">{{ $role->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger" id="error_role"></span>
                            </div>
                            
                        </div>
                        <div id="select_role_user_div" class="col-lg-12 {{$message->send_type == 2?'':'d-none'}}">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="">{{ __('marketing.selected_role_user') }} <span
                                    class="text-danger">*</span></label>
                                <select name="role_user[]" id="role_user" class="primary_select mb-15"
                                    multiple>
                                    <option disabled>{{ __('common.select') }}</option>
                                @foreach ($users->where('role_id',$message->single_role_id) as $key => $user)
                                    <option @if(in_array($user->id,$selectedUsers)) selected @endif value="{{ $user->id }}">
                                        {{ $user->username}}</option>
                                 @endforeach
                                </select>
                                <span class="text-danger" id="error_role_user"></span>
                            </div>
                            
                        </div>
                        <div id="multiple_role_div" class="col-lg-12 {{$message->send_type == 3?'':'d-none'}}">
                            <label>{{__('marketing.message_to')}} <span
                                class="text-danger">*</span></label>
                            <br>
                            @php
                                if($message->send_type == 3){
                                    $selectedRoles = json_decode($message->multiple_role_id);
                                }else{
                                    $selectedRoles = [];
                                }
                                
                            @endphp
                            <div class="">
                                <input type="checkbox" @if(count($selectedRoles) == count($roles)) checked @endif id="role_all" class="common-checkbox" value=""
                                    name="">
                                <label for="role_all">{{__('common.all')}}</label>
                            </div>
                            @if(isModuleActive('MultiVendor'))
                                @foreach ($roles as $key => $role)
                                    <div class="">
                                        <input type="checkbox" @if(in_array($role->id,$selectedRoles)) checked @endif id="role_{{ $role->id }}"
                                            class="common-checkbox multi_check" value="{{ $role->id }}"
                                            name="role_list[]">
                                        <label for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($roles->where('type', '!=', 'seller') as $key => $role)
                                    <div class="">
                                        <input type="checkbox" @if(in_array($role->id,$selectedRoles)) checked @endif id="role_{{ $role->id }}"
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
                                {{ __('common.update') }} </button>
                            <button type="button" class="primary-btn fix-gr-bg" id="test_sms_btn"
                                data-toggle="tooltip" title="" data-original-title="">
                                <span class="ti-check"></span>
                                {{ __('marketing.test_sms') }} </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@include('marketing::bulk_sms.components.modal_for_test_sms',['id' => $message->id])
