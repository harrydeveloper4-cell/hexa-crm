@extends('admin.layout.master')
@section('title', 'Merchants')

@section('breadcrumb-title')
    <h3>{{ __('Merchant Edit') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}">{{ __('Merchants') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection

@section('content')
    @php
        $keys = old() ? old('config_key', []) : array_keys($merchant->config_keys ?? []);
        $values = old() ? old('config_value', []) : array_values($merchant->config_keys ?? []);
    @endphp
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
                                <form action="{{ route('merchant.update', ['id' => $merchant->id]) }}" method="POST"
                                    id="merchant-form">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="merchant">Merchant Name</label>
                                            <input type="text" class="form-control rounded" name="merchant"
                                                id="merchant" placeholder="Merchant Name"
                                                value="{{ old('merchant', $merchant->merchant) }}">
                                            @error('merchant')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="status">Status</label><br>
                                            <input type="checkbox" name="status" value="1" data-toggle="toggle"
                                                data-on="Active" data-off="Inactive"
                                                {{ (old() ? old('status') : ($merchant->status == 'active' ? '1' : null)) ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Config Keys</label>
                                        </div>
                                    </div>

                                    <div id="append-row">
                                        @forelse ($keys as $index => $key)
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <input type="text" class="form-control rounded" name="config_key[]"
                                                        placeholder="Key" value="{{ $key }}">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <input type="text" class="form-control rounded"
                                                        name="config_value[]" placeholder="Value"
                                                        value="{{ $values[$index] ?? '' }}">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                            class="icon-minus"></i></button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <input type="text" class="form-control rounded" name="config_key[]"
                                                        placeholder="Key">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <input type="text" class="form-control rounded"
                                                        name="config_value[]" placeholder="Value">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                            class="icon-minus"></i></button>
                                                </div>
                                            </div>
                                        @endforelse
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
