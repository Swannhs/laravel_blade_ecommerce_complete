<!-- footer part -->
<footer class="footer_part">
    <div class="container">
        <div class="row justify-content-between pt-15 footer_reverce">
            <div class="col-lg-5">
                <div class="single_footer_content copy_r_mt ">
                    <h4>{{ app('general_setting')->footer_about_title }}</h4>
                    <p>{{ app('general_setting')->footer_about_description }}</p>
                    <div class="copyright_text">
                        <p>
                            @php echo app('general_setting')->footer_copy_right; @endphp
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer_content">
                    <div class="single_footer_content">
                        <h4>{{ app('general_setting')->footer_section_one_title }}</h4>
                        <ul>
                            @foreach($sectionWidgets->where('section','1') as $page)
                                @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                                    @continue
                                @endif
                                <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="single_footer_content">
                        <h4>{{ app('general_setting')->footer_section_two_title }}</h4>
                        <ul>
                            @foreach($sectionWidgets->where('section','2') as $page)
                                @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                                    @continue
                                @endif
                                <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="single_footer_content">
                        <h4>{{ app('general_setting')->footer_section_three_title }}</h4>
                        <ul>
                            @foreach($sectionWidgets->where('section','3') as $page)
                                @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                                    @continue
                                @endif
                                <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="footer__sticky__menu">
    <a href="{{url('/')}}">
        <i class="ti-home"></i>
        <span>{{__('common.home')}}</span>
    </a>
    <a href="{{ route('frontend.customer_profile') }}" class="lang_drawer_activator">
        <i class="ti-receipt"></i>
        <span>{{__('defaultTheme.language')}}</span>
    </a>
    <a href="{{ route('frontend.cart') }}">
        <i class="ti-shopping-cart"></i>
        <span>{{__('common.cart')}}</span>
    </a>
    <a href="{{ route('frontend.dashboard') }}" class="account_drawer_activator">
        <i class="ti-user"></i>
        <span>{{__('common.account')}}</span>
    </a>
</div>

{{-- facebook chat start --}}
@php
    $messanger_data = \Modules\GeneralSetting\Entities\FacebookMessage::first();
@endphp
@if($messanger_data->status == 1)
    @php echo $messanger_data->code; @endphp
@endif
{{-- facebook chat end --}}

@include('frontend.default.partials._script')

@stack('scripts')

</body>

</html>
