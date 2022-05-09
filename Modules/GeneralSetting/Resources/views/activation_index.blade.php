@extends('backEnd.master')

@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{ __('general_settings.general_settings') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="white_box_30px">
                    @include('generalsetting::page_components.activation')
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection
@push('scripts')
<script type="text/javascript">
    $(document).on('change','.activations', function(){
            if(this.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('update_activation_status') }}', {_token:'{{ csrf_token() }}', id:this.value, status:status}, function(data){
                if(data == 1){
                    toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                }
                else{
                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");

                }
            }).fail(function(response) {
               if(response.responseJSON.error){
                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                    $('#pre-loader').addClass('d-none');
                    return false;
                }

            });
        });
</script>
@endpush
