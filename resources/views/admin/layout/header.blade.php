<!-- START: Header-->
<div id="header-fix" class="header fixed-top">
    <div class="site-width">
        <nav class="navbar navbar-expand-lg  p-0">
            <a href="{{ route('dashboard') }}" class="horizontal-logo text-left">
                <img src="{{ asset('admin/images/logo-t.png') }}" style="width: 60px;" />
            </a>
            <div class="navbar-header  h-100 h4 mb-0 align-self-center logo-bar text-left">

            </div>
            <div class="navbar-header h4 mb-0 text-center h-100 collapse-menu-bar">
                <a href="#" class="sidebarCollapse" id="collapse"><i class="icon-menu"></i></a>
            </div>

            {{-- <form class="float-left d-none d-lg-block search-form">
                <div class="form-group mb-0 position-relative">
                    <input type="text" class="form-control border-0 rounded bg-search pl-5"
                        placeholder="Search anything...">
                    <div class="btn-search position-absolute top-0">
                        <a href="#"><i class="h6 icon-magnifier"></i></a>
                    </div>
                    <a href="#" class="position-absolute close-button mobilesearch d-lg-none"
                        data-toggle="dropdown" aria-expanded="false"><i class="icon-close h5"></i>
                    </a>

                </div>
            </form> --}}
            <div class="navbar-right ml-auto h-100">
                <ul class="ml-auto p-0 m-0 list-unstyled d-flex top-icon h-100">
                    {{-- <li class="d-inline-block align-self-center  d-block d-lg-none">
                        <a href="#" class="nav-link mobilesearch" data-toggle="dropdown"
                            aria-expanded="false"><i class="icon-magnifier h4"></i>
                        </a>
                    </li> --}}

                    <li class="dropdown align-self-center d-inline-block">
                        <a href="#" class="nav-link bell-notify" data-toggle="dropdown"
                            aria-expanded="false"><i class="icon-bell h4"></i>
                            <span class = "notify">
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right border   py-0" id = "notifications">
                        </ul>
                    </li>
                    <li class="dropdown user-profile align-self-center d-inline-block">
                        <a href="#" class="nav-link py-0" data-toggle="dropdown" aria-expanded="false">
                            <div class="media">
                                <img src="https://w7.pngwing.com/pngs/81/570/png-transparent-profile-logo-computer-icons-user-user-blue-heroes-logo-thumbnail.png"
                                    alt="" class="d-flex img-fluid rounded-circle" width="29">
                            </div>
                        </a>

                        <div class="dropdown-menu border dropdown-menu-right p-0">
                            <a href="" class="dropdown-item px-2 align-self-center d-flex">
                                <span class="icon-globe mr-2 h6 mb-0"></span> Visit Website</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.chnage_password') }}" class="dropdown-item px-2 align-self-center d-flex">
                                <span class="icon-key mr-2 h6 mb-0"></span> Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                class="dropdown-item px-2 text-danger align-self-center d-flex">
                                <span class="icon-logout mr-2 h6  mb-0"></span> Sign Out</a>
                        </div>

                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- END: Header-->

@section('scripts')
    {{-- <script>
        $(document).ready(function() {
            setInterval(function() {

                $.ajax({
                    url: "",
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.count > 0) {
                            $('.notify').html(
                                '<span class="badge badge-default"> <span class="ring"></span> <span class="ring-point"></span></span>'
                                )
                        }

                    }
                })

                $.ajax({
                    url: "",
                    type: 'GET',
                    success: function(data) {
                        $("#notifications").html(data.list)
                    }
                })


            }, 5000);
        })
        $(document).on('click', '.bell-notify', function() {
            $.ajax({
                url: "",
                type: 'GET',
                success: function(data) {
                    $('.notify').html('')
                }
            })
        })
    </script> --}}
@endsection
