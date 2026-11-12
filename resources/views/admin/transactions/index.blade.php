@extends('admin.layout.master')
@section('title', 'Transactions')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Transactions') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Transactions') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Transactions</h4>
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
                        <table id="example" class="display table dataTable table-striped table-bTransactioned">
                            <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Order Number</th>
                                    <th>Sales Amount</th>
                                    <th>Payment Method</th>
                                    <th>Transaction Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $totalTransaction = $transactions->count(); 
                                @endphp

                                @foreach($transactions as $key => $transaction)
                                    <tr>
                                        <td>{{$totalTransaction - $loop->iteration+1}}</td>
                                        {{-- <td>{{ $transaction->id }}</td> --}}
                                        <td>{{ $transaction->orders->order_number }}</td>
                                        <td>{{ $transaction->orders->sale_amount . ' ' . $transaction->orders->sale_currency }}
                                        </td>
                                        <td>{{ $transaction->orders->payment_gateway }} </td>
                                        <td>{{ date('d/m/Y H:i', strtotime($transaction->created_at)) }}</td>

                                        <td>
                                            <a href = "{{ route('admin.orders.show', ['id' => $transaction->order_id]) }}"><i
                                                    class = "icon-eye"></i></a>

                                            <a class = "delete_confirmation"
                                                href = "{{ route('admin.orders.destroy', ['id' => $transaction->order_id]) }}"><i
                                                    class = "icon-trash"></i></a>
                                        </td>
                                    </tr>
                          
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th>ID</th>
                                <th>Order Number</th>
                                <th>Sales Amount</th>
                                <th>Payment Method</th>
                                <th>Transaction Date</th>
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
        $(document).ready(function() {

            $(".check-all").click(function() {
                $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
            });

            $("input[type=checkbox]").click(function() {
                if (!$(this).prop("checked")) {
                    $(".check-all").prop("checked", false);
                }
            });

            $(document).on('change', '#update-status', function() {

                if ($(this).val() != '') {
                    let status = $(this).val();
                    var ids = [];
                    $.each($(".check:checked"), function() {
                        ids.push($(this).val());
                    });

                    if (ids.length > 0) {
                        let bool = confirm(
                            'Are you sure you want to update status of selected inquiries as ' + status)

                        if (bool) {
                            $.ajax({
                                url: "",
                                type: "POST",
                                data: {
                                    status: status,
                                    ids: ids,
                                    '_token': "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    $("input[type=checkbox]").prop("checked", false)
                                    window.location.reload()

                                },
                                error: function(error) {
                                    alert('Inquiries updating failed')
                                }
                            })
                        }
                    }
                } else {
                    alert('Please select atleast one inquiry')
                }
            })

            $(document).on('click', '.inquiry-detail', function() {
                var id = $(this).data('id')

                $.ajax({
                    url: route,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        alert(work)
                    }
                })
            })

            $(document).on('click', '.destroy', function(e) {

                e.preventDefault();

                let url = $(this).attr('href');

                let bool = confirm('Are you sure you want to delete this Order');
                if (bool) {
                    window.location.href = url;
                }
            })
        })

        // $(document).ready(function () {
        //     $('#example').DataTable({
        //         order: [[0, 'desc']],
        //     });
        // });
    </script>
@endsection
