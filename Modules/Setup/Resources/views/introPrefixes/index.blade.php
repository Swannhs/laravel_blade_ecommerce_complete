@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('setup.intro_prefix_list') }}</h3>
                            <ul class="d-flex">
                                <li><button onclick="resetAddForm()" id="add_new_intro" data-toggle="modal" data-target="#IntroPrefix_Add" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="ti-plus"></i>{{ __('setup.add_new_intro_prefix') }}</a></button>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.id') }}</th>
                                        <th scope="col">{{ __('common.name') }}</th>
                                        <th scope="col">{{ __('setup.prefix') }}</th>
                                        <th scope="col">{{ __('common.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($introPrefixes as $key=>$introPrefix)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $introPrefix->title }}</td>
                                            <td>{{ $introPrefix->prefix }}</td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        <a class="dropdown-item edit_prefix" data-id="{{ $introPrefix->id }}">{{__('common.edit')}}</a>
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
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
    </section>
    <div id="edit_form">

    </div>
    @include('setup::introPrefixes.create')
    @include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('click', '#add_new_intro', function(event){
                    document.getElementById("IntroPrefix_addForm").reset();
                });

                $(document).on('click', '.edit_prefix', function(event){
                    let id = $(this).data('id');
                    edit_introPrefix_modal(id);
                });
            });

            function edit_introPrefix_modal(el){
                $.post('{{ route('introPrefix.edit') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                    $('#edit_form').html(data);
                    $('#IntroPrefix_Edit').modal('show');
                }).fail(function(response) {
               if(response.responseJSON.error){
                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                    $('#pre-loader').addClass('d-none');
                    return false;
                }

            });
            }
        })(jQuery);

    </script>
@endpush
