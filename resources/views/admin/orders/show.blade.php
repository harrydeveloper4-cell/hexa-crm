@extends('admin.layout.master')
@section('title', 'Orders')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3> Order# {{ $order->order_number }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><i class="icon-home mr-1"></i></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active"> Order# {{ $order->order_number }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-6 mt-3">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header  justify-content-between align-items-center">
                            <h4 class="card-title">Details</h4>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0 redial-line-height-2_5">
                                <dt class="col-sm-5">Order Number:</dt>
                                <dd class="col-sm-7">#{{ $order->order_number }}</dd>

                                <dt class="col-sm-5">Placed On:</dt>
                                <dd class="col-sm-7">{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</dd>

                                <dt class="col-sm-5">Brand Name:`   
                                <dd class="col-sm-7">{{ $order->brand_details->name }}</dd>

                                <dt class="col-sm-5">Sales Person</dt>
                                <dd class="col-sm-7">{{ $order->sales_email }}</dd>

                                <dt class="col-sm-5">Customer</dt>
                                <dd class="col-sm-7">{{ $order->customer_email }}</dd>

                                <dt class="col-sm-5">Sales Amount:</dt>
                                <dd class="col-sm-7">{{ $order->sale_amount . ' ' . $order->sale_currency }}</dd>

                                <dt class="col-sm-5">Paid Amount:</dt>
                                <dd class="col-sm-7">
                                    {{ $order->order_payment_transactions()->sum('paid_amount') . ' ' . $order->sale_currency }}</dd>

                                <dt class="col-sm-5">Order Status:</dt>
                                <dd class="col-sm-7">
                                    @if ($order->status == 'pending')
                                        <span class = "badge badge-warning">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span class = "badge badge-info">Processing</span>
                                    @elseif($order->status == 'completed')
                                        <span class = "badge badge-primary">Completed</span>
                                    @elseif($order->status == 'discarded')
                                        <span class = "badge badge-secondary">Discarded</span>
                                    @elseif($order->status == 'refunded')
                                        <span class = "badge badge-primary">Refunded</span>
                                    @endif
                                </dd>

                                <dt class="col-sm-5">Payment Link:</dt>
                                <dd class="col-sm-7">
                                    @if (isset($order->payment_status) && $order->payment_status == 'unpaid')
                                        @if (isset($order->payment_link) && $order->payment_link != null)
                                            @if (\Carbon\Carbon::parse($order->expires_at)->toDateString() < now()->toDateString())
                                                <span href="javascript:void(0)" class="badge badge-danger"
                                                    style="color: #fff;">
                                                    Link Expired
                                                </span>
                                            @else
                                                @php
                                                    $now = \Carbon\Carbon::now();
                                                    $expiresAt = \Carbon\Carbon::parse($order->expires_at);
                                                    $diffInMinutes = $expiresAt->diffInMinutes($now);
                                                    $hours = intdiv($diffInMinutes, 60);
                                                    $minutes = $diffInMinutes % 60;
                                                @endphp
                                                <a href="javascript:void(0)"
                                                    class="copyLink me-2 badge badge-warning" data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Expires in {{ $hours }} hour(s) and {{ $minutes }} minute(s)"
                                                    style="color: #fff;" data-platform_name="link copy"
                                                    data-payment_link="{{ $order->payment_link }}">
                                                    Copy link <i class="icon-docs"></i>
                                                </a>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">Payment link unavailable</span>
                                        @endif
                                    @else
                                        <span class="badge badge-success">Paid</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                @php
                    $billing = $order->order_payment_transactions()->latest()->first();
                @endphp
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header  justify-content-between align-items-center">
                            <h4 class="card-title">Billing Address</h4>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0 redial-line-height-2_5">
                                <dt class="col-sm-5">First Name:</dt>
                                <dd class="col-sm-7">{{ $billing->firstname ?? '-' }}</dd>
        
                                <dt class="col-sm-5">Last Name:</dt>
                                <dd class="col-sm-7">{{ $billing->lastname ?? '-' }}</dd>
        
                                <dt class="col-sm-5">Email:</dt>
                                <dd class="col-sm-7">{{ $billing->email ?? '-' }}</dd>
        
                                <dt class="col-sm-5">Address:</dt>
                                <dd class="col-sm-7">{{ $billing->billing_address ?? '-' }}</dd>
        
                                <dt class="col-sm-5">City:</dt>
                                <dd class="col-sm-7">{{ $billing->city ?? '-' }}</dd>
        
                                <dt class="col-sm-5">State</dt>
                                <dd class="col-sm-7">{{ $billing->state ?? '-' }}</dd>
        
                                <dt class="col-sm-5">ZIP/Post Code</dt>
                                <dd class="col-sm-7">{{ $billing->postalcode ?? '-' }}</dd>
        
                                <dt class="col-sm-5">Country:</dt>
                                <dd class="col-sm-7">{{ $billing->getCountry->name ?? '-' }}</dd>
        
                                <dt class="col-sm-5">Phone Number:</dt>
                                <dd class="col-sm-7">{{ $billing->billing_phonenumber ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
        
        
                </div>
            </div>
        </div>
        <div class="col-6 mt-3">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header  justify-content-between align-items-center">
                            <h4 class="card-title">Order Packages</h4>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0 redial-line-height-2_5">
                                <dt class="col-sm-5">Package ID </dt>
                                <dt class="col-sm-7">Package Name</dt>
                                @foreach ($order->packages as $package)
                                    <dd class="col-sm-5">{{ $package->id }} </dd>
                                    <dd class="col-sm-7">{{ $package->package_name }}</dd>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header  justify-content-between align-items-center">
                            <h4 class="card-title">Payment Details</h4>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0 redial-line-height-2_5">
        
                                <dt class="col-sm-5">Payment Method:</dt>
                                <dd class="col-sm-7">{{ $order->payment_gateway }}</dd>
        
                                <dt class="col-sm-5">Payment Transaction ID:</dt>
                                <dd class="col-sm-7">
                                    {{ !is_null($order->order_payment_transactions->first()) ? $order->order_payment_transactions->first()->payment_id : '-' }}
                                </dd>
        
                                <dt class="col-sm-5">Payer ID:</dt>
                                <dd class="col-sm-7">
                                    {{ !is_null($order->order_payment_transactions->first()) ? $order->order_payment_transactions->first()->payer_id : '-' }}
                                </dd>
        
                                <dt class="col-sm-5">Transaction Date:</dt>
                                <dd class="col-sm-7">
                                    {{ !is_null($order->order_payment_transactions->first()) ? date('d/m/Y H:i', strtotime($order->order_payment_transactions->first()->created_at)) : '-' }}
                                </dd>
        
                                @if (!is_null($order->order_payment_transactions->first()) && !is_null($order->card_details))
                                    <dd class="col-sm-12 text-center">
                                        <button class="btn btn-primary view-card" data-view="0">View Card Detail</button>
                                    </dd>
                                @endif
        
                                <dl class="row mb-0 ml-1 redial-line-height-2_5 hide-card">
        
        
                                    @if (!is_null($order->order_payment_transactions->first()) && !is_null($order->card_details))
                                        <dt class="col-sm-5">Merchant:</dt>
                                        <dd class="col-sm-7">
                                            {{ isset($order->card_details->merchant) ? ucwords($order->card_details->merchant) : 'Not Define' }}
                                        </dd>
        
                                        <dt class="col-sm-5">Name on Card:</dt>
                                        <dd class="col-sm-7">{{ $order->card_details->owner }}</dd>
        
                                        <dt class="col-sm-5">Card Number:</dt>
                                        <dd class="col-sm-7">{{ $order->card_details->cardNumber }}</dd>
        
                                        <dt class="col-sm-5">CVV Number:</dt>
                                        <dd class="col-sm-7">{{ $order->card_details->cvv }}</dd>
        
                                        <dt class="col-sm-5">Expiry MM / YY:</dt>
                                        <dd class="col-sm-7">{{ $order->card_details->expiration_month }} /
                                            {{ $order->card_details->expiration_year }}</dd>
                                    @endif
                                </dl>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header  justify-content-between align-items-center">
                            <h4 class="card-title">Documents</h4>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0 redial-line-height-2_5">
                                <dt class="col-sm-5">PDF </dt>
                                @if (isset($order->pdf_agreement))
                                    <a class="btn btn-success" href = "{{ asset($order->pdf_agreement) }}" download="">Download</a>
                                @else
                                    <dd class="col-sm-7">{{ $billing->city ?? '-' }}</dd>
                                @endif
                            </dl>
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
            $(".hide-card").hide()
        })

        $(".view-card").click(function() {
            if ($(this).data("view") == "0") {
                $(this).text("Hide Card Detail")
                $(this).data("view", "1")
                $(".hide-card").show()
            } else {
                $(this).text("View Card Detail")
                $(this).data("view", "0")
                $(".hide-card").hide()
            }
        })
        
        $(document).on('click', '.copyLink', function() {
            navigator.clipboard.writeText($(this).data('payment_link')).then(() => {
                toastr.success('Copied to clipboard!');
            }).catch(() => {
                toastr.error('Failed to copy to clipboard');
            });
        });
    </script>
@endsection
