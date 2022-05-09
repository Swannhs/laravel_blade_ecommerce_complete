@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.seller_request_product') }}</h3>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div id="product_list_div">
                                @include('product::products.request_product_list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="product_detail_view_div">

    </div>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        function productApproved(el){
            if(el.checked){
                var is_approved = 1;
            }
            else{
                var is_approved = 0;
            }

            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', el.value);
            formData.append('is_approved', is_approved);
            $.ajax({
                url: "{{ route('product.request.approved') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    resetAfterChange(response.TableData);
                    toastr.success("{{__('common.approved_successfully')}}", "{{__('common.success')}}");
                },
                error: function(response) {
                    toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                }
            });
        }

        function resetAfterChange(tableData) {
            $('#product_list_div').empty();
            $('#product_list_div').html(tableData);
            CRMTableThreeReactive();
        }

        function product_detail(el){
            $.post('{{ route('product.show') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('.product_detail_view_div').html(data);
                $('#productDetails').modal('show');
            });
        }

        function update_active_sku_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('product.update_active_sku_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                }
                else{
                    toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                }
            });
        }
    </script>
@endpush
