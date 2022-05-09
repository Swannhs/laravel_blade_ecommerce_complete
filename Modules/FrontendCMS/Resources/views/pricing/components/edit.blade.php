<div class="main-title">
    <h3 class="mb-30">
        {{ __('frontendCms.edit_pricing_plan') }}
    </h3>
</div>



@include('frontendcms::pricing.components.form',['form_id' => 'pricing_edit_form', 'btn_id' => 'edit_btn', 'button_name' => __('common.update') ])

