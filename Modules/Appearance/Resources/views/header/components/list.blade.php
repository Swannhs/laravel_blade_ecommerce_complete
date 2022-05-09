
<div class="row">
    <div class="col-lg-12">
        <table class="table Crm_table_active3">
            <thead>
                <tr>
                    <th scope="col" class=" text-center">{{__('common.sl')}}</th>
                    <th  scope="col" class="">{{__('common.name')}}</th>
                    <th  scope="col" class="">{{__('appearance.column_size')}}</th>
                    <th  scope="col" class="">{{__('common.status')}}</th>
                    <th  scope="col" class="">{{__('common.action')}}</th>

                </tr>
            </thead>
            <tbody id="sku_tbody">
                @foreach($headers as $key => $header)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$header->name}}</td>
                    <td>{{$header->column_size}}</td>
                    <td>
                        <label class="switch_toggle" for="checkbox{{ $header->id }}">
                            <input type="checkbox" id="checkbox{{ $header->id }}" {{$header->is_enable?'checked':''}} value="{{$header->id}}" @if (!permissionCheck('appearance.header.update_status')) disabled @endif class="update_active_status" data-id="{{$header->id}}">
                            <div class="slider round"></div>
                        </label>
                    </td>


                    <td>
                        <!-- shortby  -->

                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('common.select') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                @if (permissionCheck('appearance.header.setup'))
                                    <a href="{{route('appearance.header.setup',$header->id)}}" class="dropdown-item edit_brand">{{__('common.setup')}}</a>
                                @endif
                            </div>
                        </div>

                        <!-- shortby  -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
