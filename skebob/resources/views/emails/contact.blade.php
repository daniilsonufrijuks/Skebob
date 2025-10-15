<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body>
<h1>Hello {{ $name }},</h1>

<p>Thank you for registering! Please confirm your email address by clicking the link below:</p>

<p>
    <a href="{{ url('/verify/' . $token) }}">
        Confirm Email
    </a>
</p>

<p>If you did not create this account, you can safely ignore this email.</p>

<p>Best regards,</p>
<p>The Skebob Team</p>
</body>
</html>
