<!DOCTYPE html>
<html>
@include('backEnd.partials._header')

<body class="admin">
    <div class="main-wrapper min_height_600">
        <!-- Sidebar  -->
        @include('backEnd.partials._sidebar')

        <!-- Page Content  -->
        <div id="main-content">
            @include('backEnd.partials._menu')


            @section('mainContent')
            @show
            @include('backEnd.partials._invoice_modal')
        </div>

    </div>


    @include('backEnd.partials._footer')

    @include('backEnd.partials._modal')

    @include('backEnd.partials._scripts')

</body>

</html>
