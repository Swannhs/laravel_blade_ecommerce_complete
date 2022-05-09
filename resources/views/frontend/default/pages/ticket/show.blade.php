@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{ __('ticket.ticket') }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/text_editor/summernote-bs4.css')) }}" />
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/ticket/show.css'))}}" />

@endsection
@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')
            <div class="col-xl-9 col-md-7">
                <div class="referral_item">
                    <div class="single_coupons_item cart_part">
                        @php
                        $user = auth()->user();
                        @endphp
                        <div class="row">

                            <div class="col-lg-9">
                                <div class="single_message">
                                    <h6 class="d-inline">
                                        {{ __('ticket.ticket_id') }}:
                                        <span>{{$ticket->reference_no }}</span></h6>

                                        @if($ticket->status->id != 4)
                                        <button type="button" class="reply_btn float-right d-inline"
                                            id="update_info">{{__('Reply')}}</button>
                                        @endif

                                    <div class="msg_subject">
                                        <p>{{$ticket->subject}}</p>
                                    </div>
                                    <div class="msg_detail">
                                        @php echo $ticket->description; @endphp
                                    </div>
                                    @if ($ticket->attachFiles->count() > 0)
                                    @foreach($ticket->attachFiles as $key => $file)
                                    <div class="file_list mt-10">
                                        <a href="{{ URL::to('/') }}/{{ asset_path($file->url) }}" download>{{  $key+1 }} .
                                            {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name }}</a>
                                    </div>
                                    @endforeach
                                    @endif
                                    <div class="created_time_div mt-10">
                                        <p>{{@$ticket->created_at->diffForHumans()}}</p>
                                    </div>
                                    <hr>
                                </div>


                                @foreach($ticket->messages as $key => $message)

                                @if($message->type != 0)
                                <div class="card border-0 admin-card p-4 rounded admin_message_div">
                                    <div class="row">
                                        <div class="col-md-1">

                                            <img class="profile_img"
                                                src="{{ showImage($message->user->avatar?$message->user->avatar:'frontend/default/img/avatar.jpg') }}"
                                                alt="" class="thumbnail">

                                        </div>
                                        <div class="col-md-10 ml-2">
                                            <h4 class="admin_name">{{$message->user->first_name}}
                                                {{$message->user->last_name}}</h4>
                                            <p>{{$message->user->role->type}}</p>
                                            <div class="card-body-img">

                                                @php echo $message->text; @endphp
                                            </div>
                                        </div>

                                        @if ($message->attachMsgFile->count() > 0)
                                        @foreach($message->attachMsgFile as $key => $file)

                                        <a class="form-control p-2 mt-2 header-attachment border-0"
                                            href="{{ URL::to('/') }}/{{ asset_path($file->url) }}" download> {{  $key+1 }} .
                                            {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name }}
                                        </a>

                                        @endforeach

                                        @endif

                                        <br>
                                        <br>

                                        <p class="message-info">{{@$message->created_at->diffForHumans()}}<p>


                                    </div>
                                </div>
                                <hr>
                                @else

                                <div class="card border-0 p-4 rounded m-2">
                                    <div class="row">

                                        <div class="col-md-10 ml-35">
                                            <h4 class="user-text-right admin_name"> {{$message->user->first_name}}
                                                {{$message->user->last_name}}</h4>
                                            <p class="user-text-right">{{$message->user->role->type}}</p>

                                            <span class="card-body-img user-text-right">
                                                @php echo $message->text; @endphp
                                            </span>

                                            <div class="user-text-right">
                                                @if ($message->attachMsgFile->count() > 0)
                                                @foreach($message->attachMsgFile as $key => $file)
                                                <a class="form-control p-2 mt-2 header-attachment border-0 customer_attach"
                                                    href="{{ URL::to('/') }}/{{ asset_path($file->url) }}" download> {{  $key+1 }} .
                                                    {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name }}</a>
                                                @endforeach

                                                @endif
                                                <br>

                                                <p class="message-info user-text-right">
                                                    {{@$message->created_at->diffForHumans()}}<p>
                                            </div>

                                        </div>

                                        <div class="col-md-1">

                                            <img class="customer_img"
                                                src="{{showImage($user->avatar?$user->avatar:'frontend/default/img/avatar.jpg')}}"
                                                alt="#" class="thumbnail">

                                        </div>




                                    </div>

                                </div>

                                <hr>
                                @endif

                                @endforeach

                                <form class="d-none" id="replyForm" name="basic_info"
                                    action="{{ route('ticket.message') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">


                                                <div class="col-md-12 mt-15 mb_15">
                                                    <div class="form-group">
                                                        <label for="textarea">{{__('common.description')}} <span class="text-danger">*</span></label>
                                                        <textarea id="description" class="summernote"
                                                            placeholder="{{__('common.description')}}"
                                                            name="text"></textarea>
                                                    </div>

                                                    @if ($errors->has('text'))
                                                    <span class="text-danger"
                                                        id="error_message">{{ $errors->first('text') }}</span>
                                                    @endif
                                                </div>

                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                                                <input type="hidden" name="type" value="0" />

                                                <div class="col-md-12">
                                                    <div id="attach_file_div">
                                                        <div class="attach_item d-flex align-items-end gap_15 mb_15">
                                                            <div class="flex-fill">
                                                                <div class="form-group primary_file_uploader">
                                                                    <label
                                                                        for="subject">{{__('common.attach_file')}}</label>

                                                                    <input type="text" class="form-control" id="attach"
                                                                        readonly placeholder="">
                                                                    <button class="d-inline" type="button">
                                                                        <label class="primary-btn small fix-gr-bg ticket_browse"
                                                                            for="ticket_file">{{ __('common.browse') }}
                                                                        </label>
                                                                        <input type="file"
                                                                            class="d-none attach_file_change"
                                                                            name="ticket_file[]" id="ticket_file"
                                                                            data-value="#attach">
                                                                    </button>
                                                                </div>
                                                                @if ($errors->has('ticket_file'))
                                                                <span class="text-danger"
                                                                    id="error_message">{{ $errors->first('ticket_file') }}</span>
                                                                @endif

                                                            </div>
                                                            <div class="">
                                                                <a href="javascript:void(0)" id="new_attach_file"
                                                                    class="btn_1 attach_plus_btn m-0"><i
                                                                        class="ti-plus"></i></a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form_btn col-md-12">
                                                    <button type="submit" class="btn_1"
                                                        id="update_info">{{__('common.reply')}}</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>


                            </div>
                            <div class="col-lg-3">

                                <div class="card border-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <img class="userThumbImg"
                                                src="{{showImage($user->avatar?$user->avatar:'frontend/default/img/avatar.jpg')}}"
                                                alt="#" class="thumbnail">
                                            <h3 class="fs-18">{{$user->first_name}} {{$user->last_name}}</h3>
                                            <p class="customerThmubName">Customer</p>
                                        </li>

                                        <li class="list-group-item">
                                            <p>@lang('common.status') :</p>

                                            <h5 class="badge_1"> {{$ticket->status->name}}</h5>
                                        </li>
                                        <li class="list-group-item">
                                            <p>@lang('Priority') :</p>

                                            <h5 class="badge_1"> {{$ticket->priority->name}}</h5>
                                        </li>
                                        <li class="list-group-item">
                                            <p>@lang('common.category') :</p>

                                            <h5 class="badge_1"> {{$ticket->category->name}}</h5>
                                        </li>
                                        <li class="list-group-item">
                                            <p>@lang('Last Update') : </p>

                                            <h5 class="last_update"> {{ date_format($ticket->updated_at, "F j, Y ")}} at
                                                {{date_format($ticket->updated_at, "g:i a")}}</h5>
                                        </li>


                                    </ul>
                                </div>
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
<script src="{{asset(asset_path('backend/vendors/text_editor/summernote-bs4.js'))}}"></script>
@if($errors->any())
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                replyCheck();
            });

            function replyCheck(){
                $('.reply_btn').removeClass('d-inline');
                $('.reply_btn').addClass('d-none');
                $('#replyForm').removeClass('d-none');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#replyForm").offset().top
                }, 1500);
            }
        })(jQuery);
    </script>
