@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/footersetting/css/style.css'))}}" />

@endsection
@section('mainContent')
    @php
        if(\Session::has('footer_tab')){
            $footerTab = \Session::get('footer_tab');
        }else{
            $footerTab = 1;
        }
    @endphp

    <section class="mb-40 student-details up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-md-12 mb-20">
                            <div class="box_header_right">
                                <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                                    <ul class="nav" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ $footerTab == 1?'active':'' }} show active_section_class" href="#copyrightText" role="tab" data-toggle="tab" id="1" data-id="1"
                                                aria-selected="true">{{__('frontendCms.copyright_text')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $footerTab == 2?'active':'' }} show active_section_class" href="#footer_1" role="tab" data-toggle="tab" id="2" data-id="2"
                                                aria-selected="false">{{__('frontendCms.about_text')}}</a>
                                        </li>
                                        <li class="nav-item" id="company_tab">
                                            <a class="nav-link {{ $footerTab == 3?'active':'' }} show active_section_class" href="#footer_2" role="tab" data-toggle="tab" id="3" data-id="3"
                                                aria-selected="false">{{$FooterContent->footer_section_one_title}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $footerTab == 4?'active':'' }} show active_section_class" href="#footer_3" role="tab" data-toggle="tab" id="4" data-id="4"
                                                aria-selected="true">{{$FooterContent->footer_section_two_title}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ $footerTab == 5?'active':'' }} show active_section_class" href="#footer_4" role="tab" data-toggle="tab" id="5" data-id="5" aria-selected="true">{{$FooterContent->footer_section_three_title}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade {{ $footerTab == 1?'active show':'' }} " id="copyrightText">
                                    <div class="col-lg-12">
                                        <div class="main-title">
                                            <h3 class="mb-30">
                                                {{__('common.update')}} </h3>
                                        </div>

                                        <form method="POST" action="" id="copyright_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="white-box">
                                                <div class="add-visitor">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="primary_input mb-35">
                                                                <input type="hidden" name="id" value="{{$FooterContent->id}}">

                                                                <textarea required name="copy_right" placeholder="{{ __('common.copyright') }}" class="lms_summernote"
                                                                    id="copy_right">{{$FooterContent->footer_copy_right}}</textarea>
                                                            </div>
                                                            <span class="text-danger" id="error_copy_right">
                                                        </div>
                                                    </div>
                                                    @if (permissionCheck('copyright_content_update'))
                                                        <div class="row mt-40">
                                                            <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                                        data-original-title="" title="">
                                                                        <button class="primary-btn fix-gr-bg tooltip-wrapper " id="copyrightBtn">
                                                                            <span class="ti-check"></span>
                                                                            {{__('common.update')}} </button>
                                                                    </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div role="tabpanel" class="tab-pane {{ $footerTab == 2?'active show':'' }} fade" id="footer_1">

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="col-lg-12">
                                                <div class="main-title">
                                                    <h3 class="mb-30">
                                                        {{__('common.update')}} </h3>
                                                </div>

                                                <form method="POST" action="" id="aboutForm"
                                                    accept-charset="UTF-8" class="form-horizontal"
                                                    enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="{{$FooterContent->id}}">
                                                    <div class="white-box">
                                                        <div class="add-visitor">
                                                            <div class="row">
                                                                <div class="col-lg-12">

                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="about_title">{{__('frontendCms.section_name')}} <span class="text-danger">*</span></label>
                                                                        <input name="about_title" id="about_title" class="primary_input_field" placeholder="-" type="text"
                                                                               value="{{ old('about_title') ? old('about_title') : $FooterContent->footer_about_title }}">
                                                                    </div>
                                                                    <span class="text-danger"  id="error_about_title"></span>

                                                                </div>
                                                            </div>
                                                            @if (permissionCheck('about_content_update'))
                                                                <div class="row mt-40">
                                                                    <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                                        data-original-title="" title="">
                                                                        <button class="primary-btn fix-gr-bg tooltip-wrapper " id="aboutSectionBtn"
                                                                            data-original-title="" title="">
                                                                            <span class="ti-check"></span>
                                                                            {{__('common.update')}} </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 mt-50">
                                            <form method="POST" action=""
                                                accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"
                                                id="aboutDescriptionForm">
                                                <input type="hidden" name="id" value="{{$FooterContent->id}}">
                                                <div class="white-box">
                                                    <div class="row justify-content-center mb-30 mt-40">
                                                        <div class="col-lg-12">

                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label" for="about_description">{{__('frontendCms.about_description')}} <span class="text-danger">*</span></label>
                                                                <textarea class="primary_input form-control read-only-input"
                                                                          name="about_description" required
                                                                          id="about_description">{{$FooterContent->footer_about_description}}</textarea>
                                                            </div>
                                                            <span class="text-danger"  id="error_about_description"></span>
                                                        </div>
                                                    </div>
                                                    @if (permissionCheck('company_content_update'))
                                                        <div class="row mt-30">
                                                            <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                                data-original-title="" title="">
                                                                <button class="primary-btn fix-gr-bg tooltip-wrapper " id="aboutDescriptionBtn"
                                                                    data-original-title="" title="">
                                                                    <span class="ti-check"></span>
                                                                    {{__('common.update')}} </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @if (permissionCheck('footerSetting.footer.widget-store'))
                                    @include('footersetting::footer.components.widget_create')
                                @endif

                                <div role="tabpanel" class="tab-pane {{ $footerTab == 3?'active show':'' }} fade" id="footer_2">
                                    <div class="row">
                                        <div class="col-lg-3 mt-30">
                                            <div class="col-lg-12">
                                                <div class="main-title">
                                                    <h3 class="mb-30">
                                                        {{__('common.update')}} </button> </h3>
                                                </div>
                                                <form method="POST" action=""
                                                    accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"
                                                    id="companyForm">
                                                    <input type="hidden" name="id" value="{{$FooterContent->id}}">
                                                    <div class="white-box">
                                                        <div class="add-visitor">
                                                            <div class="row">
                                                                <div class="col-lg-12">

                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="company_title">{{__('frontendCms.section_name')}} <span class="text-danger">*</span></label>
                                                                        <input name="company_title" class="primary_input_field" placeholder="-" type="text" required
                                                                               value="{{ old('company_title') ? old('company_title') : $FooterContent->footer_section_one_title }}">
                                                                    </div>
                                                                    <span class="text-danger"  id="error_company_title"></span>
                                                                </div>
                                                            </div>
                                                            @if (permissionCheck('company_content_update'))
                                                                <div class="row mt-40">
                                                                    <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                                        data-original-title="" title="">
                                                                        <button class="primary-btn fix-gr-bg tooltip-wrapper "
                                                                            data-original-title="" title="" id="companyBtn">
                                                                            <span class="ti-check"></span>
                                                                            {{__('common.update')}} </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 mt-50">
                                            @if (permissionCheck('footerSetting.footer.widget-store'))
                                                <a href="" data-id="1" id="add_new_page_btn" class="primary-btn small fix-gr-bg create_page_btn">{{__('frontendCms.add_new_page')}}</a>
                                            @endif

                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table">

                                                    <table class="table Crm_table_active3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" width="15%">{{ __('common.sl') }}</th>
                                                                <th scope="col" width="45%">{{ __('common.name') }}</th>
                                                                <th scope="col" width="15%">{{ __('common.status') }}</th>
                                                                <th scope="col" width="25%">{{ __('common.action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($SectionOnePages as $key => $page)
                                                                <tr>
                                                                    <td>{{$key +1}}</td>
                                                                    <td>{{$page->name}}</td>
                                                                    <td>


                                                                        <label class="switch_toggle" for="checkbox{{ $page->id }}">
                                                                            <input type="checkbox" id="checkbox{{ $page->id }}" {{$page->status?'checked':''}} value="{{$page->id}}" data-value="{{$page}}" class="statusChange">
                                                                            <div class="slider round"></div>
                                                                        </label>
                                                                    </td>
                                                                    <td>

                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                {{ __('common.select') }}
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                                                @if (permissionCheck('footerSetting.footer.widget-update'))
                                                                                    <a class="dropdown-item edit_page" data-value="{{$page}}">{{ __('common.edit') }}</a>
                                                                                @endif
                                                                                @if (permissionCheck('footer.widget-delete'))
                                                                                    <a class="dropdown-item delete_page" data-id="{{$page->id}}">{{ __('common.delete') }}</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div role="tabpanel" class="tab-pane {{ $footerTab == 4?'active show':'' }} fade" id="footer_3">
                                    <div class="row">
                                        <div class="col-lg-3 mt-30">
                                            <div class="col-lg-12">
                                                <div class="main-title">
                                                    <h3 class="mb-30">
                                                        {{ __('common.update') }} </h3>
                                                </div>
                                                <form method="POST" action=""
                                                    accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"
                                                    id="accountForm">
                                                    <input type="hidden" name="id" value="{{$FooterContent->id}}">
                                                    <div class="white-box">
                                                        <div class="add-visitor">
                                                            <div class="row">
                                                                <div class="col-lg-12">

                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="account_title">{{__('frontendCms.section_name')}} <span class="text-danger">*</span></label>
                                                                        <input name="account_title" class="primary_input_field" placeholder="-" type="text" required
                                                                               value="{{ old('account_title') ? old('account_title') : $FooterContent->footer_section_two_title }}">
                                                                    </div>
                                                                    <span class="text-danger"  id="error_account_title"></span>
                                                                </div>
                                                            </div>
                                                            @if (permissionCheck('account_content_update'))
                                                                <div class="row mt-40">
                                                                    <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                                        data-original-title="" title="">
                                                                        <button class="primary-btn fix-gr-bg tooltip-wrapper " id="accountBtn">
                                                                            <span class="ti-check"></span>
                                                                            {{ __('common.update') }} </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 mt-50">
                                            @if (permissionCheck('footerSetting.footer.widget-store'))
                                                <a data-id="2" class="primary-btn small fix-gr-bg create_page_btn">{{__('frontendCms.add_new_page')}}</a>
                                            @endif

                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table">
                                                    <table class="table Crm_table_active3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" width="15%">{{ __('common.sl') }}</th>
                                                                <th scope="col" width="45%">{{ __('common.name') }}</th>
                                                                <th scope="col" width="15%">{{ __('common.status') }}</th>
                                                                <th scope="col" width="25%">{{ __('common.action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($SectionTwoPages as $key => $page)
                                                                <tr>
                                                                    <td>{{$key +1}}</td>
                                                                    <td>{{$page->name}}</td>
                                                                    <td>
                                                                        <label class="switch_toggle" for="checkbox{{ $page->id }}">
                                                                            <input type="checkbox" id="checkbox{{ $page->id }}" {{$page->status?'checked':''}} value="{{$page->id}}" data-value="{{$page}}" class="statusChange">
                                                                            <div class="slider round"></div>
                                                                        </label>
                                                                    </td>
                                                                    <td>

                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                {{ __('common.select') }}
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                                                @if (permissionCheck('footerSetting.footer.widget-update'))
                                                                                    <a data-toggle="modal" data-target="#editModal" class="dropdown-item edit_page" data-value="{{$page}}">{{ __('common.edit') }}</a>
                                                                                @endif
                                                                                @if (permissionCheck('footerSetting.footer.widget-delete'))
                                                                                    <a class="dropdown-item delete_page" data-id="{{$page->id}}">{{ __('common.delete') }}</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div role="tabpanel" class="tab-pane {{ $footerTab == 5?'active show':'' }} fade" id="footer_4">
                                    <div class="row">
                                        <div class="col-lg-3 mt-30">
                                            <div class="col-lg-12">
                                                <div class="main-title">
                                                    <h3 class="mb-30">
                                                        {{__('common.update')}} </h3>
                                                </div>
                                                <form method="POST" action=""
                                                    accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"
                                                    id="serviceForm">
                                                    <input type="hidden" name="id" value="{{$FooterContent->id}}">
                                                    <div class="white-box">
                                                        <div class="add-visitor">
                                                            <div class="row">
                                                                <div class="col-lg-12">

                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="service_title">{{__('frontendCms.section_name')}} <span class="text-danger">*</span></label>
                                                                        <input name="service_title" class="primary_input_field" placeholder="-" type="text" required
                                                                               value="{{ old('service_title') ? old('service_title') : $FooterContent->footer_section_three_title }}">
                                                                    </div>
                                                                    <span class="text-danger"  id="error_service_title"></span>
                                                                </div>
                                                            </div>
                                                            @if (permissionCheck('service_content_update'))
                                                                <div class="row mt-40">
                                                                    <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                                                                        data-original-title="" title="">
                                                                        <button class="primary-btn fix-gr-bg tooltip-wrapper " id="serviceBtn">
                                                                            <span class="ti-check"></span>
                                                                            {{__('common.update')}} </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 mt-50">
                                            @if(permissionCheck('footerSetting.footer.widget-store'))
                                                <a href="" data-id="3" class="primary-btn small fix-gr-bg create_page_btn">{{__('frontendCms.add_new_page')}}</a>
                                            @endif
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table">
                                                    <table class="table Crm_table_active3">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" width="15%">{{ __('common.sl') }}</th>
                                                                <th scope="col" width="45%">{{ __('common.name') }}</th>
                                                                <th scope="col" width="15%">{{ __('common.status') }}</th>
                                                                <th scope="col" width="25%">{{ __('common.action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($SectionThreePages as $key=> $page)
                                                                <tr>
                                                                    <td>{{$key +1}}</td>
                                                                    <td>{{$page->name}}</td>
                                                                    <td>
                                                                        <label class="switch_toggle" for="checkbox{{ $page->id }}">
                                                                            <input type="checkbox" id="checkbox{{ $page->id }}" {{$page->status?'checked':''}} value="{{$page->id}}" data-value="{{$page}}" class="statusChange">
                                                                            <div class="slider round"></div>
                                                                        </label>
                                                                    </td>
                                                                    <td>

                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                {{ __('common.select') }}
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                                                @if (permissionCheck('footerSetting.footer.widget-update'))
                                                                                    <a data-toggle="modal" data-target="#editModal" class="dropdown-item edit_page" data-value="{{$page}}">{{ __('common.edit') }}</a>
                                                                                @endif
                                                                                @if (permissionCheck('footerSetting.footer.widget-delete'))
                                                                                    <a class="dropdown-item delete_page" data-id="{{$page->id}}">{{ __('common.delete') }}</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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
        </div>
        @if (permissionCheck('footerSetting.footer.widget-update'))
            @include('footersetting::footer.components.widget_edit')
        @endif
        @if (permissionCheck('footer.widget-delete'))
            @include('footersetting::footer.components.delete')
        @endif
    </section>

@endsection

@include('footersetting::footer.components.scripts')
