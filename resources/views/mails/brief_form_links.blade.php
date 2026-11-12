<!doctype html>
<html>
<body style="margin:0;background:#f3f5fa;color:#20243a;font-family:Arial,sans-serif;">
    <div style="max-width:640px;margin:30px auto;background:#fff;border-radius:8px;padding:32px;">
        <h2 style="margin-top:0;color:#20243a;">Your project brief forms</h2>
        <p>Hello {{ $data['client_name'] ?: 'there' }},</p>
        <p>Please use the secure links below to complete the requested project information. Each link opens directly into your brief form.</p>
        @foreach ($data['forms'] as $form)
            <div style="margin:20px 0;padding:18px;border:1px solid #e4e7ef;border-radius:6px;">
                <strong>{{ $form['title'] }}</strong><br>
                <a href="{{ $form['url'] }}" style="display:inline-block;margin-top:12px;padding:10px 16px;background:#6658dd;color:#fff;text-decoration:none;border-radius:4px;">Open form</a>
                <div style="margin-top:8px;color:#777;font-size:12px;">This secure link expires {{ $form['expires_at']->format('M d, Y') }}.</div>
            </div>
        @endforeach
        <p style="color:#6b7085;font-size:13px;">After opening a link, you can return to your client dashboard to see all forms and their submission status.</p>
    </div>
</body>
</html>
