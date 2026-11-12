@extends('admin.layout.master')
@section('title', 'Merchants')

@section('breadcrumb-title')
    <h3>{{ __('Merchant Create') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}">{{ __('Merchants') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <a class="btn btn-info float-right" href="{{ route('merchant.index') }}">Back</a>
        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('merchant.store') }}" method="POST" id="merchant-form">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="merchant">Merchant Name</label>
                                            <input type="text" class="form-control rounded" name="merchant"
                                                id="merchant" placeholder="Merchant Name" value="{{ old('merchant') }}">
                                            @error('merchant')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="status">Status</label><br>
                                            <input type="checkbox" name="status" value="1" data-toggle="toggle"
                                                data-on="Active" data-off="Inactive"
                                                {{ (old() ? old('status') : '1') ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Config Keys</label>
                                            <small class="text-muted d-block">Example key: <code>client_id</code>,
                                                <code>secret_key</code></small>
                                        </div>
                                    </div>

                                    <div id="append-row">
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <input type="text" class="form-control rounded" name="config_key[]"
                                                    placeholder="Key">
                                            </div>
                                            <div class="form-group col-md-5">
                                                <input type="text" class="form-control rounded" name="config_value[]"
                                                    placeholder="Value">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                        class="icon-minus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-sm btn-primary add-row"><i
                                                    class="icon-plus"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <input type="submit" value="Save" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
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
            $('#merchant-form').validate({
                rules: {
                    merchant: 'required'
                }
            });

            $(document).on('click', '.add-row', function() {
                var html = '<div class="form-row">' +
                    '<div class="form-group col-md-5"><input type="text" class="form-control rounded" name="config_key[]" placeholder="Key"></div>' +
                    '<div class="form-group col-md-5"><input type="text" class="form-control rounded" name="config_value[]" placeholder="Value"></div>' +
                    '<div class="form-group col-md-2"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="icon-minus"></i></button></div>' +
                    '</div>';
                $('#append-row').append(html);
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.form-row').remove();
            });
        });
    </script>
@endsection
