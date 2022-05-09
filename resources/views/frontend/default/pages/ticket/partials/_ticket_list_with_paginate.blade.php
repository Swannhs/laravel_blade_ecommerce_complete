@php
    $total_number_of_item_per_page = $tickets->perPage();
    $total_number_of_items = $tickets->total() > 0 ? $tickets->total() : 0;
    $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
    $reminder = $total_number_of_items % $total_number_of_item_per_page;
    if ($reminder > 0) {
        $total_number_of_pages += 1;
    }

    $current_page = $tickets->currentPage();
    $previous_page = $tickets->currentPage() - 1;
    if ($current_page == $tickets->lastPage()) {
        $show_end = $total_number_of_items;
    } else {
        $show_end = $total_number_of_item_per_page * $current_page;
    }

    $show_start = 0;
    if ($total_number_of_items > 0) {
        $show_start = $total_number_of_item_per_page * $previous_page + 1;
    }
@endphp


<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4">
                <h5>{{ __('ticket.all_submmited_ticket') }}</h5>
            </div>
            <div class="col-lg-8 d-flex justify-content-end">
                <select name="status" id="status_by">
                    <option value="0" @if (isset($status) && $status == "0") selected @endif>{{ __('ticket.all_ticket') }}</option>
                    @foreach($statuses as $key => $item)
                    <option value="{{$item->id}}" @if (isset($status) && $status == $item->id) selected @endif>{{$item->name}}</option>
                    @endforeach

                </select>
                <a href="{{ route('frontend.support-ticket.create') }}" class="add_new_btn text-nowrap"> {{ __('common.add_new') }}</a>
            </div>
        </div>

    </div>
    <div class="col-lg-12 user_list_div">
        <div class="user-list table-responsive">
            <table class="table table-hover tablesaw">
                <thead>
                    <tr>
                        <th>{{ __('common.sl') }}</th>
                        <th>{{ __('ticket.ticket_id') }}</th>
                        <th>{{ __('ticket.subject') }}</th>
                        <th>{{ __('ticket.priority') }}</th>
                        <th>{{ __('ticket.last_update') }}</th>
                        <th>{{ __('common.action') }}</th>
                    </tr>
                </thead>
                <tbody class="cart_table_body">
                    @foreach ($tickets as $key => $ticket)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $ticket->reference_no }}</td>
                            <td>
                                {{ $ticket->subject }}
                            </td>
                            <td>{{ $ticket->priority->name }}</td>
                            
                            <td>{{ date_format($ticket->updated_at, 'F j, Y ') }} at
                                {{ date_format($ticket->updated_at, 'g:i a') }}</td>

                            <td><a target="_blank" class="add_new_btn"
                                    href="{{ route('frontend.support-ticket.show', $ticket->reference_no) }}">{{__('common.view')}}</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
    @if(count($tickets) > 0)
    <div class="col-lg-12">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="pagination_part">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="{{ $tickets->previousPageUrl() }}"> <i
                                        class="ti-arrow-left"></i> </a></li>
                            @for ($i = 1; $i <= $total_number_of_pages; $i++)
                                @if ($tickets->currentPage() + 2 == $i) <li
                                class="page-item"><a class="page-link"
                                href="{{ $tickets->url($i) }}">{{ $i }}</a></li> @endif
                                @if ($tickets->currentPage() + 1 == $i)
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $tickets->url($i) }}">{{ $i }}</a></li>
                                @endif
                                @if ($tickets->currentPage() == $i)
                                    <li class="page-item @if (request()->toRecievedList == $i ||
                                        request()->toRecievedList == null) active @endif"><a
                                            class="page-link" href="{{ $tickets->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                                @if ($tickets->currentPage() - 1 == $i)
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $tickets->url($i) }}">{{ $i }}</a></li>
                                @endif
                                @if ($tickets->currentPage() - 2 == $i)
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $tickets->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{ $tickets->nextPageUrl() }}"> <i
                                        class="ti-arrow-right"></i> </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>




