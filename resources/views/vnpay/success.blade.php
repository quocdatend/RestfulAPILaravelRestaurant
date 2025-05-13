<!DOCTYPE html>
<html>
<head>
    <title>Kết quả thanh toán</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f5f5f5;
            padding: 40px;
        }

        .card {
            max-width: 500px;
            margin: auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .status-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .status-success {
            color: #4CAF50;
        }

        .status-fail {
            color: #f44336;
        }

        .info {
            text-align: left;
            margin-top: 20px;
        }

        .info p {
            margin: 6px 0;
            font-size: 15px;
        }
    </style>
</head>
<body>


<div class="card">
    <div class="status-icon status-success">✅</div>
    <h2>Thanh toán thành công!</h2>

    <div class="info">
        <p><strong>Mã đơn hàng:</strong> {{ $data['vnp_TxnRef'] }}</p>
        <p><strong>Số tiền:</strong> {{ number_format($data['vnp_Amount'] / 100, 0, ',', '.') }} VND</p>
        <p><strong>Ngân hàng:</strong> {{ $data['vnp_BankCode'] }}</p>
        <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::createFromFormat('YmdHis', $data['vnp_PayDate'])->format('d/m/Y H:i:s') }}</p>
    </div>
</div>

</body>
</html>
