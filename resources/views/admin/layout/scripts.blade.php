<!-- START: Template JS-->
<script src="{{ asset('admin/dist/vendors/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/moment/moment.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('admin/dist/vendors/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/select2.script.js') }}"></script>

<script src="{{ asset('admin/dist/vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/datatable/buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/datatable.script.js') }}"></script>

<script src="{{ asset('admin/dist/vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('admin/dist/js/summernote.script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script src="{{ asset('admin/dist/vendors/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/apexcharts/apexcharts.min.js') }}"></script>
@yield('scripts')
<!-- END: Template JS-->

<!-- START: APP JSS-->
<script src="{{ asset('admin/dist/js/app.js') }}"></script>
<script src="{{ asset('admin/dist/vendors/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/toastr.script.js') }}"></script>

<script type="text/javascript">
    (function($) {
        "use strict";
        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-top-right",
            "closeButton": true,
            "progressBar": true
        };
    })(jQuery);

    $(document).ready(function() {
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // Delete Confirmation
    $(document).on('click', '.delete_confirmation', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');

        swal({
            title: "{{ __('Are you sure?') }}",
            text: "{{ __('Once deleted, you will not be able to recover this!') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.href = url;
            } else {
                swal("{{ __('Your data is safe!') }}", {
                    icon: "info",
                    timer: 2000,
                });
            }
        });
    });
</script>

<!-- SIDEBAR ACCORDION SCRIPT -->
<script>
    

     $("#brand-management").on('click',function () {
        alert("opj")
        $(this).toggleClass("menu-open");
    });
    $(document).ready(function () {
        // Direct body delegation taake koi aur plugin click event na rokay
        $('body').off('click', '.sidebar-menu li.dropdown > a').on('click', '.sidebar-menu li.dropdown > a', function (e) {
            var $link = $(this);
            var $parentLi = $link.closest('li.dropdown');
            var $subMenu = $parentLi.children('ul');

            if ($subMenu.length > 0) {
                e.preventDefault();
                e.stopPropagation();

                // Agar pehle se open hai
                if ($parentLi.hasClass('menu-open')) {
                    $parentLi.removeClass('menu-open');
                    $subMenu.slideUp(200);
                } else {
                    // Baqi open menus ko close karna
                    $('.sidebar-menu li.dropdown.menu-open').not($parentLi).removeClass('menu-open').children('ul').slideUp(200);

                    // Current menu open karna
                    $parentLi.addClass('menu-open');
                    $subMenu.slideDown(200);
                }
            }
        });

        // Jo page open ho uska parent automatic khula rahe
        var currentUrl = window.location.href.split(/[?#]/)[0];
        $('.sidebar-menu li.dropdown ul li a').each(function () {
            if (this.href.split(/[?#]/)[0] === currentUrl) {
                var $parent = $(this).closest('li.dropdown');
                $parent.addClass('menu-open');
                $parent.children('ul').show();
            }
        });
    });
   
</script>