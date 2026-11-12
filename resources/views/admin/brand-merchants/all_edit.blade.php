@extends('admin.layout.master')
@section('title', 'Merchants')

@section('breadcrumb-title')
    <h3>{{ __('Merchants') }} ({{ ucfirst($brand->name) }})</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">{{ __('Brands') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Merchants') }}</li>
@endsection

@section('content')
    @php
        $selected = array_map('strval', $brand->merchant ?? []);
    @endphp
    <div class="row">
        <div class="col-12 mt-4">
            <a class="btn btn-info float-right" href="{{ route('admin.brands.index') }}">Back</a>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Assign Merchants</h6>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('merchants.update.all') }}" method="POST" id="merchant-form">
                            @csrf
                            <input type="hidden" name="brand" value="{{ $brand->id }}">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="merchants">Merchants</label>
                                    <select class="form-control select2" name="merchants[]" id="merchants" multiple>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->id }}"
                                                {{ in_array((string) $merchant->id, $selected) ? 'selected' : '' }}>
                                                {{ $merchant->merchant }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Assigned Merchants</h6>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Config Keys</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($brand_merchants as $merchant)
                                        <tr>
                                            <td>{{ $merchant->id }}</td>
                                            <td>{{ $merchant->merchant }}</td>
                                            <td>
                                                @foreach (($merchant->config_keys ?? []) as $key => $value)
                                                    <span class="badge badge-light">{{ $key }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($merchant->status == 'active')
                                                    <span class="badge badge-primary">Active</span>
                                                @else
                                                    <span class="badge badge-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('merchant.edit', ['id' => $merchant->id]) }}"><i
                                                        class="icon-pencil"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-muted">No merchants assigned to this brand.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection
