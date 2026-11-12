<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Client Briefs')</title>
    <link rel="stylesheet" href="{{ asset('admin/dist/vendors/bootstrap/css/bootstrap.min.css') }}">
    <style>
        :root { --brief-purple: #7057e8; --brief-ink: #20243a; --brief-muted: #687087; }
        body { background: #f3f5fa; color: var(--brief-ink); font-family: Arial, sans-serif; }
        .brief-top { height: 58px; background: #fff; border-bottom: 1px solid #e9ebf1; }
        .brief-wrap { max-width: 790px; margin: 30px auto 70px; padding: 0 16px; }
        .brief-heading { margin: 26px 0 20px; }
        .brief-heading h1 { font-family: Georgia, serif; font-size: 30px; font-weight: 700; }
        .brief-heading p, .brief-help { color: var(--brief-muted); }
        .brief-card { background: #fff; border: 1px solid #e7eaf1; border-radius: 8px; padding: 22px; margin: 15px 0; box-shadow: 0 3px 12px rgba(31,42,68,.04); }
        .brief-card h2 { font-size: 17px; font-weight: 700; margin: 0 0 18px; }
        .brief-label { font-size: 13px; font-weight: 600; margin-bottom: 8px; }
        .brief-label .required { color: #d54848; }
        .brief-input { border-color: #e3e7ef; background: #fbfcfe; min-height: 42px; }
        textarea.brief-input { min-height: 110px; }
        .brief-option { display: inline-flex; align-items: center; margin: 4px 12px 4px 0; padding: 7px 10px; background: #fafbfe; border: 1px solid #e6e9f0; border-radius: 5px; }
        .brief-option input { margin-right: 7px; }
        .brief-btn { background: var(--brief-purple); border-color: var(--brief-purple); color: #fff; }
        .brief-btn:hover { background: #5b44d0; border-color: #5b44d0; color: #fff; }
        .brief-brand { max-width: 185px; max-height: 48px; object-fit: contain; }
        .brief-footer { position: sticky; bottom: 0; padding: 12px 16px; background: rgba(255,255,255,.97); border-top: 1px solid #e5e8ef; text-align: center; }
        @media (max-width: 600px) { .brief-wrap { margin-top: 15px; } .brief-heading h1 { font-size: 25px; } .brief-card { padding: 17px; } }
    </style>
    @yield('head')
</head>
<body>
    <header class="brief-top">
        <div class="brief-wrap" style="margin:0 auto;height:58px;display:flex;align-items:center;justify-content:space-between;">
            <a href="{{ route('client.brief.dashboard') }}" class="font-weight-bold text-dark">Client Briefs</a>
            @yield('top-action')
        </div>
    </header>
    @yield('content')
</body>
</html>
