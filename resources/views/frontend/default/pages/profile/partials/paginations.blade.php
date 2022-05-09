@php

    $total_number_of_item_get_for_this_page = ($orders->count() > 0) ? $orders->count() : 0;
    if ($total_number_of_item_get_for_this_page != 0) {
        $total_number_of_items = ($orders->total() > 0) ? $orders->total() : 1;
        $half_of_total_items = intval($total_number_of_items/2);
        $reminder = $total_number_of_items % 2;
        if ($reminder > 0) {
            $half_of_total_items += 1;
        }
        if ($total_number_of_item_get_for_this_page >= $half_of_total_items) {
            $total_number_of_pages = intval($total_number_of_items / $total_number_of_item_get_for_this_page);
            $reminder = $total_number_of_items % $total_number_of_item_get_for_this_page;
        }else {
            $total_number_of_pages = intval($total_number_of_items / $half_of_total_items);
            $reminder = $total_number_of_items % $half_of_total_items;
        }
        if ($reminder > 0) {
            $total_number_of_pages += 1;
        }
    }else {
        $total_number_of_pages = 1;
    }
@endphp
<div class="pagination_part">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="{{ $orders->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
            @for ($i=1; $i <= $total_number_of_pages; $i++)
                @if (($orders->currentPage() + 2) == $i)
                    <li class="page-item"><a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a></li>
                @endif
                @if (($orders->currentPage() + 1) == $i)
                    <li class="page-item"><a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a></li>
                @endif
                @if ($orders->currentPage() == $i)
                    <li class="page-item @if ($request_type == $i || $request_type == null) active @endif"><a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a></li>
                @endif
                @if (($orders->currentPage() - 1) == $i)
                    <li class="page-item"><a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a></li>
                @endif
                @if (($orders->currentPage() - 2) == $i)
                    <li class="page-item"><a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor
            <li class="page-item"><a class="page-link" href="{{ $orders->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
        </ul>
    </nav>
</div>
