    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('script.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/toastr/toastr.min.css') }}">
    
    
    
    
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="@yield('desc')">
    <meta name="author" content="@yield('title')">
    <meta property="og:title" content="Payment | @yield('title')">
    <meta property="og:image:secure_url" content="@yield('img')">
    
    <meta property="og:image:url" content="@yield('url')" /> 
    <meta property="og:image:type" content="image/png" /> 
    <meta property="og:image:width" content="400" /> 
    <meta property="og:image:height" content="300" />

    <link href="@yield('img')" rel="icon">
    
    <meta property="og:site_name" content="Payment | @yield('title')" />
    <meta property="og:description" content="@yield('desc')">
     <link rel="apple-touch-icon" href="@yield('img')">
    <link rel="icon" href="@yield('img')">
   
    @yield('meta')