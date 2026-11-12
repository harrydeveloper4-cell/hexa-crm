@extends('admin.layout.master')
@section('title', 'Clients')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Clients') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item active">{{ __('Clients') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Orders</th>
                                    <th>Latest Order</th>
                                    <th>Amount</th>
                                    <th>Support Person</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($clients))
                                    @foreach ($clients as $key => $client)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->orders_count }}</td>
                                            <td>#{{ $client->latest_order_id }}</td>
                                            <td>{{ $client->amount . ' ' . $client->currency }}</td>
                                            <td>{{ $client->support_person }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#clientBriefModal{{ $key }}">Orders / Briefs</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            <tfoot>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Latest Order</th>
                                <th>Amount</th>
                                <th>Support Person</th>
                                <th>Action</th>
                            </tfoot>
                        </table>
                    </div>
                    @foreach ($clients as $key => $client)
                        <div class="modal fade" id="clientBriefModal{{ $key }}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $client->name }} - Orders & Brief Forms</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>All client orders</h6>
                                        <div class="table-responsive mb-4">
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Brand</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($client->orders as $clientOrder)
                                                        <tr>
                                                            <td>#{{ $clientOrder->order_number ?: $clientOrder->id }}</td>
                                                            <td>{{ $clientOrder->brand }}</td>
                                                            <td>{{ $clientOrder->amount . ' ' . $clientOrder->currency }}</td>
                                                            <td>{{ ucfirst($clientOrder->payment_status ?: 'pending') }}</td>
                                                            <td>{{ optional($clientOrder->created_at)->format('M d, Y') }}</td>
                                                            <td><a href="{{ route('admin.assigned_order.show', ['id' => $clientOrder->id]) }}"
                                                                    target="_blank">View</a></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        @if (auth_staff()->has_permission('send_brief_forms') && $briefForms->isNotEmpty() && !empty($client->id))
                                            <h6>Email brief forms</h6>
                                            <form method="POST"
                                                action="{{ route('admin.brief_forms.send', ['clientId' => $client->id]) }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Order / brand for the brief</label>
                                                    <select class="form-control" name="order_id" required>
                                                        @foreach ($client->orders as $clientOrder)
                                                            <option value="{{ $clientOrder->id }}">
                                                                #{{ $clientOrder->order_number ?: $clientOrder->id }}
                                                                - {{ $clientOrder->brand }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <small class="form-text text-muted">The selected order's brand logo will appear on the brief.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>Select one or more forms</label>
                                                    @foreach ($briefForms as $briefForm)
                                                        <div class="custom-control custom-checkbox mb-2">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="brief{{ $key }}_{{ $briefForm->id }}"
                                                                name="form_ids[]" value="{{ $briefForm->id }}">
                                                            <label class="custom-control-label"
                                                                for="brief{{ $key }}_{{ $briefForm->id }}">{{ $briefForm->title }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="submit" class="btn btn-primary">Email selected form links</button>
                                            </form>
                                        @elseif (auth_staff()->has_permission('send_brief_forms'))
                                            <div class="alert alert-info mb-0">Create and add fields to an active brief form before sending it.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
