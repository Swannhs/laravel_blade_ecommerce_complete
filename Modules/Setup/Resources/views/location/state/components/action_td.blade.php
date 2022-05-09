@if (permissionCheck('setup.state.update'))
    <div class="dropdown CRM_dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button"
                id="dropdownMenu2" data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            {{ __('common.select') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">

            <a href="" class="dropdown-item edit_state" data-id="{{$states->id}}">{{__('common.edit')}}</a>

        </div>
    </div>
@else
    <button class="primary_btn_2" type="button">{{ __('common.no_action_permitted') }}</button>
@endif
