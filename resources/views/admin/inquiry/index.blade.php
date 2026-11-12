@extends('admin.layout.master')
@section('title', 'Contact Inquiries')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Contact Inquiries') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Contact Inquiries') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Inquiries</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inquiries as $key => $inquiry)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $inquiry->inquiries_name }}</td>
                                        <td>{{ $inquiry->inquiries_email }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($inquiry->created_at)) }}</td>
                                        <td><a href = "{{ route('admin.contact.inquiry.view', ['id' => $inquiry->id]) }}"><i
                                                    class = "icon-eye"></i></a></td>
                                    </tr>
                                @endforeach

                            <tfoot>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
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
