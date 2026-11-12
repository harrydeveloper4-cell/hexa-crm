@extends('client.briefs.layout')
@section('title', 'Brief Link Unavailable')

@section('content')
    <main class="brief-wrap">
        <section class="brief-card text-center">
            <h1 class="mb-3">This brief link is no longer available</h1>
            <p class="brief-help">It may have expired or already been submitted. Please contact your project support person if you need a new link.</p>
            @if (auth()->guard('user')->check() && (int) auth()->guard('user')->user()->role_id === (int) client_role_id())
                <a href="{{ route('client.brief.dashboard') }}" class="btn brief-btn">Go to my briefs</a>
            @endif
        </section>
    </main>
@endsection
