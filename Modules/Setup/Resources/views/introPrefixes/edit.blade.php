<div class="modal fade admin-query" id="IntroPrefix_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('setup.edit_introprefix') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('introPrefix.update',$introPrefix->id) }}" method="POST" id="division_editForm">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setup.prefix_name') }} *</label>
                                <input name="title" class="primary_input_field name" placeholder="{{ __('setup.prefix_name') }}" type="text" value="{{ $introPrefix->title }}" required>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setup.prefix_details') }} *</label>
                                <input name="prefix" class="primary_input_field name" placeholder="{{ __('setup.prefix_details') }}" type="text" value="{{ $introPrefix->prefix }}" required>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.update') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
