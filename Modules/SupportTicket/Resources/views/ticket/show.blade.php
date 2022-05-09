@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/supportticket/css/show.css'))}}" />

@endsection
@section('mainContent')

@if($errors->any())
@php echo implode('', $errors->all('<div class="alert alert-danger">:message</div>')); @endphp
@endif

<section class="admin-visitor-area">


    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title">
                        <h3 class="mb-0 mr-30"> {{$SupportTicket->reference_no}} - {{$SupportTicket->subject}}</h3>
                    </div>
                    <div class="table_btn_wrap">
                        <ul>
                            <li>
                                <div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{__('common.action')}}
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right action_dropdown_right"
                                        aria-labelledby="dropdownMenu2" x-placement="bottom-end">
                                        <a class="dropdown-item"
                                            href="{{ route('ticket.tickets.edit',$SupportTicket->id)}}">{{__('common.edit')}}</a>
                                        <button class="dropdown-item ticket_delete" type="button"
                                            data-id="{{$SupportTicket->id}}">{{__('common.delete')}}</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="white_box_30px mb-30">
                    <div class="info_list_wrap p-0">
                        <div class="main-title2">
                            <h4 class="mb-3">{{__('ticket.ticket_info')}}</h4>
                        </div>
                        <div class="project_info_list mb-50">
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('ticket.ticket_id')}} :</div>
                                <div class="project_info_name project_info_content">
                                    {{$SupportTicket->reference_no }}
                                </div>
                            </div>
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('ticket.subject')}} :</div>
                                <div class="project_info_name project_info_content white_space_normal">
                                    {{$SupportTicket->subject}}
                                </div>
                            </div>
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('ticket.priority')}} :</div>
                                <div class="project_info_name project_info_content">
                                    {{@$SupportTicket->priority->name}}
                                </div>
                            </div>
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('common.category')}} :</div>
                                <div class="project_info_name project_info_content">
                                    {{@$SupportTicket->category->name}}
                                </div>
                            </div>
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('common.status')}} :</div>
                                <div class="project_info_name project_info_content">
                                    {{@$SupportTicket->status->name}}
                                </div>
                            </div>
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('common.user_name')}} :</div>
                                <div class="project_info_name project_info_content">
                                    <a class="inderline_text_lisk"
                                        href="@if(@$SupportTicket->user->role->type == 'customer') {{route('customer.show_details',@$SupportTicket->user->id)}} @elseif($SupportTicket->user->role->type == 'seller') {{route('admin.merchant_show_details',$SupportTicket->user->id)}} @endif ">{{ @$SupportTicket->user->getFullNameAttribute() }}</a>
                                </div>
                            </div>
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('common.submit')}} {{__('common.date')}} :</div>
                                <div class="project_info_name project_info_content">
                                    {{dateConvert($SupportTicket->created_at)}}
                                </div>
                            </div>
                            <!-- single_project_list  -->
                            <div class="single_project_list d-flex">
                                <div class="project_info_name">{{__('ticket.assign_to')}} :</div>
                                <div class="project_info_name project_info_content">
                                    {{@$SupportTicket->assignUser->first_name}}
                                    {{@$SupportTicket->assignUser->last_name}}
                                </div>
                            </div>
                        </div>
                        <div class="main-title2">
                            <h4 class="mb-3">{{__('ticket.attachment')}}</h4>
                        </div>

                        @if ($SupportTicket->attachFiles->count() > 0)
                        @foreach($SupportTicket->attachFiles as $key => $file)
                        <div class="primary_input mb-25">

                            <a class="primary_input_gray form-control pt-15" href="{{ URL::to('/') }}/{{ asset_path($file->url) }}"
                                download> {{  $key+1 }} .
                                {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name }}</a>

                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="white_box_30px">
                    <div class="row">
                        <div class="col-12">
                            <div class="tickets_view_lists mb-50">
                                <div class="single_tks_view_list ">
                                    <div class="tkt_owner d-flex align-items-center mb-20">
                                        <div class="thumb">
                                            <img src="@if($SupportTicket->user->role->type == 'customer') {{showImage(@$SupportTicket->user->avatar?@$SupportTicket->user->avatar:'backend/img/avatar.png')}} @elseif($SupportTicket->user->role->type == 'seller') {{showImage(@$SupportTicket->user->photo?@$SupportTicket->user->photo:'backend/img/avatar.png')}} @else {{showImage('backend/img/avatar.png')}}  @endif"
                                                alt="">
                                        </div>
                                        <div class="tkt_owner_name">
                                            <h4>{{@$SupportTicket->user->getFullNameAttribute()}}</h4>
                                            <p>{{dateConvert($SupportTicket->created_at)}}</p>
                                        </div>
                                    </div>
                                    @php echo $SupportTicket->description; @endphp

                                </div>



                                <div class="comments_checklisted">
                                    @foreach($SupportTicket->messages as $key => $message)
                                    <div class="single_list d-flex pb-10 pt-15">
                                        <div class="thumb">
                                            <a href="#"><img
                                                    src="@if($message->user->role->type == 'customer') {{showImage(@$message->user->avatar?@$SupportTicket->user->avatar:'backend/img/avatar.png')}} @elseif($message->user->role->type == 'seller') {{showImage(@$message->user->photo?@$SupportTicket->user->photo:'backend/img/avatar.png')}} @else {{showImage('backend/img/avatar.png')}}  @endif"
                                                    alt=""></a>
                                        </div>
                                        <div class="list_name">
                                            <h4><a href="#">{{ $message->user->getFullNameAttribute() }} </a>
                                                <span>{{$message->created_at->diffForHumans()}}</span> </h4>
                                            @php echo $message->text; @endphp
                                        </div>
                                    </div>
                                    <div class="msg_attach_file_list d-block">
                                        @if ($message->attachMsgFile->count() > 0)
                                        @foreach($message->attachMsgFile as $key => $file)
                                        <a href="{{ URL::to('/') }}/{{ asset_path($file->url) }}" download="">{{  $key+1 }} .
                                            {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name }}</a>
                                        @endforeach
                                        @endif

                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <form action="{{ route('ticket.message') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12  mb-30">
                                        <textarea name="text" class="summernote5 summernote">{{ old('text') }}</textarea>
                                    </div>
                                    @if ($errors->has('text'))
                                    <span class="text-danger" id="error_message">{{ $errors->first('text') }}</span>
                                    @endif

                                    <input type="hidden" name="ticket_id" value="{{ $SupportTicket->id }}" />
                                    <input type="hidden" name="type" value="1" />

                                    <div class="col-lg-6">
                                        <div class="attach-file-section">
                                            <div class="row attach-item">
                                                <div class="col-11">
                                                    <div class="row no-gutters input-right-icon">

                                                        <div id="countryFlagFileDiv" class="col-lg-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label"
                                                                    for="">{{ __('ticket.attach_file') }}</label>
                                                                <div class="primary_file_uploader">
                                                                    <input class="primary-input" type="text" id="attach"
                                                                        placeholder="{{ __('common.browse_file') }}"
                                                                        readonly="">
                                                                    <button class="" type="button">
                                                                        <label class="primary-btn small fix-gr-bg"
                                                                            for="ticket_file">{{ __('common.browse') }}
                                                                        </label>
                                                                        <input type="file" class="d-none ticket_file_input" data-value="#attach"
                                                                            name="ticket_file[]" id="ticket_file">
                                                                    </button>
                                                                </div>
                                                            </div>


                                                            @if ($errors->has('ticket_file.*'))
                                                            <span class="text-danger"
                                                                id="error_attach">{{ $errors->first('ticket_file.*') }}</span>
                                                            @endif

                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="col-1 mt-35 btn_margin"><button
                                                        class="primary-btn small fix-gr-bg custom_plus_btn"
                                                        type="button" id="ticket_file_add"> <i class="fa fa-plus"></i>
                                                    </button></div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                            <select name="status_id" id="status_id" class="primary_select mb-15">
                                                <option value="" selected disabled>{{__('common.select_one')}}</option>
                                                @foreach ($SupportTicketStatusList as $key => $status)
                                                <option value="{{ $status->id }}"
                                                    {{ $SupportTicket->status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}</option>
                                                @endforeach

                                            </select>
                                            @if ($errors->has('status_id'))
                                            <span class="text-danger"
                                                id="error_status_id">{{ $errors->first('status_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="submit_button">
                                            <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                                type="button">{{__('ticket.reply_ticket')}}</button>
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

    <div class="modal fade admin-query" id="deleteItem">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.delete')}} {{__('ticket.ticket')}}</h4>
                    <button type="button" class="close" data-dismiss="modal"><i class="ti-close "></i></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>{{__('common.are_you_sure_to_delete_?')}}</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                            data-dismiss="modal">{{__('common.cancel')}}</button>
                        <form id="deleteForm" action="{{route('ticket.tickets.destroy')}}" method="POST">
                            @csrf
                            <input type="hidden" id="dataId" name="id">
                            <input type="submit" class="primary-btn fix-gr-bg" value="{{__('common.delete')}}" />
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>


@endsection

@push('scripts')

<script>
    $('.popover').css("display","none")

     $(document).ready(function() {


        $('#description').summernote({
            placeholder: 'Write here',
            tabsize: 2,
            height: 200,
            codeviewFilter: true,
			codeviewIframeFilter: true
        });

        var index = 0;
        $(document).on('click','#ticket_file_add',function(){

            index = $('.attach-item').length
            addNewFileAddItem(index)
        });

        $(document).on('click','.delete-ticket-message-attach',function(){
            $(this).parent().parent().remove();
        });

        $(document).on('change','.file-upload-multi',function(e){
            let fileName = e.target.files[0].name;
            $(this).parent().parent().parent().find('#placeholderStaffsName').attr('placeholder',fileName);
        });

        $(document).on('change', '.ticket_file_input', function(){
            let value = $(this).data('value');
            getFileName($(this).val(), value);
        });



        function addNewFileAddItem(index){

            var attachFile = `
            <div class="row attach-item">
                            <div class="col-11">
                                <div class="row no-gutters input-right-icon">

                                    <div id="countryFlagFileDiv" class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="attach_${index}"
                                                    placeholder="{{ __('common.browse_file') }}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                        for="ticket_file_${index}">{{ __('common.browse') }} </label>
                                                    <input type="file" class="d-none ticket_file_input" name="ticket_file[]" id="ticket_file_${index}" data-value="#attach_${index}">
                                                </button>
                                            </div>
                                        </div>

                                        <span class="text-danger" id="error_attach_${index}"></span>

                                    </div>


                                </div>
                            </div>
                            <div class="col-1 mt_5 btn_margin"><button class="primary-btn delete-ticket-message-attach small fix-gr-bg custom_plus_btn" type="button"> <i class="fa fa-trash"></i> </button></div>
                        </div>

            `;

            $('.attach-file-section').append(attachFile);
        }

        $(document).on('click', '.ticket_delete', function(event){

            let id = $(this).data('id');
            $('#deleteItem').modal('show');
            $('#dataId').val(id);
        });

    });

</script>

@endpush
