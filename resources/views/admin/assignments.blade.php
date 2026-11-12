@extends('admin.layout.master')
@section('title', 'Assignments')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Assignments') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Assignments') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Inquiries</h4>
                    <span class = "float-right">
                        <select class = "form-control" id = "update-status">
                            <option value = "">Update Status</option>
                            <option value = "Pending">Pending</option>
                            <option value = "Delivered">Delivered</option>
                        </select>
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><input type = "checkbox" class = "check-all"></th>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Vin Number</th>
                                    <th>Paid Amount</th>
                                    <th>Paid Status</th>
                                    <th>Card Last Digits</th>
                                    <th>Delivery Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = count($assignments);
                                @endphp
                                @foreach ($assignments as $key => $assign)
                                    <tr>
                                        <td><input type = "checkbox" class = "check" value = "{{ $assign->id }}"></td>
                                        <td>{{ --$count }}</td>
                                        <td>{{ $assign->email }}</td>
                                        <td>{{ $assign->phonenumber }}</td>
                                        <td>{{ $assign->vin_number }}</td>
                                        <td>{{ $assign->paid_amount }}</td>
                                        <td>{{ $assign->status == 'Paid' ? 'Paid' : 'Unpaid' }}</td>
                                        <td>{{ $assign->lastdigit }}</td>
                                        <td>{{ $assign->delivery_status }}</td>
                                        <td><a href = "{{ route('inquiry.detail', ['id' => $assign->id]) }}"><i
                                                    class = "icon-eye"></i></a></td>
                                    </tr>
                                @endforeach

                            <tfoot>
                                <th>&nbsp;</th>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Paid Amount</th>
                                <th>Contact Number</th>
                                <th>Vin Number</th>
                                <th>Paid Status</th>
                                <th>Card Last Digits</th>
                                <th>Delivery Status</th>
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
                                url: "{{ route('update.inquiries') }}",
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

        })
    </script>
@endsection
