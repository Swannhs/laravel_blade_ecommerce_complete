@props(['route' => 'admin.dashboard'])

<section class="content-header">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-5 col-8">
            @php echo Breadcrumbs::render($route) @endphp
        </div>
        <div class="col-lg-4 ml-auto col-md-6 col-sm-7 col-4">
            <div class="header-object">
            <span class="option-search float-right d-none d-sm-block">
                <span class="search-wrapper">
                    <input type="text" placeholder="{{ __('common.search_here') }}"><i class="ti-search"></i>
                </span>
            </span>
            </div>
        </div>
    </div>
</section>
