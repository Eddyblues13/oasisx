<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
        }

        .content {
            margin-bottom: 30px;
        }

        .content h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .content p {
            margin-bottom: 12px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
    </div>
    <div class="content">
        <h2>Welcome, {{ $user->name }}!</h2>
        <p>Thank you for creating an account with {{ config('app.name') }}. We're excited to have you on board.</p>
        <p>With your new account, you can:</p>
        <ul>
            <li>Deposit and manage your wallet</li>
            <li>Invest in curated plans</li>
            <li>Copy trade from expert traders</li>
            <li>Use AI-powered trading bots</li>
            <li>Access crypto-backed loans</li>
        </ul>
        <p>Get started by visiting your dashboard:</p>
        <p><a href="{{ url('/dashboard') }}" class="btn">Go to Dashboard</a></p>
    </div>
    <div class="footer">
        <p>This email was sent from {{ config('app.name') }}. Please do not reply directly to this email.</p>
    </div>
</body>

</html>