@extends('admin.layout.master')
@section('title', 'Brands')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Brands') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item active">{{ __('Brands') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Brands</h4>
                    <a class = "btn btn-info float-right" href = "{{ route('admin.brands.create') }}"><i
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
                                    {{-- <th><input type = "checkbox" class = "check-all"></th> --}}
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Email Address</th>
                                    <th>Logo</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Packages</th>
                                    <th>Merchants</th>

                                    @if ($authUser->has_permission('brand_edit'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $key => $brand)
                                    <tr>
                                        {{-- <td><input type = "checkbox" class = "check" value = "{{ $brand->id }}">
                                        </td> --}}
                                        <td>{{ $brand->id }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $brand->phonenumber }}</td>
                                        <td>{{ $brand->email_address }}</td>
                                        <td><img src = "{{ asset($brand->logo) }}" class = "w-50"></td>
                                        <td><a href = "{{ $brand->link }}" target = "_blank">{{ $brand->link }}</a></td>
                                        <td>
                                            @if ($brand->status == 'active')
                                                <span class = "badge badge-primary">Active</span>
                                            @else
                                                <span class = "badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @forelse ($brand->packageList() as $package)
                                                <span class="badge badge-light border mb-1">{{ $package->package_name }}</span>
                                            @empty
                                                <span class="text-muted">-</span>
                                            @endforelse
                                        </td>
                                        <td>
                                            @forelse ($brand->merchantList() as $merchant)
                                                <span class="badge badge-light border mb-1">{{ $merchant->merchant }}</span>
                                            @empty
                                                <span class="text-muted">-</span>
                                            @endforelse
                                        </td>
                                        @if ($authUser->has_permission('brand_edit'))
                                        <td>
                                            <a href = "{{ route('admin.brands.edit', ['id' => $brand->id]) }}"><i
                                                    class = "icon-pencil"></i></a>
                                            <a class = "delete_confirmation"
                                                href = "{{ route('admin.brands.destroy', ['id' => $brand->id]) }}"><i
                                                    class = "icon-trash"></i></a>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script>
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

                let bool = confirm('Are you sure you want to delete this brand');
                if (bool) {
                    window.location.href = url;
                }
            })
        })
    </script> --}}
@endsection
