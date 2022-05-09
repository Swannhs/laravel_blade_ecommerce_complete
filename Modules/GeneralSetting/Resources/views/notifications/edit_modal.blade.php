
<div class="modal fade admin-query" id="edit_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.edit') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="POST" id="edit_form">
                    @csrf
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="event">{{ __('common.notification') }}
                                    {{ __('hr.event') }}
                                    <span class="text-danger">*</span></label>
                                <input required class="primary_input_field" type="text" id="event"
                                    class="form-control" readonly name="event" autocomplete="off"
                                    value="">
                                @error('event')
                                <span class="text-danger" id="error_background_color">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="type">{{ __('common.notification') }}
                                    {{ __('common.type') }}
                                    <span class="text-danger">*</span></label>

                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="email" class="notification-type" type="checkbox" id="notification_email">
                                        <span class="checkmark"></span>  &nbsp;Email
                                    </label>

                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="mobile" class="notification-type" type="checkbox" id="notification_mobile">
                                        <span class="checkmark"></span>  &nbsp;Mobile
                                    </label>

                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="system" class="notification-type" type="checkbox" id="notification_system">
                                        <span class="checkmark"></span>  &nbsp;System
                                    </label>

                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="sms" class="notification-type" type="checkbox" id="notification_sms">
                                        <span class="checkmark"></span>  &nbsp;Sms
                                    </label>
                                @error('type')
                                <span class="text-danger" id="error_background_color">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="message">
                                    {{__('general_settings.message_for_system_notification')}}
                                    <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" cols="30" class="form-control primary_input_field" placeholder="Message" rows="5"></textarea>
                                @error('message')
                                <span class="text-danger" id="error_background_color">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="primary_input">
                            <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                    class="ti-check"></i>{{ __('common.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
