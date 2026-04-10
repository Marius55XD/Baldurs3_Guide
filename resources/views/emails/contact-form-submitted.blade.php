<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #1f2937;">
    <h2 style="margin-bottom: 12px;">New Contact Form Submission</h2>

    <p><strong>Name:</strong> {{ $payload['name'] }}</p>
    <p><strong>Email:</strong> {{ $payload['email'] }}</p>
    <p><strong>Subject:</strong> {{ $payload['subject'] }}</p>
    <p><strong>Submitted At:</strong> {{ $payload['submitted_at'] }}</p>
    <p><strong>IP Address:</strong> {{ $payload['ip'] }}</p>
    <p><strong>User Agent:</strong> {{ $payload['user_agent'] }}</p>

    <hr style="margin: 16px 0;">

    <p><strong>Message:</strong></p>
    <p style="white-space: pre-wrap;">{{ $payload['message'] }}</p>
</body>
</html>
