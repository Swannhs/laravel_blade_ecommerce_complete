@foreach ($brands as $key => $brand)
    <tr class="row1" data-id="{{ $brand->id }}">
        <th class="pl-3"><i class="fa fa-sort"></i></th>
        <td>{{ $brand->name }}</td>
        <td>
            <div class="logo_div">
                @if ($brand->logo != null)
                    <img src="{{showImage($brand->logo)}}" alt="{{$brand->name}}">
                @else
                    <img src="{{showImage('frontend/default/img/brand_image.png')}}" alt="{{@$productSku->product->product_name}}">
                @endif
            </div>
        </td>
        <td>
            <label class="switch_toggle" for="checkbox{{ $brand->id }}">
                <input type="checkbox" id="checkbox{{ $brand->id }}" @if ($brand->status == 1) checked @endif value="{{ $brand->id }}" data-id="{{$brand->id}}" class="status_change">
                <div class="slider round"></div>
            </label>
        </td>
        <td>
            <label class="switch_toggle" for="active_checkbox{{ $brand->id }}">
                <input type="checkbox" id="active_checkbox{{ $brand->id }}" @if ($brand->featured == 1) checked @endif value="{{ $brand->id }}" data-id="{{$brand->id}}" class="featured_change">
                <div class="slider round"></div>
            </label>
        </td>
        <td>
            <!-- shortby  -->
            <div class="dropdown CRM_dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('common.select') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                    @if (permissionCheck('product.brand.edit'))
                        <a class="dropdown-item edit_brand" href="{{ route('product.brand.edit', $brand->id) }}">{{__('common.edit')}}</a>
                    @endif
                    @if (permissionCheck('product.brand.destroy'))
                        <a class="dropdown-item delete_brand" data-value="{{route('product.brand.destroy', $brand->id)}}">{{__('common.delete')}}</a>
                    @endif
                </div>
            </div>
            <!-- shortby  -->
        </td>
    </tr>
@endforeach
