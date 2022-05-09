@extends('backEnd.master')
@section('mainContent')
<!--  dashboard part css here -->
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-xl-12">
                <div class="white_box_30px">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('product.purchased_gift_card')}}</h3>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active2">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.sl') }}</th>
                                        <th scope="col">{{ __('common.amount') }}</th>
                                        <th scope="col">{{ __('common.name') }}</th>
                                        <th scope="col">{{ __('common.qty') }}</th>
                                        <th scope="col">{{ __('customer_panel.secret_code') }}</th>
                                        <th scope="col">{{ __('customer_panel.is_used') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gift_card_infos as $key => $gift_card_info)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ single_price($gift_card_info->giftCard->selling_price) }}</td>
                                                <td>{{ $gift_card_info->giftCard->name }}</td>
                                                <td>{{ $gift_card_info->qty }}</td>
                                                <td class="show_icon" data-secret-code="{{ $gift_card_info->secret_code }}"><i class="ti-eye"></i></td>
                                                <td>
                                                    @if ($gift_card_info->is_used == 1)
                                                        <span class="badge_1">Used</span>
                                                    @else
                                                        <a class="primary_btn_2 gift_card_redeem" data-gift-card-use-id='{{ $gift_card_info->id }}'>Redeem</a>
                                                    @endif
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
</section>

@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).on('click', '.gift_card_redeem', function(){
            $(this).text('Please Wait.....');
            var _this = this;
            var gift_card_use_id = $(this).attr("data-gift-card-use-id");
            $.post('{{ route('frontend.gift_card_redeem') }}', {_token:'{{ csrf_token() }}', gift_card_use_id:gift_card_use_id}, function(data){
                if (data == 1) {
                    toastr.success("{{__('customer_panel.money_has_been_transfered_into_wallet')}}","{{__('common.success')}}")
                    $(_this).text('Done')
                }else {
                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    $(_this).text('Redeem Again')
                }
            });
        });
        $(document).on('click','.show_icon', function(){
            $(this).text($(this).attr("data-secret-code"))
        })
    </script>
@endpush
