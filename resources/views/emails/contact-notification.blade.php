<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #2C3E66;">New Contact Message</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Type:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ ucfirst($submission->contact_type) }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">From:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $submission->name }} ({{ $submission->email }})</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Subject:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $submission->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Date:</td>
                <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $submission->created_at->format('F j, Y g:i A') }}</td>
            </tr>
        </table>

        <h3 style="margin-top: 20px;">Message:</h3>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
            {{ nl2br(e($submission->message)) }}
        </div>

        <p style="margin-top: 20px; font-size: 12px; color: #666;">
            This message was sent via the Dual-Identity Portfolio contact form.
        </p>
    </div>
</body>
</html>
