// (function ($) {
//     "use strict";
// var editor;
//  $('#example').DataTable({
//     dom: 'Bfrtip',
//                 buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print',
//                 ],
//      responsive: true
//  });
// })(jQuery);
 $(document).ready( function () {
(function ($) {
    "use strict";
var editor;
 $('#example').DataTable({
    dom: 'Bfrtip',
    lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 Rows', '25 Rows', '50 Rows', 'Show All' ]
        ],
                buttons: [
                    'pageLength'
                ],
     responsive: true
 });
})(jQuery);
} );
