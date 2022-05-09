@isset ($brandList)
    @if (count($brandList) > 0)
        <div class="single_category">
            <div class="category_tittle">
                <h4>{{ __('common.brand') }}</h4>
            </div>
            <div class="single_category_option">
                <nav>
                    <ul>
                        @foreach($brandList as $key => $brand)
                        <li class='sub-menu'><a class="getProductByChoice" data-id="brand" data-value="{{ $brand->id }}" >{{$brand->name}}<div class='ti-plus right'></div></a></li>
                        @endforeach

                    </ul>
                </nav>
            </div>
        </div>
    @endif
@endisset
