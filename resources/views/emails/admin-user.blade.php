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
            white-space: pre-wrap;
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
        <h1>{{ config('app.name', 'OasisX') }}</h1>
    </div>
    <div class="content">{!! nl2br(e($mailBody)) !!}</div>
    <div class="footer">
        <p>This email was sent from {{ config('app.name') }}. Please do not reply directly to this email.</p>
    </div>
</body>

</html>