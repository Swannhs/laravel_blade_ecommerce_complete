
<div class="row">
    <div class="col-lg-12">
        <div class="QA_section QA_section_heading_custom check_box_table">
            <div class="QA_table">
                <div class="">
                    <table class="table Crm_table_active3">
                        <thead>
                            <tr>
                                <th width="15%" scope="col">{{__('common.sl')}}</th>
                                <th width="35%" scope="col" class="">{{__('common.name')}}</th>
                                <th width="20%" scope="col" class="">{{__('common.status')}}</th>
                                <th width="30%" scope="col" class="">{{__('common.action')}}</th>

                            </tr>
                        </thead>
                        <tbody id="sku_tbody">
                            @foreach($statuses as $key => $status)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$status->name}}</td>
                                <td>
                                    <label class="switch_toggle" for="checkbox{{ $status->id }}">
                                        <input type="checkbox" id="checkbox{{ $status->id }}" @if (permissionCheck('ticket.status.status')) class="status_change" {{$status->status?'checked':''}} data-id="{{$status->id}}" value="{{$status->id}}" @else disabled @endif>
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
                                            @if (permissionCheck('ticket.status.update'))
                                                <a href="" data-id="{{$status->id}}" class="dropdown-item edit_status">{{ __('common.edit') }}</a>
                                            @endif
                                            @if (permissionCheck('ticket.status.delete'))
                                                @if ($status->id > 4)

                                                <a href="" class="dropdown-item delete_status" data-id="{{$status->id}}">{{ __('common.delete') }}</a>
                                                @endif
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
