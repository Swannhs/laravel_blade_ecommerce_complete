@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/backend_page_css/staff_view.css'))}}" />


@endsection
@section('mainContent')
<section class="mb-40 student-details">

   @if(session()->has('message-success'))
   <div class="alert alert-success">
      {{ session()->get('message-success') }}
   </div>
   @elseif(session()->has('message-danger'))
   <div class="alert alert-danger">
      {{ session()->get('message-danger') }}
   </div>
   @endif
   <div class="container-fluid p-0">
      <div class="row">
         <div class="col-lg-3">
            <!-- Start Student Meta Information -->
            <div class="main-title">
               <h3 class="mb-20">{{__('common.staff_info')}}</h3>
            </div>
            <div class="student-meta-box">
               <div class="student-meta-top"></div>

               <div class="avatar_div">
                  <img class="student-meta-img img-100"
                     src="{{ asset( (@$staffDetails->user->avatar !=null)?asset_path(@$staffDetails->user->avatar) : asset_path('backend/img/avatar.png')) }}"
                     alt="">
               </div>
               <div class="white-box">
                  <div class="single-meta mt-10">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('common.name') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{ucwords(@$staffDetails->user->getFullNameAttribute())}}@endif
                        </div>
                     </div>
                  </div>
                  @if ($staffDetails->user->role_id != 1)
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('common.employee_id') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{$staffDetails->employee_id}}@endif
                        </div>
                     </div>
                  </div>
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('common.opening_balance') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{single_price($staffDetails->opening_balance)}}@endif
                        </div>
                     </div>
                  </div>
                  @endif
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('common.username') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{@$staffDetails->user->username}}@endif
                        </div>
                     </div>
                  </div>
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('hr.role') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{@$staffDetails->user->role->name}}@endif
                        </div>
                     </div>
                  </div>
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('hr.department') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{ !empty($staffDetails->department != null)?
                           $staffDetails->department->name:''}}@endif
                        </div>
                     </div>
                  </div>

                  @if ($staffDetails->user->role_id != 1)
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('hr.date_of_joining') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails))
                           {{ date(app('general_setting')->dateFormat->format,
                           strtotime($staffDetails->date_of_joining)) }}
                           @endif
                        </div>
                     </div>
                  </div>
                  @endif
               </div>
            </div>
            <!-- End Student Meta Information -->
         </div>
         <!-- Start Student Details -->
         <div class="col-lg-9 staff-details">
            <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" href="#studentProfile" role="tab" data-toggle="tab">{{ __('common.profile')
                     }}</a>
               </li>

               <li class="nav-item">
                  <a class="nav-link" href="#staffDocuments" role="tab" data-toggle="tab">{{ __('common.documents')
                     }}</a>
               </li>

               <li class="nav-item edit-button">
                  <a href="{{ route('staffs.edit', $staffDetails->id) }}" class="primary-btn small fix-gr-bg">{{
                     __('common.edit') }}
                  </a>
               </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
               <!-- Start Profile Tab -->
               <div role="tabpanel" class="tab-pane fade show active" id="studentProfile">
                  <div class="white-box">
                     <h4 class="stu-sub-head">{{ __('common.personal_info') }}</h4>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-5">
                              <div class="">
                                 {{ __('common.phone') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="">
                                 @if(isset($staffDetails)){{$staffDetails->phone}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-6">
                              <div class="">
                                 {{ __('common.email') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-7">
                              <div class="">
                                 @if(isset($staffDetails)){{@$staffDetails->user->email}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     @if ($staffDetails->user->role_id != 1)
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-6">
                              <div class="">
                                 {{ __('common.date_of_birth') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-7">
                              <div class="">
                                 @if(isset($staffDetails))
                                 {{$staffDetails->date_of_birth != ""? date(app('general_setting')->dateFormat->format,
                                 strtotime($staffDetails->date_of_birth)):''}}
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Start Parent Part -->
                     <h4 class="stu-sub-head mt-40">{{ __('common.address') }}</h4>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-5">
                              <div class="">
                                 {{ __('common.address') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="">
                                 @if(isset($staffDetails)){{$staffDetails->address}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Parent Part -->
                     <!-- Start Transport Part -->
                     <h4 class="stu-sub-head mt-40">{{ __('hr.bank_account_details') }}</h4>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-5">
                              <div class="">
                                 {{ __('common.account_name') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="">
                                 @if(isset($staffDetails)){{$staffDetails->bank_account_name}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-5">
                              <div class="">
                                 {{ __('hr.bank_account_number') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="">
                                 @if(isset($staffDetails)){{$staffDetails->bank_account_no}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-5">
                              <div class="">
                                 {{ __('hr.bank_name') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="">
                                 @if(isset($staffDetails)){{$staffDetails->bank_name}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-5">
                              <div class="">
                                 {{ __('hr.bank_branch_name') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="">
                                 @if(isset($staffDetails)){{$staffDetails->bank_branch_name}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Transport Part -->
                     @endif
                  </div>
               </div>
               <!-- End Profile Tab -->
               @if(isset($staffDetails))<input type="hidden" name="user_id" id="user_id"
                  value="{{ @$staffDetails->user->id }}">@endif


               <!-- Start Documents Tab -->
               <div role="tabpanel" class="tab-pane fade" id="staffDocuments">
                  <div class="white-box">
                     <div class="text-right mb-20">
                        <button type="button" data-toggle="modal" data-target="#add_document_madal"
                           class="primary-btn tr-bg text-uppercase bord-rad">
                           {{__('common.upload_document')}}
                           <span class="pl ti-upload"></span>
                        </button>
                     </div>
                     <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                           <table class="table Crm_table_active">
                              <thead>
                                 <tr>
                                    <th scope="col">{{__('common.title')}}</th>
                                    <th scope="col">{{__('common.action')}}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @isset($staffDocuments)
                                 @foreach ($staffDocuments as $key => $staffDocument)
                                 <tr>
                                    <td> <a href="{{asset(asset_path($staffDocument->documents))}}" download
                                          target="_blank">{{ $staffDocument->name }}</a></td>
                                    <td>
                                       <div class="dropdown CRM_dropdown">
                                          <button class="btn btn-secondary dropdown-toggle" type="button"
                                             id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                             aria-expanded="false">
                                             {{ __('common.select') }}
                                          </button>
                                          <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="dropdownMenu2">
                                             <a href="{{asset(asset_path($staffDocument->documents))}}"
                                                class="dropdown-item" download>{{__('common.download')}}</a>
                                             <a data-value="{{route('staff_document.destroy', $staffDocument->id)}}"
                                                class="dropdown-item delete_document">{{__('common.delete')}}</a>
                                          </div>
                                       </div>
                                    </td>
                                 </tr>
                                 @endforeach
                                 @endisset
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End Documents Tab -->
               <!-- Add Document modal form start-->
               <div class="modal fade admin-query" id="add_document_madal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">{{__('common.upload_document')}}</h4>
                           <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                        </div>
                        <div class="modal-body">
                           <div class="container-fluid">
                              <form class="" action="{{ route('staff_document.store') }}" method="post"
                                 id="document_create_form" enctype="multipart/form-data">
                                 @csrf
                                 <div class="row">
                                    <input type="hidden" name="staff_id" value="{{$staffDetails->id}}">
                                    <div class="col-xl-12">
                                       <div class="primary_input mb-25">
                                          <label class="primary_input_label" for="">{{ __('common.name') }}</label>
                                          <input name="name" class="primary_input_field name" id="create_name"
                                             placeholder="{{ __('common.name') }}" type="text">
                                          <span class="text-danger" id="create_name_error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-12">
                                       <div class="primary_input mb-15">
                                          <label class="primary_input_label" for="">{{ __('common.avatar') }}</label>
                                          <div class="primary_file_uploader">
                                             <input class="primary-input" type="text" id="placeholderFileOneName"
                                                placeholder="{{__('common.browse_file')}}" readonly="">
                                             <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="document_file_1">{{
                                                   __('common.browse') }}</label>
                                                <input type="file" class="d-none" name="file" id="document_file_1">
                                             </button>
                                             <span class="text-danger" id="create_file_error"></span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-12 text-center mt-40">
                                       <div class="mt-40 d-flex justify-content-between">
                                          <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{
                                             __('common.cancel') }}</button>
                                          <button class="primary-btn fix-gr-bg" type="submit">{{ __('common.save')
                                             }}</button>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="edit_form">

</div>

@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
<script type="text/javascript">
   (function($){
            "use strict";

            $(document).ready(function(){
               $(document).on('submit', '#document_create_form', function(event){
                  $('#create_name_error').text('');
                  $('#create_file_error').text('');
                  let name = $('#create_name').val();
                  let file = $('#document_file_1').val();

                  if(name == ''){
                     $('#create_name_error').text('The Name field is Required.');
                  }
                  if(file == ''){
                     $('#create_file_error').text('The File field is Required.');
                  }

                  if(name == '' || file == ''){
                     event.preventDefault();
                     return false;
                  }

               });

               $(document).on('change', '#document_file_1', function(){
                  getFileName($(this).val(),'#placeholderFileOneName');
               });

               $(document).on('click', '.printDiv', function(){
                  printDiv(divName);
               });

               function printDiv(divName) {

                  var printContents = document.getElementById(divName).innerHTML;
                  var originalContents = document.body.innerHTML;
                  document.body.innerHTML = printContents;
                  window.print();
                  document.body.innerHTML = originalContents;

               }

               $(document).on('click', '.delete_document', function(event){
                  event.preventDefault();
                  let url = $(this).data('value');
                  confirm_modal(url);
               });

            });

         })(jQuery);


</script>
@endpush
