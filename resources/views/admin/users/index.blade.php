@extends('admin.layout.master')
@section('title', 'Users')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Users') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Users') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Users</h4>
                    <a class = "btn btn-info float-right" href = "{{ route('users.create') }}"><i
                            class = "icon-plus"></i> Create</a>
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
                                    <th>ID#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>User Role</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip Code</th>
                                    <th>Country</th>
                                    <th>Action</th>
                                    <!-- <th>Orders</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            {{ $user->id }}
                                        </td>
                                        <td>{{ $user->firstname }}</td>
                                        <td>{{ $user->lastname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role->role }}</td>
                                        <td>{{ $user->billing_phonenumber }}</td>
                                        <td>{{ $user->billing_address }}</td>
                                        <td>{{ $user->city }}</td>
                                        <td>{{ $user->state }}</td>
                                        <td>{{ $user->postalcode }}</td>
                                        <td>{{ $user->country }}</td>
                                        <td>
                                            <a 
                                                href="{{ route('users.edit', ['id' => $user->id]) }}"
                                            >
                                                <i class="icon-pencil"></i>
                                            </a>
                                            <a 
                                              class = "delete_confirmation"
                                              href="{{ route('users.destroy', ['id' => $user->id]) }}"
                                            >
                                                <i class="icon-trash"></i>
                                            </a>
                                        </td>
                                        {{--
                                        <td>
                                            <a href="{{route('admin.customer.orders', ['email' => $user->email])}}" class="btn btn-info">
                                                Orders
                                            </a>
                                        </td>
                                        --}}
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <th>ID#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>User Role</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Zip Code</th>
                                <th>Country</th>
                                <th>Action</th>
                                <!-- <th>Orders</th> -->
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

                let bool = confirm('Are you sure you want to delete this User');
                if (bool) {
                    window.location.href = url;
                }
            })
        })
    </script>
@endsection
