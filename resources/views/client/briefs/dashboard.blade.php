@extends('client.briefs.layout')
@section('title', 'My Project Briefs')

@section('top-action')
    <span class="text-muted">{{ trim($client->firstname . ' ' . $client->lastname) }}</span>
@endsection

@section('content')
    <main class="brief-wrap">
        <div class="brief-heading">
            <span class="text-uppercase" style="font-size:11px;letter-spacing:1px;color:var(--brief-purple);font-weight:700;">Client Portal</span>
            <h1>Your project briefs</h1>
            <p>Open a requested form to share your project details. You can return here to check its status.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @forelse ($requests as $formRequest)
            <section class="brief-card">
                <div class="d-flex flex-wrap justify-content-between align-items-start">
                    <div>
                        <h2 class="mb-2">{{ $formRequest->form_title }}</h2>
                        <div class="brief-help">
                            Order #{{ $formRequest->order->order_number ?: $formRequest->order_id }}
                            @if ($formRequest->order->brand_details)
                                · {{ $formRequest->order->brand_details->name }}
                            @endif
                        </div>
                        <small class="brief-help">Sent {{ optional($formRequest->sent_at)->format('M d, Y') }}</small>
                    </div>
                    @if ($formRequest->status === 'submitted')
                        <span class="badge badge-success p-2">Submitted {{ optional($formRequest->submitted_at)->format('M d, Y') }}</span>
                    @elseif ($formRequest->expires_at && $formRequest->expires_at->isPast())
                        <span class="badge badge-secondary p-2">Expired</span>
                    @else
                        <a class="btn brief-btn" href="{{ route('client.brief.show', $formRequest->id) }}">Open form</a>
                    @endif
                </div>
            </section>
        @empty
            <section class="brief-card text-center">
                <h2>No brief forms yet</h2>
                <p class="brief-help mb-0">When your project team requests information, the secure form will appear here and arrive by email.</p>
            </section>
        @endforelse
    </main>
@endsection
