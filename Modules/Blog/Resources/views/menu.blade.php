@if (permissionCheck('blog_module'))
    @php
        $blog = false;

        if(request()->is('blog/*'))
        {
            $blog = true;
        }
    @endphp
    <li class="{{ $blog ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,4)->position }}" data-status="{{ menuManagerCheck(1,4)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $blog ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-users"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('blog.blog') }}</span>
            </div>
        </a>
        <ul>
            @if (permissionCheck('blog.post.get-data') && menuManagerCheck(2,4,'blog.post.get-data')->status == 1)
                <li data-position="{{ menuManagerCheck(2,4,'blog.post.get-data')->position }}">
                    <a href="{{ route('blog.posts.index') }}" class="@if(request()->is('blog/posts/*') || request()->is('blog/posts')) active @endif">{{ __('blog.blog') }}</a>
                </li>
            @endif
            @if (permissionCheck('blog.categories.index') && menuManagerCheck(2,4,'blog.categories.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,4,'blog.categories.index')->position }}">
                    <a href="{{ route('blog.categories.index') }}" class="{{request()->is('blog/categories') ? 'active' : ''}}">{{ __('blog.blog_category') }}</a>
                </li>
            @endif
        </ul>
    </li>
@endif
