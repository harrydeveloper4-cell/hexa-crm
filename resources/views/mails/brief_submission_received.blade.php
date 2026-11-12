<!doctype html>
<html>
<body style="margin:0;background:#f3f5fa;color:#20243a;font-family:Arial,sans-serif;">
    <div style="max-width:640px;margin:30px auto;background:#fff;border-radius:8px;padding:32px;">
        <h2 style="margin-top:0;color:#20243a;">Brief form submitted</h2>
        <p>A client has submitted <strong>{{ $data['formRequest']->form_title }}</strong>.</p>
        <p>
            Client: {{ trim($data['client']->firstname . ' ' . $data['client']->lastname) }}<br>
            Email: {{ $data['client']->email }}<br>
            Order: #{{ $data['order']->order_number ?: $data['order']->id }}<br>
            Brand: {{ $data['brand']->name ?? '--' }}
        </p>
        <p>The completed form PDF is attached to this email.</p>
    </div>
</body>
</html>
