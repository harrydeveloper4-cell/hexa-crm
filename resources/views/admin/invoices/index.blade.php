@extends('admin.layout.master')
@section('title', 'Invoices')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Invoices') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Invoices') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Invoices</h4>
                    <a class = "btn btn-info float-right" href = "#"><i class = "icon-plus"></i>Generate Invoice</a>
                    {{-- <span class = "float-right">
                    <select class = "form-control" id = "update-status">
                        <option value = "">Update Status</option>
                        <option value = "Pending">Pending</option>
                        <option value = "Delivered">Delivered</option>
                    </select>
                </span> --}}

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    {{-- <th><input type = "checkbox" class = "check-all"></th> --}}
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Total Amount</th>
                                    <th>Invoice Amount</th>
                                    <th>Payment Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($invoices as $key => $invoice)
                                    <tr>
                                        {{-- <td><input type = "checkbox" class = "check" value = "{{ $order->id }}"></td> --}}
                                        <td>{{ $invoice->id }}</td>
                                        <td>#{{ $invoice->order->order_number }}</td>
                                        <td>{{ $invoice->order->sale_amount }} </td>
                                        <td>{{ $invoice->amount }}</td>
                                        <td>
                                            @if (isset($invoice->is_paid) && $invoice->is_paid == 'unpaid')
                                                @if (isset($invoice->payment_link) && $invoice->payment_link != null)
                                                    @if (isset($invoice->order->expires_at) && $invoice->order->expires_at < now())
                                                        <span href="javascript:void(0)" class="badge badge-danger"
                                                            style="color: #fff;">
                                                            Link Expired
                                                        </span>
                                                        {{-- <a href="javascript:void(0)"
                                                            class="badge badge-primary createNewLink" data-toggle="modal"
                                                            data-target="#exampleModalCenter" data-id="{{ $order->id }}">
                                                            New Link
                                                        </a> --}}
                                                    @else
                                                        @php
                                                            $now = \Carbon\Carbon::now();
                                                            $expiresAt = \Carbon\Carbon::parse(
                                                                $invoice->order->expires_at,
                                                            );
                                                            $diffInMinutes = $expiresAt->diffInMinutes($now);
                                                            $hours = intdiv($diffInMinutes, 60);
                                                            $minutes = $diffInMinutes % 60;
                                                        @endphp
                                                        <a href="javascript:void(0)"
                                                            class="copyLink me-2 badge badge-warning" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Expires in {{ $hours }} hour(s) and {{ $minutes }} minute(s)"
                                                            style="color: #fff;" data-platform_name="link copy"
                                                            data-payment_link="{{ $invoice->payment_link }}">
                                                            Copy link <i class="icon-docs"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="badge badge-danger">Payment link unavailable</span>
                                                @endif
                                            @else
                                                <span class="badge badge-success">Paid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class = "delete_confirmation"
                                                href = "#"><i
                                                    class = "icon-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            <tfoot>
                                {{-- <th><input type = "checkbox" class = "check-all"></th> --}}
                                <th>ID</th>
                                <th>Order ID</th>
                                <th>Total Amount</th>
                                <th>Invoice Amount</th>
                                <th>Payment Link</th>
                                <th>Action</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.copyLink', function() {
            navigator.clipboard.writeText($(this).data('payment_link')).then(() => {
                toastr.success('Copied to clipboard!');
            }).catch(() => {
                toastr.error('Failed to copy to clipboard');
            });
        });
        // $(document).ready(function() {

        //     $(".check-all").click(function() {
        //         $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
        //     });

        //     $("input[type=checkbox]").click(function() {
        //         if (!$(this).prop("checked")) {
        //             $(".check-all").prop("checked", false);
        //         }
        //     });

        //     $(document).on('change', '#update-status', function() {

        //         if ($(this).val() != '') {
        //             let status = $(this).val();
        //             var ids = [];
        //             $.each($(".check:checked"), function() {
        //                 ids.push($(this).val());
        //             });

        //             if (ids.length > 0) {
        //                 let bool = confirm(
        //                     'Are you sure you want to update status of selected inquiries as ' + status)

        //                 if (bool) {
        //                     $.ajax({
        //                         url: "",
        //                         type: "POST",
        //                         data: {
        //                             status: status,
        //                             ids: ids,
        //                             '_token': "{{ csrf_token() }}"
        //                         },
        //                         success: function(data) {
        //                             $("input[type=checkbox]").prop("checked", false)
        //                             window.location.reload()

        //                         },
        //                         error: function(error) {
        //                             alert('Inquiries updating failed')
        //                         }
        //                     })
        //                 }
        //             }
        //         } else {
        //             alert('Please select atleast one inquiry')
        //         }
        //     })

        //     $(document).on('click', '.inquiry-detail', function() {
        //         var id = $(this).data('id')

        //         $.ajax({
        //             url: route,
        //             type: 'GET',
        //             data: {
        //                 id: id
        //             },
        //             success: function(data) {
        //                 alert(work)
        //             }
        //         })
        //     })

        //     $(document).on('click', '.destroy', function(e) {

        //         e.preventDefault();

        //         let url = $(this).attr('href');

        //         let bool = confirm('Are you sure you want to delete this Order');
        //         if (bool) {
        //             window.location.href = url;
        //         }
        //     })
        // })
    </script>
@endsection
