@extends('backEnd.master')

@section('mainContent')
@include('backEnd.partials._deleteModalForAjax',['item_name' => __('contactRequest.contact_mail')])
<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('contactRequest.contact_mail') }}</h3>


                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table">
                        <div class="" id="item_table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="student-meta-box">
                    <div class="white-box">
                        <div class="single-meta mt-10">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    {{ __('common.name') }} : {{$contact->name}}
                                </div>
                                <div class="value">

                                </div>
                            </div>
                        </div>

                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    {{ __('common.email') }} : {{$contact->email}}
                                </div>
                                <div class="value">

                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    {{ __('common.message') }} : {{$contact->message}}
                                </div>
                                <div class="value">

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!-- End Student Meta Information -->
            </div>
        </div>
    </div>

</section>
@endsection
