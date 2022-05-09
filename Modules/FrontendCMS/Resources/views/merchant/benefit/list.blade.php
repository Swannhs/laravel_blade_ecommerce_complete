<div class="table-responsive">
    <table id="default_table" class="display school-table no-footer dtr-inline dataTable benefit_table"
        cellspacing="0" width="100%" role="grid" aria-describedby="default_table_info">
        @if (count($BenefitList) < 4 )
        <a href="" class="primary-btn small tr-bg icon-only mr-10 modalLink pull-right add_benefit_modal"
            title="Create Class Routine">
            <span class="ti-plus" id="add benefit"></span>
        </a>
            
        @endif
        <thead>
            <tr class="text-center" role="row">
                <th class="" tabindex="0" aria-controls="default_table" class="width-60" aria-label=""
            aria-sort="ascending">{{__('common.sl')}}</th>
                <th class="" tabindex="0" aria-controls="default_table" rowspan="1" colspan="1" class="width-83"
                    aria-label="">{{__('common.title')}}</th>
                <th class="" tabindex="0" aria-controls="default_table" rowspan="1" colspan="1" class="width-83"
                    aria-label="">{{__('common.status')}}</th>
                <th class="" tabindex="0" aria-controls="default_table" rowspan="1" colspan="1" class="width-83"
                    aria-label="">{{__('common.action')}}</th>    

            </tr>
        </thead>

        <tbody>
            @foreach ($BenefitList as $key => $item)
            <tr class="text-center" id="benefit-td">
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->status?'Active':'Inactive' }}</td>
                <td> <p><i data-value="{{$item}}" class="fas fa-edit cus-poi edit_benefit"></i> <i data-id="{{$item->id}}" class="fas fa-trash-alt cus-poi ml-10 delete_benefit"></i>
                </p></td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

