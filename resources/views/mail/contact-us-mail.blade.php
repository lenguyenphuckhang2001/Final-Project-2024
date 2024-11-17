<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #4c8baf;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }

        .email-body {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }

        .email-footer {
            background-color: #f4f4f4;
            color: #777777;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }

        a {
            color: #4caf50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>User Send Email Message</h1>
        </div>
        <div class="email-body">
            <p>From user: {{ $nameSend }},</p>
            <p>Here is the message user sent:</p>
            <div style="border-left: 4px solid #4c8baf; padding-left: 10px; margin: 20px 0; color: #555555;">
                {!! $messageEmail !!}
            </div>
        </div>
    </div>
</body>

</html>