@endif

<script>
    (function($){
            "use strict";

            $(document).ready(function(){


                $('#description').summernote({
                    placeholder: 'Write here',
                    tabsize: 2,
                    height: 200,
                    codeviewFilter: true,
			        codeviewIframeFilter: true
                });

                $(document).on('click', '.reply_btn', function(){
                    $('.reply_btn').removeClass('d-inline');
                    $('.reply_btn').addClass('d-none');
                    $('#replyForm').removeClass('d-none');
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#replyForm").offset().top
                    }, 1500);
                });

                $(document).on('click', '#new_attach_file', function(event){
                    let index = $('.attach_item').length
                    addNewFileAddItem(index);
                });

                $(document).on('click', '.remove_attach', function() {
                    $(this).parent().parent().remove();
                });

                $(document).on('change', '.attach_file_change', function(event){
                    let unique_id = $(this).data('value');
                    getFileName($(this).val(),unique_id);

                })

                function addNewFileAddItem(index){
                    if(index >4){
                        toastr.error("{{__('common.attach_upload_limit_is_5')}}","{{__('common.error')}}");
                        return false;
                    }
                    let new_file = `
                        <div class="attach_item d-flex align-items-end gap_15 mb_15">
                            <div class="flex-fill">
                                <div class="form-group primary_file_uploader">
                                    <label for="subject">{{__('common.attach_file')}}</label>

                                    <input type="text" class="form-control" id="attach_${index}" readonly placeholder="{{ __('common.browse_file') }}">
                                    <button class="d-inline" type="button">
                                        <label class="primary-btn small fix-gr-bg ticket_browse" for="ticket_file_${index}">Browse </label>
                                        <input type="file" class="d-none attach_file_change" name="ticket_file[]" id="ticket_file_${index}" data-value="#attach_${index}">
                                    </button>
                                </div>
                                @if ($errors->has('ticket_file'))
                                <span class="text-danger" id="error_ticket_file_${index}">{{ $errors->first('ticket_file') }}</span>
                                @endif

                            </div>
                            <div class="">
                                <a href="javascript:void(0)" class="btn_1 remove_attach attach_plus_btn"><i class="ti-trash"></i></a>
                            </div>

                        </div>

                    `;
                    $('#attach_file_div').append(new_file);
                }

            });
        })(jQuery);

</script>

@endpush
