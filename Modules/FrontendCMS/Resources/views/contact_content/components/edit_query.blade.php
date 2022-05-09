<div class="main-title">
    <h3 class="mb-30">
        {{__('frontendCms.edit_InQuery')}}
    </h3>
</div>



@include('frontendcms::contact_content.components.query_form',['form_id' => 'query_edit_form', 'btn_id' => 'edit_btn', 'button_name' => __('common.update') ])


