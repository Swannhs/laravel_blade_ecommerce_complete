@extends('backEnd.master')

@section('mainContent')

    <section class="admin-visitor-area up_st_admin_visitor">


        @include('backEnd.partials._deleteModalForAjax',['item_name' => __('seller.supplier'),'form_id' =>
        'supplier_delete_form','modal_id' => 'supplier_delete_modal'])

        <div class="container-fluid p-0">
            <div class="row justify-content-center">

                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('seller.supplier_list') }}</h3>
                            
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg"
                                            href="{{ route('seller.supplier.create') }}"><i
                                                class="ti-plus"></i>{{ __('common.add_new') }}
                                            {{ __('seller.supplier') }}</a></li>
                                </ul>
                            

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="item_table">
                                @include('seller::supplier.components.list')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')

    <script>
        $(document).ready(function() {
            $(document).on('submit', '#supplier_delete_form', function(event) {
                event.preventDefault();
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());
                let id = $('#delete_item_id').val();
                $.ajax({
                    url: "{{ route('seller.supplier.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.SupplierList);
                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}")
                        $('#supplier_delete_modal').modal('hide');
                    },
                    error: function(response) {
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    }
                });
            });
        });

        function update_active_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }

            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', el.value);
            formData.append('status', status);

            $.ajax({
                url: "{{ route('seller.supplier.status-update') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    resetAfterChange(response.SupplierList);
                    toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                },
                error: function(response) {
                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                }
            });
        }

        function delete_modal(id) {
            $('#delete_item_id').val(id);
            $('#supplier_delete_modal').modal('show');
        }
        function resetAfterChange(supplierList) {
            $('#item_table').empty();
            $('#item_table').html(supplierList);

            CRMTableThreeReactive();
        }

    </script>

@endpush
