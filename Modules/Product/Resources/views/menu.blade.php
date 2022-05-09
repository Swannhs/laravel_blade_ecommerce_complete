@if (permissionCheck('product_module'))
    @php
        $product_admin = false;
        if(request()->is('products/*') || request()->is('products') || request()->is('seller/product') || request()->is('seller/products/create') || request()->is('admin/inhouse/product') || request()->is('admin/inhouse/products/create'))
        {
            $product_admin = true;
        }
    @endphp
    <li class="{{ $product_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,12)->position }}" data-status="{{ menuManagerCheck(1,12)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $product_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fa fa-product-hunt"></span>
            </div>
            <div class="nav_title">
                <span>{{__('product.products')}}</span>
            </div>
        </a>
        <ul id="product_ul">
            @if (auth()->check() && auth()->user()->role->type == "superadmin" || auth()->check() && auth()->user()->role->type == "admin" || auth()->check() && auth()->user()->role->type == "staff")
                @if (permissionCheck('product.category.index') && menuManagerCheck(2,12,'product.category.index')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.category.index')->position }}">
                        <a href="{{ route('product.category.index') }}" @if (strpos(request()->getUri(),'category') != false) class="active" @endif>{{__('product.category')}}</a>
                    </li>
                @endif
                @if (permissionCheck('product.brands.index') && menuManagerCheck(2,12,'product.brands.index')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.brands.index')->position }}">
                        <a href="{{ route('product.brands.index') }}" @if (strpos(request()->getUri(),'brands-list') != false || strpos(request()->getUri(),'bulk-brand-upload') != false) class="active" @endif>{{__('product.brand')}}</a>
                    </li>
                @endif
                @if (permissionCheck('product.attribute.index') && menuManagerCheck(2,12,'product.attribute.index')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.attribute.index')->position }}">
                        <a href="{{ route('product.attribute.index') }}" @if (strpos(request()->getUri(),'attribute-list') != false) class="active" @endif>{{__('product.attribute')}}</a>
                    </li>
                @endif
                @if (permissionCheck('product.units.index') && menuManagerCheck(2,12,'product.units.index')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.units.index')->position }}">
                        <a href="{{ route('product.units.index') }}" @if (strpos(request()->getUri(),'units') != false) class="active" @endif>{{__('product.units')}}</a>
                    </li>
                @endif
                @if (permissionCheck('product.create') && menuManagerCheck(2,12,'product.create')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.create')->position }}">
                        <a href="{{ route('product.create') }}" @if (request()->is('product/create')) class="active" @endif>{{__('product.add_new_product')}}</a>
                    </li>
                @endif
                @if (permissionCheck('product.bulk_product_upload_page') && menuManagerCheck(2,12,'product.bulk_product_upload_page')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.bulk_product_upload_page')->position }}">
                        <a href="{{ route('product.bulk_product_upload_page') }}" @if (strpos(request()->getUri(),'bulk-product-upload') != false) class="active" @endif>{{__('product.bulk_product_upload')}}</a>
                    </li>
                @endif
                @if (permissionCheck('product.index') && menuManagerCheck(2,12,'product.index')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.index')->position }}">
                        <a href="{{ route('product.index') }}" @if (request()->is('product')) class="active" @endif>{{__('product.product_list')}}</a>
                    </li>
                @endif
                
                @if(isModuleActive('MultiVendor'))
                    @if (permissionCheck('admin.my-product.index') && menuManagerCheck(2,12,'admin.my-product.index')->status == 1)
                        <li data-position="{{ menuManagerCheck(2,12,'admin.my-product.index')->position }}">
                            <a href="{{ route('admin.my-product.index') }}" @if (request()->is('admin/inhouse/product') || request()->is('admin/inhouse/products/create')) class="active" @endif>{{__('product.inhouse_product_list')}}</a>
                        </li>
                    @endif
                @endif
                @if (permissionCheck('product.recent_view_product_config') && menuManagerCheck(2,12,'product.recent_view_product_config')->status == 1)
                    <li data-position="{{ menuManagerCheck(2,12,'product.recent_view_product_config')->position }}">
                        <a href="{{ route('product.recent_view_product_config') }}" @if (strpos(request()->getUri(),'recently-view-product-config') != false) class="active" @endif>{{__('product.recent_view_config')}}</a>
                    </li>
                @endif
            @endif
        </ul>
    </li>
@endif
