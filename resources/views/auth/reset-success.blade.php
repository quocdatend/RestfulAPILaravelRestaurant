<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Thành công</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0fdf4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .icon {
            font-size: 48px;
            color: #10b981;
        }

        h2 {
            margin-top: 15px;
            color: #10b981;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #fff;
            background: #10b981;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }

        a:hover {
            background: #059669;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✅</div>
        <h2>Mật khẩu của bạn đã được đặt lại thành công!</h2>
        <a href="{{ route('login') }}">Đăng nhập</a>
    </div>
</body>
</html>
