<!DOCTYPE html>
<html lang="en">
<!-- START: Head-->

<head>
    <meta charset="UTF-8">
    <title>Admin {{ env('APP_NAME') }} - @yield('title')</title>
    @include('admin.layout.meta')
    @include('admin.layout.css')
    
</head>
<!-- END Head-->

<!-- START: Body-->
<body id="main-container" class="default">
    <!-- START: Pre Loader-->
    <div class="se-pre-con">
        <div class="loader"></div>
    </div>
    <!-- END: Pre Loader-->
    {{-- <input type = "hidden" id = "success" value="{{ Session::has('success') ? Session::get('success') : '' }}">
    <input type = "hidden" id = "error" value="{{ Session::has('error') ? Session::get('error') : '' }}"> --}}
    @include('admin.layout.header')

    @include('admin.layout.sidebar')
    <!-- START: Main-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Breadcrumbs-->
            <div class="row ">
                <div class="col-12  align-self-center">
                    <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                        <div class="w-sm-100 mr-auto"><h4 class="mb-0">@yield('breadcrumb-title')</h4></div>
                        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                            @yield('breadcrumb-items')
                        </ol>
                    </div>
                </div>
            </div>
            <!-- END: Breadcrumbs-->

            <!-- START: Card Data-->   
                @yield('content')
            <!-- END: Card DATA-->
        </div>
    </main>
    <!-- END: Main-->

    <!-- START: Footer-->
    @include('admin.layout.footer')
    <!-- END: Footer-->

    <!-- START: Back to top-->
    <a href="#" class="scrollup text-center">
        <i class="icon-arrow-up"></i>
    </a>
    <!-- END: Back to top-->

    <!-- START: Scripts-->
      @include('admin.layout.scripts')
    <!-- END: Scripts-->
</body>
<!-- END: Body-->
</html>
