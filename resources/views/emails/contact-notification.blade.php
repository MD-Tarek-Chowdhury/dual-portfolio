{{-- resources/views/emails/contact-notification.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Submission</title>
    <style>
        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #334155;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #6495ED 0%, #4A7AC0 100%);
            padding: 30px;
            text-align: center;
        }
        .header.music {
            background: linear-gradient(135deg, #722F37 0%, #5a252c 100%);
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            color: rgba(255,255,255,0.9);
            margin: 8px 0 0;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 15px;
            color: #1e293b;
        }
        .message-box {
            background: #f8fafc;
            border-left: 4px solid #6495ED;
            border-radius: 0 8px 8px 0;
            padding: 16px;
            margin-top: 8px;
        }
        .message-box.music {
            border-left-color: #722F37;
        }
        .message-box p {
            margin: 0;
            white-space: pre-wrap;
            font-size: 14px;
            color: #475569;
        }
        .footer {
            padding: 20px 30px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .footer p {
            margin: 0;
            font-size: 12px;
            color: #94a3b8;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-academic {
            background: #dbeafe;
            color: #1e40af;
        }
        .badge-music {
            background: #fee2e2;
            color: #991b1b;
        }
        .button {
            display: inline-block;
            padding: 10px 24px;
            background: #334155;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            {{-- Header --}}
            <div class="header {{ $submission->contact_type === 'music' ? 'music' : '' }}">
                <h1>New Contact Submission</h1>
                <p>Someone reached out via your {{ ucfirst($submission->contact_type) }} portfolio</p>
            </div>

            {{-- Content --}}
            <div class="content">
                {{-- Type Badge --}}
                <div style="margin-bottom: 24px;">
                    <span class="badge badge-{{ $submission->contact_type }}">
                        {{ ucfirst($submission->contact_type) }} Inquiry
                    </span>
                </div>

                {{-- Sender Info --}}
                <div class="field">
                    <div class="field-label">From</div>
                    <div class="field-value" style="font-weight: 600;">{{ $submission->name }}</div>
                    <div class="field-value">
                        <a href="mailto:{{ $submission->email }}" style="color: #6495ED; text-decoration: none;">{{ $submission->email }}</a>
                    </div>
                </div>

                {{-- Subject --}}
                <div class="field">
                    <div class="field-label">Subject</div>
                    <div class="field-value" style="font-size: 16px; font-weight: 600;">{{ $submission->subject }}</div>
                </div>

                {{-- Message --}}
                <div class="field">
                    <div class="field-label">Message</div>
                    <div class="message-box {{ $submission->contact_type === 'music' ? 'music' : '' }}">
                        <p>{{ $submission->message }}</p>
                    </div>
                </div>

                {{-- Timestamp --}}
                <div class="field" style="margin-top: 24px;">
                    <div class="field-label">Received</div>
                    <div class="field-value" style="font-size: 13px; color: #64748b;">
                        {{ $submission->created_at->format('F j, Y \a\t g:i A') }} ({{ $submission->created_at->timezone }})
                    </div>
                </div>

                @if($submission->ip_address)
                <div class="field">
                    <div class="field-label">IP Address</div>
                    <div class="field-value" style="font-size: 13px; color: #64748b; font-family: monospace;">
                        {{ $submission->ip_address }}
                    </div>
                </div>
                @endif

                {{-- Admin Link --}}
                <div style="text-align: center; margin-top: 24px;">
                    <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="button">
                        View in Admin Panel
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="footer">
                <p>
                    This is an automated notification from {{ config('app.name') }}.<br>
                    You received this because you are the configured contact for {{ ucfirst($submission->contact_type) }} inquiries.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
