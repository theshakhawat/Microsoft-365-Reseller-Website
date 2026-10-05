<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Microsoft Office Club'))</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: #0067b8;
            padding: 28px 32px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p {
            color: #e0f2fe;
            margin: 6px 0 0 0;
            font-size: 13px;
        }
        .content {
            padding: 32px;
            line-height: 1.6;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background-color: #0067b8;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 20px;
            text-align: center;
        }
        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .footer {
            background: #f8fafc;
            padding: 24px 32px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        .footer a {
            color: #0067b8;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ site_setting('site_name', config('app.name', 'Microsoft Office Club')) }}</h1>
            <p>{{ site_setting('site_tagline', 'Genuine Microsoft 365 Cloud Subscriptions & Support') }}</p>
        </div>

        <!-- Body Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 8px 0;">
                Need help? Reach us at <a href="mailto:{{ site_setting('contact_email', 'support@microsoftoffice.club') }}">{{ site_setting('contact_email', 'support@microsoftoffice.club') }}</a>
                @if(site_setting('contact_phone'))
                    | Phone: {{ site_setting('contact_phone') }}
                @endif
            </p>
            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                &copy; {{ date('Y') }} {{ site_setting('site_name', 'Microsoft Office Club') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
