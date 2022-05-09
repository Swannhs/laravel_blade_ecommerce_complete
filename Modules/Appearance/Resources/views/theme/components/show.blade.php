@extends('backEnd.master')

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/appearance/css/theme_show.css'))}}" />

@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header">
                        <div class="main-title d-flex justify-content-between w-100">
                            <h3 class="mb-0 mr-30">{{ __('appearance.theme_details') }}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p_b_80">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="img_div">
                                        <img src="{{ showImage($theme->image) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    @if ($theme->is_active == 1)
                                        <span class="badge badge-info">{{ __('appearance.current_theme') }}</span>
                                    @endif
                                    <div class="name_info_div">
                                        <h2 class="d-inline">{{ $theme->title }}</h2>
                                        <p class="d-inline">{{ __('appearance.version') }}:
                                            {{ $theme->version }}</p>
                                    </div>
                                    <div class="theme_description_div">
                                        <p>{{ $theme->description }}</p>
                                    </div>

                                    <div class="tag_div">
                                        <span><strong>{{ __('appearance.tags') }}: </strong>
                                            {{ $theme->tags }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        @if ($theme->is_active != 1)
                                                <form action="{{ route('appearance.themes.active') }}" method="POST" class="mr-2" >
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $theme->id }}">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-secondary Active_btn">{{ __('common.active') }}</button>
                                                </form>
                                        @endif
                                        <a class="btn btn-sm btn-outline-secondary Active_btn mr-2" target="_blank"
                                                href="{{ $theme->live_link }}">{{ __('appearance.live_preview') }}</a>
                                        <div class="flex-fill d-flex align-items-center justify-content-end">

                                            @if ($theme->is_active != 1)
                                                    <a class="btn btn-sm btn-outline-secondary Active_btn pull-right" id="delete_btn" data-id="{{ $theme->id }}" href="">{{ __('common.delete') }}</a>
                                            @endif
                                        </div>


                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
     {{-- delete modal --}}
    <div class="modal fade" id="deleteItemModal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.delete')}} {{__('appearance.theme')}} </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>{{__('common.are_you_sure_to_delete_?')}}</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{__('common.cancel')}}</button>
                        <form id="item_delete_form" method="POST" action="{{route('appearance.themes.delete')}}">
                            @csrf
                            <input type="hidden" name="id" id="delete_item_id">
                            <button type="submit" id="theme_delete_btn" class="primary-btn fix-gr-bg">{{__('common.delete')}}</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>

        (function($){
            "use strict";

            $(document).ready(function(){
                $(document).on('click', '#delete_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    $('#delete_item_id').val(id);
                    $('#deleteItemModal').modal('show');
                });
            });

        })(jQuery);

    </script>

@endpush
