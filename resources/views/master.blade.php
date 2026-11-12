<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Admin Payment Terminal</title>
        <link rel="shortcut icon" href="{{asset('admin/dist/images/favicon.ico')}}" />
        <meta name="viewport" content="width=device-width,initial-scale=1"> 

        <!-- START: Template CSS-->
        <link rel="stylesheet" href="{{asset('admin/dist/vendors/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/dist/vendors/jquery-ui/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/dist/vendors/jquery-ui/jquery-ui.theme.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/dist/vendors/simple-line-icons/css/simple-line-icons.css')}}">        
        <link rel="stylesheet" href="{{asset('admin/dist/vendors/flags-icon/css/flag-icon.min.css')}}"> 
        <link rel="stylesheet" href="{{asset('admin/dist/vendors/toastr/toastr.min.css')}}">
        @stack('style')

        <!-- END Template CSS-->      

        <!-- START: Custom CSS-->
        <link rel="stylesheet" href="{{asset('admin/dist/css/main.css')}}">
        <!-- END: Custom CSS-->
</head>
<body>

@yield('content')
            <!-- START: Template JS-->
        <script src="{{asset('admin/dist/vendors/jquery/jquery-3.3.1.min.js')}}"></script>
        <script src="{{asset('admin/dist/vendors/jquery-ui/jquery-ui.min.js')}}"></script>
        <script src="{{asset('admin/dist/vendors/moment/moment.js')}}"></script>
        <script src="{{asset('admin/dist/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>    
        <script src="{{asset('admin/dist/vendors/slimscroll/jquery.slimscroll.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <!-- END: Template JS-->

        <!-- START: APP JS-->
        <script src="{{asset('admin/dist/js/app.js')}}"></script>
        @stack('scripts')
        
@stack('scripts')    
</body>
</html>