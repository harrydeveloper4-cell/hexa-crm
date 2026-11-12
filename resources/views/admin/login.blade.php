<!DOCTYPE html>
<html lang="en">
<!-- START: Head-->

<!-- Mirrored from html.designstream.co.in/pick/html/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 21 Apr 2021 19:47:32 GMT -->

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="shortcut icon" href="{{ asset('admin/dist/images/favicon.ico') }}" />
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- START: Template CSS-->
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/jquery-ui/jquery-ui.theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/flags-icon/css/flag-icon.min.css') }}">

    <!-- END Template CSS-->

    <!-- START: Page CSS-->
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/social-button/bootstrap-social.css') }}" />
    <!-- END: Page CSS-->

    <!-- START: Custom CSS-->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/main.css') }}">
    <!-- END: Custom CSS-->
</head>
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">
    <!-- START: Main Content-->
    <div class="container">
        <div class="row vh-100 justify-content-between align-items-center">
            <div class="col-12">
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Invalid Login</strong> {{ Session::get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                <form action="{{ route('admin.login.process') }}" method = "POST"
                    class="row row-eq-height lockscreen  mt-5 mb-5">
                    @csrf
                    <div class="lock-image col-12 col-sm-5"></div>
                    <div class="login-form col-12 col-sm-7">
                        <div class="form-group mb-3">
                            <label for="emailaddress">Email address</label>
                            <input class="form-control @error('emailaddress') is-invalid @enderror" type="email" value = "{{ old('email') }}" name = "email"
                                id="emailaddress" required="" placeholder="Enter your email">
                            @error('emailaddress')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name = "password" required="" id="password"
                                placeholder="Enter your password">
                            @error('password')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group mb-0">
                            <button class="btn btn-primary" type="submit"> Log In </button>
                        </div>

                        <div class="mt-2">
                            <a href="{{ route('user.login') }}" class="text-primary">User Login</a>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- END: Content-->

    <!-- START: Template JS-->
    <script src="{{ asset('admin/dist/vendors/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('admin/dist/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/dist/vendors/moment/moment.js') }}"></script>
    <script src="{{ asset('admin/dist/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/dist/vendors/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- END: Template JS-->
</body>
<!-- END: Body-->

</html>
