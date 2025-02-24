<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کد تایید ایمیل</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .code {
            display: inline-block;
            background-color: #FF5722;
            color: white;
            padding: 20px 30px;
            font-size: 32px;
            font-weight: bold;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cta-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #45a049;
        }

        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 30px;
            text-align: center;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .code {
                font-size: 28px;
                padding: 15px 25px;
            }

            .cta-button {
                padding: 10px 25px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>کد تایید ایمیل شما</h1>
        <p>سلام {{$fullName}} کد تایید شما برای فعال‌سازی حساب کاربریتان به شرح زیر است</p>
        <div class="code">{{ $emailCode }}</div>
        <div class="footer">
            <p>با تشکر از شما</p>
        </div>
    </div>

</body>
</html>
