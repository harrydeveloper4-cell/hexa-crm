@extends('admin.layout.master')
@section('title', 'Invoice (Payment Link)')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Invoice (Payment Link)') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item active">{{ __('Invoice (Payment Link)') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order ID</th>
                                    <th>Client Email</th>
                                    <th>Invoice Amount</th>
                                    <th>Payment Link</th>
                                    <th>Support Person</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($invoices))
                                    @foreach ($invoices as $key => $invoice)
                                        <tr>
                                            <td>{{ $invoice->id }}</td>
                                            <td>#{{ $invoice->order->order_number ?? '-' }}</td>
                                            <td>{{ $invoice->order->customer_email ?? '-' }}</td>
                                            <td>{{ $invoice->amount . ' ' . ($invoice->order->sale_currency ?? '') }}</td>
                                            <td>
                                                @if (isset($invoice->is_paid) && $invoice->is_paid == 'unpaid')
                                                    @if (isset($invoice->payment_link) && $invoice->payment_link != null)
                                                        @if (isset($invoice->order->expires_at) && $invoice->order->expires_at < now())
                                                            <span class="badge badge-danger" style="color: #fff;">Link
                                                                Expired</span>
                                                        @else
                                                            @php
                                                                $now = \Carbon\Carbon::now();
                                                                $expiresAt = \Carbon\Carbon::parse($invoice->order->expires_at);
                                                                $diffInMinutes = $expiresAt->diffInMinutes($now);
                                                                $hours = intdiv($diffInMinutes, 60);
                                                                $minutes = $diffInMinutes % 60;
                                                            @endphp
                                                            <a href="javascript:void(0)"
                                                                class="copyLink me-2 badge badge-warning" data-toggle="tooltip"
                                                                data-placement="top" title=""
                                                                data-original-title="Expires in {{ $hours }} hour(s) and {{ $minutes }} minute(s)"
                                                                style="color: #fff;" data-platform_name="link copy"
                                                                data-payment_link="{{ $invoice->payment_link }}">
                                                                Copy link <i class="icon-docs"></i>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-danger">Payment link unavailable</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-success">Paid</span>
                                                @endif
                                            </td>
                                            <td>{{ $invoice->order && $invoice->order->support_person ? (trim(($invoice->order->support_person->firstname ?? '') . ' ' . ($invoice->order->support_person->lastname ?? '')) ?: $invoice->order->support_person->email) : '--' }}</td>
                                            <td>
                                                @if (isset($invoice->order))
                                                    <a href="{{ route('admin.orders.show', ['id' => $invoice->order->id]) }}"><i
                                                            class="icon-eye"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            <tfoot>
                                <th>ID</th>
                                <th>Order ID</th>
                                <th>Client Email</th>
                                <th>Invoice Amount</th>
                                <th>Payment Link</th>
                                <th>Support Person</th>
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
        $(document).on('click', '.copyLink', function() {
            navigator.clipboard.writeText($(this).data('payment_link')).then(() => {
                toastr.success('Copied to clipboard!');
            }).catch(() => {
                toastr.error('Failed to copy to clipboard');
            });
        });
    </script>
@endsection
