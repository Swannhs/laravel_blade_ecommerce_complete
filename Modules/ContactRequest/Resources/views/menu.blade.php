@if (permissionCheck('contact_request'))
    @php
        $contactrequest = false;
        if(request()->is('contactrequest/contact'))
        {
            $contactrequest = true;
        }
    @endphp
    <li class="{{ $contactrequest ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,9)->position }}" data-status="{{ menuManagerCheck(1,9)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $contactrequest ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-user"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('contactRequest.contact_request') }}</span>
            </div>
        </a>
        <ul id="contact_request_ul">
            @if(menuManagerCheck(2,9,'contactrequest.contact.index')->status == 1)
            <li data-position="{{ menuManagerCheck(2,9,'contactrequest.contact.index')->position }}">
                <a href="{{ route('contactrequest.contact.index') }}" @if (request()->is('contactrequest/contact')) class="active" @endif>{{ __('contactRequest.contact_mail') }}</a>
            </li>
            @endif
        </ul>
    </li>
@endif
