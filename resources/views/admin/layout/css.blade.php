<!-- START: Template CSS-->
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/jquery-ui/jquery-ui.theme.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/simple-line-icons/css/simple-line-icons.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/flags-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/toastr/toastr.min.css') }}">

<link rel="stylesheet" href="{{ asset('admin/dist/vendors/datatable/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/datatable/buttons/css/buttons.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('admin/dist/vendors/sweetalert/sweetalert.css') }}">

<link rel="stylesheet" href="{{ asset('admin/dist/vendors/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/select2/css/select2-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/dist/vendors/summernote/summernote-bs4.css') }}">
@yield('css')

<!-- END Template CSS-->

<!-- START: Custom CSS-->
<link rel="stylesheet" href="{{ asset('admin/dist/css/main.css') }}">
<!-- END: Custom CSS-->
{{--
<style>
    /* Default tor par submenus hide rahenge */
    .sidebar-menu li.dropdown > ul {
        display: none;
        padding-left: 15px;
    }

    /* Icon ya Text par click anchor se bypass na ho */
    .sidebar-menu li.dropdown > a * {
        pointer-events: none;
    }

    /* Arrow icon indicator */
    .sidebar-menu li.dropdown > a {
        position: relative;
        cursor: pointer;
        display: block;
    }

    .sidebar-menu li.dropdown > a::after {
        content: "\e604";
        font-family: 'simple-line-icons';
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        transition: transform 0.25s ease;
    }

    .sidebar-menu li.dropdown.menu-open > a::after {
        transform: translateY(-50%) rotate(180deg);
    }
</style>
--}}