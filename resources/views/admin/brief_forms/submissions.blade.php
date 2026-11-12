@extends('admin.layout.master')
@section('title', 'Brief Submissions')

@section('breadcrumb-title')
    <h3>{{ __('Brief Submissions') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.assigned_clients') }}">Support</a></li>
    <li class="breadcrumb-item active">Brief Submissions</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Submitted</th>
                                    <th>Form</th>
                                    <th>Client</th>
                                    <th>Order / Brand</th>
                                    <th>Project Manager</th>
                                    <th>PDF</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($submissions as $formRequest)
                                    <tr>
                                        <td>{{ optional($formRequest->submitted_at)->format('M d, Y H:i') }}</td>
                                        <td>{{ $formRequest->form_title }}</td>
                                        <td>{{ trim(($formRequest->client->firstname ?? '') . ' ' . ($formRequest->client->lastname ?? '')) }}<br>
                                            <small>{{ $formRequest->client->email ?? '' }}</small></td>
                                        <td>#{{ $formRequest->order->order_number ?: $formRequest->order_id }}<br>
                                            <small>{{ $formRequest->order->brand_details->name ?? '--' }}</small></td>
                                        <td>{{ trim(($formRequest->supportPerson->firstname ?? '') . ' ' . ($formRequest->supportPerson->lastname ?? '')) }}</td>
                                        <td>
                                            @if ($formRequest->submission && $formRequest->submission->pdf_path)
                                                <a href="{{ route('admin.brief_forms.pdf', $formRequest->submission->id) }}">Download PDF</a>
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td><a href="{{ route('admin.brief_forms.submission', $formRequest->submission->id) }}">View</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center">No brief submissions yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
