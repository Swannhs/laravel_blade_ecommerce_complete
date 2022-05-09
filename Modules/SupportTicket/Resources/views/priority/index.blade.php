@extends('backEnd.master')

@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.priority')])
        <div class="container-fluid p-0">
            <div class="row">

                @csrf
                <div id="form_div" class="col-lg-3">
                    @include('supportticket::priority.components.create')
                </div>

                <div class="col-lg-9">

                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 no-gutters">
                                    <div class="main-title">
                                        <h3 class="mb-30">{{ __('ticket.priority_list') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div id="item_table">
                                @include('supportticket::priority.components.list')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@include('supportticket::priority.components.scripts')
