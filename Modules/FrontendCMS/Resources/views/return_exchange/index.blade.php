@extends('backEnd.master')
@section('mainContent')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title">
                            <h3 class="mb-0">{{ __('frontendCms.return&exchange') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        @include('frontendcms::return_exchange.components.form')
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection


@include('frontendcms::return_exchange.components.scripts')
