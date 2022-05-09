<section class="banner_part pt-5">
    <div class="container">
      <div class="row">
        @if($menus->count())
        <div class="col-xl-3 col-lg-4 col-md-6 d-none d-lg-block">
          <div class="side-menu animate-dropdown outer-bottom-xs">
            <nav class="spn megamenu-horizontal">

              <ul class="nav">
                @foreach($menus->where('status', 1) as $key => $menu)

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
                                      <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="
                                        @if($element->link != null)
                                          {{url($element->link)}}
                                          @else
                                          javascript:void(0);
                                          @endif
                                        ">{{ \Illuminate\Support\Str::limit($element->title, 25, $end='...') }}</a></li>

                                        @elseif($element->type == 'category' && $element->category->status == 1)
                                        <li><a target="{{$element->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => @$element->category->slug, 'item' =>'category'])}}">
                                          {{ ucfirst(\Illuminate\Support\Str::limit($element->title, 25, $end='...')) }}
                                        </a></li>

                                        @elseif(@$element->type == 'product' && $element->product)
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
                                    <a target="{{$item->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => @$item->category->slug, 'item' =>'category'])}}" class="menu_product">
                                        <div class="single_mega_menu_product">
                                          <div class="media align-items-center">
                                            <div class="media_img">
                                              <img src="{{asset(asset_path(@$item->category->categoryImage->image?@$item->category->categoryImage->image:'frontend/default/img/default_category.png'))}}"class="align-self-center"alt="{{@$item->category->name}}"/>
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
                                    <a target="{{$item->is_newtab == 1?'_blank':''}}" href="{{route('frontend.category-product',['slug' => @$item->brand->slug, 'item' =>'brand'])}}" class="single_product_logo">
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
          <!-- /.side-menu -->
        </div>
        @endif
        <div class="col-xl-9 col-lg-8">
          <div class="row">
            @php
              $headerSliderSection = $headers->where('type','slider')->first();
              $headerCategorySection = $headers->where('type','category')->first();
              $headerProductSection = $headers->where('type','product')->first();
              $headerNewUserZoneSection = $headers->where('type','new_user_zone')->first();
            @endphp
            <div id="slider" class="
              @if($headerSliderSection->column_size == '1 column')
              col-xl-2 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '2 column')
              col-xl-2 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '3 column')
              col-xl-3 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '4 column')
              col-xl-4 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '5 column')
              col-xl-5 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '6 column')
              col-xl-6 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '7 column')
              col-xl-7 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '8 column')
              col-xl-8 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '9 column')
              col-xl-9 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '10 column')
              col-xl-10 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '11 column')
              col-xl-11 col-lg-12 col-md-12
              @elseif($headerSliderSection->column_size == '12 column')
              col-xl-12 col-lg-12 col-md-12
              @endif
              {{$headerSliderSection->is_enable == 0?'d-none':''}}
            ">
            <div class="banner_slider owl-carousel">
              @php
                  $sliders = $headerSliderSection->sliders();
              @endphp
              @if(count($sliders) > 0)
                @foreach($sliders as $key => $slider)
                <div class="single_banner_slider">
                  <div class="row align-items-center">

                    <a href="
                      @if($slider->data_type == 'url')
                        {{$slider->url}}
                      @elseif($slider->data_type == 'product')
                      {{route('frontend.item.show',@$slider->product->slug)}}
                      @elseif($slider->data_type == 'category')
                      {{route('frontend.category-product',['slug' => @$slider->category->slug, 'item' =>'category'])}}
                      @elseif($slider->data_type == 'brand')
                      {{route('frontend.category-product',['slug' => @$slider->brand->slug, 'item' =>'brand'])}}
                      @elseif($slider->data_type == 'tag')
                      {{route('frontend.category-product',['slug' => @$slider->tag->name, 'item' =>'tag'])}}
                      @else
                      {{url('/category')}}
                      @endif

                    " {{$slider->is_newtab == 1?'target="_blank"':''}} class="slider_img_div">
                      <img src="{{asset(asset_path($slider->slider_image))}}" alt="{{$slider->name}}">
                    </a>
                  </div>
                </div>
                @endforeach
              @endif

            </div>
          </div>



          {{-- category section --}}

          <div id="category" class="
          @if($headerCategorySection->column_size == '1 column')
          col-xl-2 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '2 column')
          col-xl-2 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '3 column')
          col-xl-3 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '4 column')
          col-xl-4 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '5 column')
          col-xl-5 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '6 column')
          col-xl-6 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '7 column')
          col-xl-7 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '8 column')
          col-xl-8 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '9 column')
          col-xl-9 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '10 column')
          col-xl-10 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '11 column')
          col-xl-11 col-lg-12 col-md-12
          @elseif($headerCategorySection->column_size == '12 column')
          col-xl-12 col-lg-12 col-md-12
          @endif
           {{$headerCategorySection->is_enable == 0?'d-none':''}}
          ">
            <div class="banner_product_item justify-content-between">

              @foreach($headerCategorySection->categorySectionItems() as $key => $item)
              <div class="single_product_item">
                <a {{$item->is_newtab == 1?'target="_blank"':''}} href="{{route('frontend.category-product',['slug' => $item->category->slug, 'item' =>'category'])}}">
                  <div class="single_product_item_iner">
                    <div class="header_img_category_div">
                        <img
                        src="{{asset(asset_path(@$item->category->categoryImage->image?@$item->category->categoryImage->image:'frontend/default/img/default_category.png'))}}"
                        alt="{{$item->title}}"
                      />
                    </div>
                    <p class="header_category_name">{{\Illuminate\Support\Str::limit($item->title, 15, $end='...')}}</p>
                  </div>

                </a>
              </div>
              @endforeach

            </div>
          </div>

          {{-- product sectiuon --}}
          <div id="product" class="
          @if($headerProductSection->column_size == '1 column')
          col-xl-1 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '2 column')
          col-xl-2 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '3 column')
          col-xl-3 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '4 column')
          col-xl-4 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '5 column')
          col-xl-5 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '6 column')
          col-xl-6 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '7 column')
          col-xl-7 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '8 column')
          col-xl-8 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '9 column')
          col-xl-9 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '10 column')
          col-xl-10 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '11 column')
          col-xl-11 col-lg-12 col-md-12
          @elseif($headerProductSection->column_size == '12 column')
          col-xl-12 col-lg-12 col-md-12
          @endif
          {{$headerProductSection->is_enable == 0?'d-none':''}}
          ">
          @php
              $headerProducts = @$headerProductSection->productSectionItems();
          @endphp
            <div class="banner_product_list d-flex justify-content-between mt-1">
              @foreach($headerProducts as $key => $item)
                <div class="single_banner_product product_price">
                  <a {{$item->is_newtab == 1?'target="_blank"':''}} href="{{route('frontend.item.show',@$item->product->slug)}}" class="product_img">
                    <img
                      src="{{asset(asset_path(@$item->product->product->thumbnail_image_source))}}"
                      alt="#"
                      class="img-fluid"
                    />
                  </a>
                  <div class="product_text">
                    <a {{$item->is_newtab == 1?'target="_blank"':''}} href="{{route('frontend.item.show',@$item->product->slug)}}" class="product_btn">

                      @if(@$item->product->hasDeal)
                        {{single_price(selling_price(@$item->product->skus->first()->selling_price,@$item->product->hasDeal->discount_type,@$item->product->hasDeal->discount))}}
                      @else
                        @if(@$item->product->hasDiscount == 'yes')
                        {{single_price(selling_price(@$item->product->skus->first()->selling_price,@$item->product->discount_type,@$item->product->discount))}}
                        @else
                          {{single_price(@$item->product->skus->first()->selling_price)}}
                        @endif

                      @endif

                    </a>
                    <a {{$item->is_newtab == 1?'target="_blank"':''}} href="{{route('frontend.item.show',@$item->product->slug)}}"><p>{{\Illuminate\Support\Str::limit($item->title, 12, $end='...')}}</p></a>
                  </div>
                </div>
              @endforeach

              </div>
            </div>
            {{-- new user zone section --}}
            <div id="new_user_zone" class="
            @if($headerNewUserZoneSection->column_size == '1 column')
              col-xl-2 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '2 column')
              col-xl-2 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '3 column')
              col-xl-3 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '4 column')
              col-xl-4 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '5 column')
              col-xl-5 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '6 column')
              col-xl-6 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '7 column')
              col-xl-7 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '8 column')
              col-xl-8 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '9 column')
              col-xl-9 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '10 column')
              col-xl-10 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '11 column')
              col-xl-11 col-lg-12 col-md-12
              @elseif($headerNewUserZoneSection->column_size == '12 column')
              col-xl-12 col-lg-12 col-md-12
              @endif
              {{$headerNewUserZoneSection->is_enable == 0?'d-none':''}}
            ">
            @php
              $new_user_zone = $headerNewUserZoneSection->newUserZonePanel();
            @endphp
            @isset($new_user_zone->newUserZone->slug)
                <a href="{{route('frontend.new-user-zone',@$new_user_zone->newUserZone->slug)}}" class="user_cupon d-sm-none d-xl-block">
                <h4>{{@$new_user_zone->navigation_label}}</h4>
                <div class="user_cupon_iner">
                    <div class="user_cupon_tittle"><span>{{@$new_user_zone->pricing}}</span></div>
                    <div class="user_cupon_details">
                    <p>{{\Illuminate\Support\Str::limit($new_user_zone->title, 16, $end='...')}}</p>

                    </div>
                </div>
                </a>
            @endisset
          </div>
          </div>

        </div>
      </div>
    </div>
  </section>
