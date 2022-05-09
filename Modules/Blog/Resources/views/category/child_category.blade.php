<tr>
    <td>{{$key}}</td>
    <td><img class="listImg" src="{{showImage($child_account->image_url??'backend/img/default.png')}}"></td>
    <td>
        @for ($i = 1; $i < $child_account->level; $i++)
            <strong>-</strong>
        @endfor
        <strong>-></strong> {{ $child_account->name }}
    </td>




    <td>
        <div class="dropdown CRM_dropdown">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                @lang('common.select')
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                @if (permissionCheck('blog.categories.edit'))
                    <a class="dropdown-item" href="{{ route('blog.categories.edit', $child_account->id) }}">@lang('common.edit')</a>
                @endif
                @if (permissionCheck('blog.categories.destroy'))
                    <a class="dropdown-item" data-toggle="modal" data-target="#deleteItem_{{ @$child_account->id }}">@lang('common.delete')</a>
                @endif
            </div>
        </div>
    </td>

    <div class="modal fade admin-query" id="deleteItem_{{ @$child_account->id }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('common.delete') @lang('common.category')</h4>
                    <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('common.are_you_sure_to_delete_?')</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                            data-dismiss="modal">@lang('common.cancel')</button>
                        <form action="{{ route('blog.categories.destroy', $child_account->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="primary-btn fix-gr-bg" value="{{__('common.delete')}}" />
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</tr>

@if ($child_account->categories)
    @foreach ($child_account->categories as $child_account)
        @include('blog::category.child_category', ['child_account' => $child_account])
    @endforeach
@endif
