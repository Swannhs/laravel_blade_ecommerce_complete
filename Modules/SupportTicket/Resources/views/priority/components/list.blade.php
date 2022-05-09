
<div class="row">
    <div class="col-lg-12">
        <div class="QA_section QA_section_heading_custom check_box_table">
            <div class="QA_table">
                <div class="">
                    <table class="table Crm_table_active3">
                        <thead>
                            <tr>
                                <th width="15%" scope="col" class=" text-center">{{__('common.sl')}}</th>
                                <th width="35%" scope="col" class="">{{__('common.name')}}</th>
                                <th width="20%" scope="col" class="">{{__('common.status')}}</th>
                                <th width="30%" scope="col" class="">{{__('common.action')}}</th>

                            </tr>
                        </thead>
                        <tbody id="sku_tbody">
                            @foreach($priorities as $key => $priority)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$priority->name}}</td>
                                <td>
                                    <label class="switch_toggle" for="checkbox{{ $priority->id }}">
                                        <input type="checkbox" id="checkbox{{ $priority->id }}" @if (permissionCheck('ticket.priority.status')) class="status_change" data-value="{{$priority->id}}" {{$priority->status?'checked':''}} value="{{$priority->id}}" @endif>
                                        <div class="slider round"></div>
                                    </label>
                                </td>
                                <td>

                                    <div class="dropdown CRM_dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ __('common.select') }}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                            @if (permissionCheck('ticket.priority.update'))
                                                <a href="" data-value="{{$priority->id}}" class="dropdown-item edit_priority">{{ __('common.edit') }}</a>
                                            @endif
                                            @if (permissionCheck('ticket.priority.delete'))
                                                <a href="" class="dropdown-item delete_priority" data-value="{{$priority->id}}">{{ __('common.delete') }}</a>
                                            @endif
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
