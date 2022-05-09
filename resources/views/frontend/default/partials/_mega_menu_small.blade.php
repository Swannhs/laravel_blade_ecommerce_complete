<div class="side-menu animate-dropdown outer-bottom-xs single_page_menu">

    <nav class="spn megamenu-horizontal" >
  
      <ul class="nav">
        @foreach($menus as $key => $menu)
          @if($menu->menu_type == 'multi_mega_menu')
          <h4>{{ \Illuminate\Support\Str::limit($menu->name, 25, $end='...') }}</h4>
          <ul class="nav nav_width">
            @foreach(@$menu->menus as $key => $menu)
            @if(@$menu->menu->menu_type == 'mega_menu' && @$menu->menu->status == 1)
            <li class="dropdown menu-item">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="{{@$menu->menu->icon}}"></i>{{ \Illuminate\Support\Str::limit(@$menu->menu->name, 25, $end='...') }}</a>
              <ul class="dropdown-menu mega-menu">
                <li class="spn-content">
                  <div class="row ">
                    <div class="col-sm-12 col-md-12 col-xl-8">
                      <div class="row">
                        @php
                            $is_same = 1;
                            $column_size = $menu->menu->columns[0]->size;
  
                            foreach($menu->menu->columns as $key => $column){
                              if($column->size != $column_size){
                                $is_same =0;
                              }
                            }
  
                        @endphp
  
  
                          @foreach(@$menu->menu->columns as $key => $column)
                          <div class="
                          @if($column->size == '1/1')
                          col-sm-12 col-md-12 col-lg-12 col-xl-12
                          @elseif($column->size == '1/2')
                          col-sm-12 col-md-6 col-lg-6 col-xl-6
                          @elseif($column->size == '1/3')
                          col-sm-6 col-md-6 col-lg-4 col-xl-4
                          @elseif($column->size == '1/4')
                          col-sm-6 col-md-6 col-lg-3 col-xl-3
                          @endif
                          ">
                          <ul class="links list-unstyled">
                            <li><span>{{ \Illuminate\Support\Str::limit($column->column, 25, $end='...') }}</span></li>
                            @foreach(@$column->elements as $key => $element)
                            @if($element->type == 'link')
                              <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="@if($element->link != null)
                                {{url($element->link)}}
                                @else
                                javascript:void(0);
                                @endif">{{\Illuminate\Support\Str::limit($element->title, 25, $end='...')}}</a></li>
  
                              @elseif($element->type == 'category' && $element->category->status == 1)
                                <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => @$element->category->slug, 'item' =>'category'])}}">{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a></li>
  
                              @elseif(@$element->type == 'product' && @$element->product)
                              <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="{{route('frontend.item.show',@$element->product->slug)}}">{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a></li>
  
                              @elseif($element->type == 'brand' && $element->brand->status == 1)
                              <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => @$element->brand->slug, 'item' =>'brand'])}}">{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a></li>
  
                              @elseif($element->type == 'page' && $element->page->status == 1)
                                      @if(!isModuleActive('Lead') && $element->page->module == 'Lead')
                                          @continue
                                      @endif
                              <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="{{ url(@$element->page->slug) }}">{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a></li>
  
                              @elseif($element->type == 'tag')
                              <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => @$element->tag->name, 'item' =>'tag'])}}">{{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}</a></li>
  
                              @endif
  
                            @endforeach
  
                          </ul>
                          </div>
  
                          @endforeach
                      </div>
                    </div>
                    @if(count(@$menu->menu->rightPanelData)> 0)
                    <div class="col-sm-12 col-xl-4 d-none d-xl-block">
                      <div class="mega_menu_product">
                        @foreach(@$menu->menu->rightPanelData as $key => $item)
                        @if($item->category->status == 1)
                          <a target="{{$item->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => encrypt(@$item->category->id), 'item' =>'category'])}}" class="menu_product">
                              <div class="single_mega_menu_product">
                                <div class="media align-items-center">
                                  <div class="media_img">
                                    <img src="{{asset(asset_path(@$item->category->categoryImage->image?@$item->category->categoryImage->image:'frontend//default/img/default_category.png'))}}"class="align-self-center"alt="{{@$item->category->name}}"/>
                                  </div>
                                  <div class="media-body">
                                    <p>{{$item->title}}</p>
                                  </div>
                                </div>
                              </div>
                          </a>
                          @if($key >=5)
                            @break
                          @endif
                        @endif
                        @endforeach
  
  
                      </div>
                    </div>
                    @endif
                    @if(count(@$menu->menu->bottomPanelData)> 0)
                    <div class="col-lg-12 d-none d-xl-block">
                      <div class="product_logo">
                        @foreach(@$menu->menu->bottomPanelData as $key => $item)
                        @if($item->brand->status == 1)
                          <a target="{{$item->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => encrypt(@$item->brand->id), 'item' =>'brand'])}}" class="single_product_logo">
                            <img src="{{ asset(asset_path(@$item->brand->logo ? @$item->brand->logo:'frontend/default/img/brand_image.png')) }}" alt="{{@$item->brand->name}}" />
                          </a>
                          @if($key >=7)
                            @break
                          @endif
                        @endif
                        @endforeach
                      </div>
                    </div>
                    @endif
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </li>
                <!-- /.spn-content -->
              </ul>
              <!-- /.dropdown-menu -->
            </li>
            @endif
            @endforeach
            <!-- /.menu-item -->
          </ul>
          @endif
        <!-- /.menu-item -->
        @endforeach
  
      </ul>
      <!-- /.nav -->
    </nav>
      <!-- /.megamenu-horizontal -->
  
  </div>
  