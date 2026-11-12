<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 34px 42px; }
        body { color: #25283a; font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.5; }
        .brand-logo { max-height: 58px; max-width: 220px; margin-bottom: 14px; }
        h1 { font-size: 22px; margin: 0 0 4px; }
        .muted { color: #687087; }
        .meta { border-bottom: 1px solid #dfe3ec; padding-bottom: 14px; margin-bottom: 20px; }
        .question { margin: 0 0 13px; padding: 12px 14px; border: 1px solid #e5e8ef; border-radius: 5px; page-break-inside: avoid; }
        .label { color: #555d73; font-size: 9px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
        .answer { font-size: 12px; white-space: pre-wrap; overflow-wrap: break-word; }
        .empty { color: #9298a7; font-style: italic; }
    </style>
</head>
<body>
    @if ($logoDataUri)
        <img class="brand-logo" src="{{ $logoDataUri }}" alt="Brand logo">
    @endif
    <div class="meta">
        <div class="muted">{{ $brand->name ?? 'Project brief' }}</div>
        <h1>{{ $formRequest->form_title }}</h1>
        <div>Order #{{ $order->order_number ?: $order->id }}</div>
        <div>Client: {{ trim($client->firstname . ' ' . $client->lastname) }} ({{ $client->email }})</div>
        <div>Submitted: {{ now()->format('M d, Y H:i') }}</div>
    </div>

    @foreach ($fields as $field)
        @php
            $answer = $answers[$field['id']] ?? null;
            if (is_array($answer) && array_key_exists('file_name', $answer)) {
                $displayAnswer = 'Uploaded file: ' . $answer['file_name'];
            } elseif (is_array($answer)) {
                $displayAnswer = implode(', ', $answer);
            } else {
                $displayAnswer = $answer;
            }
        @endphp
        <div class="question">
            <div class="label">{{ $field['label'] }}</div>
            @if ($displayAnswer !== null && $displayAnswer !== '')
                <div class="answer">{{ $displayAnswer }}</div>
            @else
                <div class="answer empty">No answer provided</div>
            @endif
        </div>
    @endforeach
</body>
</html>
