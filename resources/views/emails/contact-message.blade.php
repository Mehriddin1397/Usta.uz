<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aloqa xabari - Usta.uz</title>
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
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
        }
        .footer {
            background-color: #6c757d;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 14px;
        }
        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            background-color: white;
            border-radius: 3px;
            border-left: 4px solid #0d6efd;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔧 Usta.uz</h1>
        <p>Yangi aloqa xabari</p>
    </div>

    <div class="content">
        <h2>{{ $subjectName }}</h2>
        
        <div class="info-row">
            <span class="label">Ism:</span> {{ $contactData['name'] }}
        </div>

        <div class="info-row">
            <span class="label">Email:</span> {{ $contactData['email'] }}
        </div>

        @if($contactData['phone'])
        <div class="info-row">
            <span class="label">Telefon:</span> {{ $contactData['phone'] }}
        </div>
        @endif

        <div class="info-row">
            <span class="label">Mavzu:</span> {{ $subjectName }}
        </div>

        @if($contactData['user_id'])
        <div class="info-row">
            <span class="label">Foydalanuvchi ID:</span> {{ $contactData['user_id'] }}
        </div>
        @endif

        <div class="info-row">
            <span class="label">Sana:</span> {{ $contactData['created_at']->format('d.m.Y H:i') }}
        </div>

        <div class="message-box">
            <div class="label">Xabar:</div>
            <p>{{ $contactData['message'] }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Bu xabar Usta.uz platformasidan yuborilgan</p>
        <p>Javob berish uchun yuqoridagi email manzilga yozing</p>
    </div>
</body>
</html>
