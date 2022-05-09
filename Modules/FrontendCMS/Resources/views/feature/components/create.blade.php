
<div class="main-title">
    <h3 class="mb-20">
        {{__('frontendCms.add_feature')}} </h3>
</div>
@include('frontendcms::feature.components.form',['form_id' => 'item_create_form', 'button_level_name' => __('common.save') ])