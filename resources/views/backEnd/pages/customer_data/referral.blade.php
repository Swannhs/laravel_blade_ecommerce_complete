@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/referral.css'))}}" />
@endsection

@section('mainContent')
<!--  dashboard part css here -->
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            @if (isset($myCode))
            <div class="col-xl-12 mb-30">
                <div class="white_box_30px">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-3 mr-30 mb_xs_15px mb_sm_20px">{{__('customer_panel.my_referral_code')}}</h3>
                    </div>
                    @if (isset($myCode))
                    <div class="input-group">
                        <input type="text" name="code" class="form-control primary_input_field"
                            value="{{$myCode->referral_code}}" id="code" placeholder="{{__('common.code')}}" readonly />
                        <div class="input-group-append">
                            <button id="copyBtn"
                                class="input-group-text primary_btn_2">{{__('defaultTheme.copy_code')}}</button>
                        </div>
                    </div>
                    @else
                    <strong class="red_text">{{ __('customer_panel.you_will_get_referral_code_soon') }}</strong>
                    @endif
                </div>
            </div>
            <div class="col-xl-12">
                <div class="white_box_30px">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('User List')}}</h3>
                    </div>

                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <table class="table Crm_table_active2">
                                <thead>
                                    <tr>
                                        <th scope="col">{{__('common.sl')}}</th>
                                        <th scope="col">{{__('common.user')}}</th>
                                        <th scope="col">{{__('common.name')}}</th>
                                        <th scope="col">{{__('common.email')}}</th>
                                        <th scope="col">{{__('common.date')}}</th>
                                        <th scope="col">{{__('common.status')}}</th>
                                        <th scope="col">{{__('defaultTheme.discount_amount')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referList as $key => $referral)
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td>
                                            <div class="avatar_div">
                                                <img class="user-img"
                                                    src="{{showImage(@$referral->user->avatar?$referral->user->avatar:'backend/img/avatar.jpg')}}"
                                                    alt="">
                                            </div>
                                        </td>
                                        <td>{{@$referral->user->first_name. @$referral->user->last_name}}</td>
                                        <td>{{@$referral->user->email?@$referral->user->email:'X'}}</td>
                                        <td>{{date(app('general_setting')->dateFormat->format,strtotime($referral->created_at))}}
                                        </td>
                                        <td>{{$referral->is_use ==
                                            1?__('defaultTheme.already_use'):__('defaultTheme.not_used')}}</td>
                                        <td>{{single_price($referral->discount_amount)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-xl-12">
                <h3 class="text-center mt_60">{{__('defaultTheme.you_will_get_referral_after')}}</h3>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
            document.getElementById("copyBtn").onclick = function() {
                let copyTextarea = document.createElement("textarea");
                copyTextarea.style.position = "fixed";
                copyTextarea.style.opacity = "0";
                copyTextarea.textContent = document.getElementById("code").value;

                document.body.appendChild(copyTextarea);
                copyTextarea.select();
                document.execCommand("copy");
                document.body.removeChild(copyTextarea);
                toastr.success("{{__('defaultTheme.code_copied_successfully')}}", "{{__('common.success')}}");
            }
        });
</script>
@endpush
