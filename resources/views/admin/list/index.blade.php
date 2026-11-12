@extends('admin.layout.master')
@section('title', 'Users')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Admins') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Admin Users') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Admin</h4>
                    <a class = "btn btn-info float-right" href = "{{ route('users.create') }}"><i class = "icon-plus"></i> Create</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $key => $admin)
                                    <tr>
                                        <td>
                                            {{ ++$key }}
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-status-toggle btn-{{ $admin->is_active == 1 ? 'success' : 'danger' }}"
                                                    data-id="{{ $admin->id }}"
                                                    data-status="{{ $admin->is_active }}">
                                                {{ $admin->is_active == 1 ? 'Active' : 'Deactive' }}
                                            </button>
                                        </td>
                                        <td>{{ $admin->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit-admin" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}">
                                                <i class="icon-pencil"></i>
                                            </a>
                                            <a class = "delete_confirmation"
                                              href="{{ route('admins.destroy', ['id' => $admin->id]) }}">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <th>ID#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Edit Admin Modal -->
<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="adminEditForm">
      @csrf
      <input type="hidden" name="id" id="admin_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Admin</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="admin_name" class="form-control" required>
            </div>
            <div class="form-group position-relative">
                <label>New Password</label>
                <input type="password" name="password" id="admin_password" class="form-control pr-5" autocomplete="new-password">

                <span class="position-absolute" style="top: 74%; transform: translateY(-50%); right: 15px; cursor: pointer;">
                    <i class="fa fa-eye" id="togglePassword"></i>
                </span>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


@endsection
@section('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <script>
        $(document).ready(function() {

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


<script>
$(document).ready(function() {

    // Open modal and fill data
    $(document).on('click', '.edit-admin', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');

        $('#admin_id').val(id);
        $('#admin_name').val(name);
        $('#admin_password').val('');

        $('#editAdminModal').modal('show');
    });

    // Submit form via AJAX
    $('#adminEditForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admins.updateAjax') }}", // define this route in web.php
            type: 'POST',
            data: formData,
            success: function(response) {
                alert('Admin updated successfully');
                location.reload(); // or update table row manually
            },
            error: function(xhr) {
                alert('Update failed');
            }
        });
    });
});


$(document).on('click', '.btn-status-toggle', function() {
    let id = $(this).data('id');
    let currentStatus = $(this).data('status');

    if (confirm('Do you want to update the status?')) {
        $.ajax({
            url: "{{ route('admins.statusToggle') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                currentStatus: currentStatus
            },
            success: function(response) {
                alert('Status updated');
                location.reload(); // Or update status button dynamically
            }
        });
    }
});

$(document).ready(function () {
    $('#togglePassword').on('click', function () {
        console.log();
        let input = $('#admin_password');
        let icon = $(this);

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});

</script>


@endsection
