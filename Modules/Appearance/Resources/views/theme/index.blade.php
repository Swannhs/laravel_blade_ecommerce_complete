@extends('backEnd.master')

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/appearance/css/theme.css'))}}" />

@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between">
                            <h3 class="mb-0 mr-30">{{ __('appearance.themes') }}</h3>
                            @if (permissionCheck('appearance.themes.store'))
                                <ul class="d-flex">
                                <li><a class="primary-btn radius_30px mr-10 fix-gr-bg text-white" href="{{route('appearance.themes.create')}}" dusk="Add New"><i class="ti-plus"></i>{{__('common.add_new')}}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 item_section">
                            <div class="card default_card_border theme_full_100">

                                <div class="card-body screenshot p-0 flex-fill">
                                    <div class="single_item_img_div">
                                        <img src="{{ showImage($activeTheme->image) }}" alt="">
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <h4>{{$activeTheme->name}}</h4>
                                        </div>
                                        @if($activeTheme->is_active !=1 )
                                        <div class="col-lg-7 footer_div">
                                            <div class="row btn_div">
                                                <div class="col-md-5 col-sm-12">
                                                    @if (permissionCheck('appearance.themes.active'))
                                                        <form action="{{route('appearance.themes.active')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$activeTheme->id}}">
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary Active_btn">{{__('common.active')}}</button>
                                                        </form>
                                                    @endif
                                                </div>
                                                <div class="col-md-7 col-sm-12 p_l_0">
                                                <a class="btn btn-sm btn-outline-secondary Active_btn" target="_blank" href="{{$activeTheme->live_link}}">{{__('appearance.live_preview')}}</a>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @if (permissionCheck('appearance.themes.show'))
                                    <div class="text-center detail_btn">
                                    <h4><a href="{{route('appearance.themes.show',$activeTheme->id)}}">{{__('appearance.theme_details')}}</a></h4>
                                    </div>
                                @endif
                            </div>


                        </div>

                        @foreach($ThemeList as $key => $item)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 item_section">
                            <div class="card theme_full_100">

                                <div class="card-body screenshot p-0 flex-fill">
                                    <div class="single_item_img_div">
                                        <img src="{{ showImage($item->image) }}" alt="">
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <h4>{{$item->name}}</h4>
                                        </div>

                                        <div class="col-lg-7 col-md-7 footer_div d-flex justify-content-end  ">


                                            @if (permissionCheck('appearance.themes.active'))
                                                <form action="{{route('appearance.themes.active')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary Active_btn mr-2">{{__('common.active')}}</button>
                                                </form>
                                            @endif
                                            <a class="btn btn-sm btn-outline-secondary Active_btn" target="_blank" href="{{$item->live_link}}">{{__('appearance.live_preview')}}</a>



                                        </div>

                                    </div>
                                </div>
                                @if (permissionCheck('appearance.themes.show'))
                                    <div class="text-center detail_btn">
                                        <h4><a href="{{route('appearance.themes.show',$item->id)}}" dusk="view details">{{__('appearance.theme_details')}}</a></h4>
                                    </div>
                                @endif
                            </div>


                        </div>
                        @endforeach

                        @if (permissionCheck('appearance.themes.store'))
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                <a href="{{route('appearance.themes.create')}}" class="theme_full_100 d-flex align-items-center justify-content-center " id="add_new" >
                                    <span id="plus"><i class="fas fa-plus"></i></span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
