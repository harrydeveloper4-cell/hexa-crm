@extends('admin.layout.master')
@section('title', 'Orders')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Orders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item active">{{ __('Orders') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <a class = "btn btn-info float-right" href = "{{ route('payment.create_order') }}" target = "_blank"><i class = "icon-plus"></i> Create</a>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                {{-- <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Orders</h4>
                </div> --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    {{-- <th><input type = "checkbox" class = "check-all"></th> --}}
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Brand Name</th>
                                    <th>Amount</th>
                                    <th>Sales Person</th>
                                    <th>Support Person</th>
                                    <th>Payment Method</th>
                                    <th>Payment Link</th>
                                    {{-- <th>Invoices</th> --}}
                                    <th>Status</th>
                                    <th>Document</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($orders)) 
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            {{-- <td><input type = "checkbox" class = "check" value = "{{ $order->id }}"></td> --}}
                                            <td>{{$key + 1}}</td>
                                            <td>#{{ $order->previous_order_id == null ? $order->order_number :  '-'  }}</td>
                                            <td>{{ $order->brand_details->name }}</td>
                                            <td>{{ $order->sale_amount . ' ' . $order->sale_currency }} </td>
                                            <td>{{ $order->sales_email }}</td>
                                            <td>
                                                @if ($order->previous_order_id == null)
                                                    <span>{{ $order->support_person ? (trim(($order->support_person->firstname ?? '') . ' ' . ($order->support_person->lastname ?? '')) ?: $order->support_person->email) : '--' }}</span>
                                                    @if (isset($supportPersons))
                                                        <a href="javascript:void(0)" class="badge badge-info assignSupport"
                                                            data-toggle="modal" data-target="#assignSupportModal"
                                                            data-id="{{ $order->id }}"
                                                            data-support="{{ $order->support_person_id }}">
                                                            Assign
                                                        </a>
                                                    @endif
                                                @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->payment_gateway }}</td>
                                            <td>
                                                @if (isset($order->payment_status) && $order->payment_status == 'unpaid')
                                                    @if (isset($order->payment_link) && $order->payment_link != null)
                                                        @if (\Carbon\Carbon::parse($order->expires_at)->toDateString() < now()->toDateString())
                                                            <span href="javascript:void(0)" class="badge badge-danger"
                                                                style="color: #fff;">
                                                                Link Expired
                                                            </span>
                                                            <a href="javascript:void(0)"
                                                                class="badge badge-primary createNewLink" data-toggle="modal"
                                                                data-target="#exampleModalCenter" data-id="{{ $order->id }}">
                                                                Generate New Link
                                                            </a>
                                                        @else
                                                            @php
                                                                $now = \Carbon\Carbon::now();
                                                                $expiresAt = \Carbon\Carbon::parse($order->expires_at);
                                                                $diffInMinutes = $expiresAt->diffInMinutes($now);
                                                                $hours = intdiv($diffInMinutes, 60);
                                                                $minutes = $diffInMinutes % 60;
                                                            @endphp
                                                            <a href="javascript:void(0)"
                                                                class="copyLink me-2 badge badge-warning" data-toggle="tooltip"
                                                                data-placement="top" title=""
                                                                data-original-title="Expires in {{ $hours }} hour(s) and {{ $minutes }} minute(s)"
                                                                style="color: #fff;" data-platform_name="link copy"
                                                                data-payment_link="{{ $order->payment_link }}">
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
                                            {{-- <td><a href="{{route('admin.invoices.index', $order->id)}}" class="btn btn-info">Invoices</a></td> --}}
                                            <td>
                                                <div class="dropdown">

                                                    @if ($order->status == 'pending')
                                                        @php
                                                            $status = 'Pending';
                                                            $color = 'btn-warning';
                                                        @endphp
                                                    @elseif($order->status == 'processing')
                                                        @php
                                                            $status = 'Processing';
                                                            $color = 'btn-info';
                                                        @endphp
                                                    @elseif($order->status == 'completed')
                                                        @php
                                                            $status = 'Completed';
                                                            $color = 'btn-primary';
                                                        @endphp
                                                    @elseif($order->status == 'discarded')
                                                        @php
                                                            $status = 'Discarded';
                                                            $color = 'btn-secondary';
                                                        @endphp
                                                    @elseif($order->status == 'refunded')
                                                        @php
                                                            $status = 'Refunded';
                                                            $color = 'btn-danger';
                                                        @endphp
                                                    @endif

                                                    <button class="btn {{ $color ?? '' }} dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        {{ $status ?? '' }}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.orders.status', ['id' => $order->id, 'status' => 'pending']) }}">Pending</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.orders.status', ['id' => $order->id, 'status' => 'processing']) }}">Processing</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.orders.status', ['id' => $order->id, 'status' => 'completed']) }}">Completed</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.orders.status', ['id' => $order->id, 'status' => 'discarded']) }}">Discarded</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.orders.status', ['id' => $order->id, 'status' => 'refunded']) }}">Refunded</a>
                                                    </div>
                                                </div>


                                            </td>
                                            <td>
                                                @if (isset($order->pdf_agreement))
                                                    <a class="btn btn-success" href = "{{ asset($order->pdf_agreement) }}" download="">PDF</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href = "{{ route('admin.orders.show', ['id' => $order->id]) }}"><i
                                                        class = "icon-eye"></i></a>
                                                @if ($order->payment_status == 'unpaid')
                                                    <a href = "{{ route('admin.orders.edit', ['id' => $order->id]) }}"><i
                                                            class = "icon-pencil"></i></a>
                                                @endif
                                                <a class = "delete_confirmation"
                                                    href = "{{ route('admin.orders.destroy', ['id' => $order->id]) }}"><i
                                                        class = "icon-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            <tfoot>
                                {{-- <th><input type = "checkbox" class = "check-all"></th> --}}
                                <th>ID</th>
                                <th>Order ID</th>
                                <th>Brand Name</th>
                                <th>Amount</th>
                                <th>Sales Person</th>
                                <th>Support Person</th>
                                <th>Payment Method</th>
                                <th>Payment Link</th>
                                {{-- <th>Invoices</th> --}}
                                <th>Status</th>
                                <th>Document</th>
                                <th>Action</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @if (isset($orders) && isset($supportPersons))
        <div class="modal fade" id="assignSupportModal" tabindex="-1" role="dialog" aria-hidden="true"
            style="display: none;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Client to Support Person</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" id="assignSupportForm">
                            @csrf
                            <div class="form-group">
                                <label>Support Person (Project Manager) *</label>
                                <select class="form-control" name="support_person_id" id="support_person_id" required>
                                    <option value="">Select Support Person</option>
                                    @foreach ($supportPersons as $supportPerson)
                                        <option value="{{ $supportPerson->id }}">
                                            {{ trim(($supportPerson->firstname ?? '') . ' ' . ($supportPerson->lastname ?? '')) ?: $supportPerson->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(isset($order))
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle1">Create New Link</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post"
                            id = "form">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-md-12">
                                <label>Link Expiry Date *</label>
                                <input type="date" class="form-control" name="expiry_date" id="expiry_date"
                                    min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.createNewLink', function() {
                var orderId = $(this).data('id');
                var actionUrl = "{{ route('orders.request_payment_link', ['id' => ':id']) }}";
                actionUrl = actionUrl.replace(':id', orderId);
                $('#form').attr('action', actionUrl);
            });

            $(document).on('click', '.assignSupport', function() {
                var orderId = $(this).data('id');
                var supportId = $(this).data('support');
                var actionUrl = "{{ route('admin.orders.assign_support', ['id' => ':id']) }}";
                actionUrl = actionUrl.replace(':id', orderId);
                $('#assignSupportForm').attr('action', actionUrl);
                $('#support_person_id').val(supportId ? String(supportId) : '');
            });
        });
    </script>
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
