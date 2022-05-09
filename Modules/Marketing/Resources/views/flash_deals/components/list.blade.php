<div class="row">
    <div class="col-lg-12">
        <table class="table Crm_table_active3">
            <thead>
                <tr>
                    <th scope="col">{{ __('common.sl') }}</th>
                    <th scope="col">{{ __('common.title') }}</th>
                    <th scope="col">{{ __('common.banner') }}</th>
                    <th scope="col">{{ __('common.start_date') }}</th>
                    <th scope="col">{{ __('common.end_date') }}</th>
                    <th scope="col">{{ __('common.page') }} {{__('common.link')}}</th>
                    <th scope="col">{{ __('common.status') }}</th>
                    <th scope="col">{{ __('common.featured') }}</th>
                    <th scope="col">{{ __('common.action') }}</th>
                </tr>
            </thead>
            <tbody>
               @foreach($DealList as $key => $deal)
               <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $deal->title }}</td>
                <td>
                    <div class="banner_img_div">
                        @if ($deal->banner_image != null)
                            <img class="banner_height" src="{{showImage($deal->banner_image)}}" alt="{{$deal->banner_image}}">
                        @else
                            <img class="banner_height" src="{{showImage('frontend/img/no_image.png')}}" alt="">
                        @endif
                    </div>
                </td>
                <td>{{date('d-m-Y',strtotime($deal->start_date))}}</td>
                <td>{{date('d-m-Y',strtotime($deal->end_date))}}</td>
                <td><a href="{{url('/flash-deal'.'/'.$deal->slug)}}">/flash-deal/{{$deal->slug}}</a></td>
                <td>
                    <label class="switch_toggle" for="checkbox_{{ $deal->id }}">
                        <input type="checkbox" id="checkbox_{{ $deal->id }}" {{$deal->status?'checked':''}} @if (permissionCheck('marketing.flash-deals.status'))  value="{{$deal->id}}" data-id="{{$deal->id}}" class="changeStatus" @endif>
                        <div class="slider round"></div>
                    </label>
                </td>
                <td>
                    <label class="switch_toggle" for="checkbox{{ $deal->id }}">
                        <input type="checkbox" id="checkbox{{ $deal->id }}" {{$deal->is_featured?'checked':''}} @if (permissionCheck('marketing.flash-deals.featured')) value="{{$deal->id}}" data-id="{{$deal->id}}" class="changeFeatured" @endif>
                        <div class="slider round"></div>
                    </label>
                </td>
                <td>
                    @if (permissionCheck('marketing.flash-deals.edit') || permissionCheck('marketing.flash-deals.delete'))
                        <!-- shortby  -->
                        <div class="dropdown CRM_dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('common.select') }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                @if (permissionCheck('marketing.flash-deals.edit'))
                                    <a href="{{ route('marketing.flash-deals.edit', $deal->id) }}" class="dropdown-item edit_brand">{{ __('common.edit') }}</a>
                                @endif
                                @if (permissionCheck('marketing.flash-deals.delete'))
                                    <a class="dropdown-item delete_deal" data-id="{{ $deal->id }}">{{ __('common.delete') }}</a>
                                @endif
                            </div>
                        </div>
                        <!-- shortby  -->
                    @else
                        <button class="primary_btn_2" type="button">{{ __('common.no_action_permitted') }}</button>
                    @endif
                </td>
            </tr>
               @endforeach
            </tbody>
        </table>
    </div>

</div>
