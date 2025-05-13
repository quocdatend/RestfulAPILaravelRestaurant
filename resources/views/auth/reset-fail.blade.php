<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Thất bại</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fef2f2;
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
            color: #ef4444;
        }

        h2 {
            margin-top: 15px;
            color: #ef4444;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #fff;
            background: #ef4444;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }

        a:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">❌</div>
        <h2>Đặt lại mật khẩu thất bại!</h2>
        <p>{{ $message ?? 'Token không hợp lệ hoặc đã hết hạn.' }}</p>
        <a href="{{ route('login') }}">Thử lại</a>
    </div>
</body>
</html>
