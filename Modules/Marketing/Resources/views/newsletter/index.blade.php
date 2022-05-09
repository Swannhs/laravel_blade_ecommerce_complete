@extends('backEnd.master')

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        @include('backEnd.partials._deleteModalForAjax',['item_name' => __('marketing.news_letter')])
        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('marketing.news_letter') }} {{__('common.list')}}</h3>
                            @if (permissionCheck('marketing.news-letter.create'))
                                <ul class="d-flex">
                                    <li><a href="{{ route('marketing.news-letter.create') }}" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="ti-plus"></i>{{ __('common.add_new') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div id="item_table">
                                @include('marketing::newsletter.components.list')
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection

@include('marketing::newsletter.components._scripts')
