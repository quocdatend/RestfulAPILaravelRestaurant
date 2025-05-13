<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .card h2 {
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form class="card" method="POST" action="{{ route('password.update') }}">
        <h2>Đặt lại mật khẩu</h2>
    
        {{-- Token ẩn (quan trọng) --}}
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="password">Mật khẩu mới</label>
        <input id="password" type="password" name="password" required autofocus>
        {{-- @error('password')
            <div class="error">{{ $message }}</div>
        @enderror --}}

        <label for="password_confirmation">Xác nhận mật khẩu</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit">Đặt lại mật khẩu</button>
    </form>
</body>
</html>
