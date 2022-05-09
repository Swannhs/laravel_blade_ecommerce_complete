@if (permissionCheck('ignore_ip_list_destroy'))
<!-- shortby  -->
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ __('common.select') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('ignore_ip_list_destroy'))
        <a class="dropdown-item delete_unit"
            data-value="{{ route('ignore_ip_list_destroy', $ip->id) }}">{{ __('common.delete') }}</a>
        @endif
    </div>
</div>
<!-- shortby  -->
@else
<button class="primary_btn_2" type="button">{{ __('common.no_action_permitted') }}</button>
@endif
