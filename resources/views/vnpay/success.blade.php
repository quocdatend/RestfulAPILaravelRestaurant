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

        .link {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 20px;
            text-decoration: none;
            border: 1px solid #000;
            border-radius: 14px;
            color: #000;
            transition: background-color 0.3s;
        }

        .link:hover {
            background-color: #eee;
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

    <a href="http://localhost:5173/dashboard/orders" class="link">
        &laquo; Quay lại
    </a>
</div>

<script>
    $txnRef = $data['vnp_TxnRef'];
    $length = strlen($txnRef);
    $half = intdiv($length, 2);
    $part1 = substr($txnRef, 0, $half);
    $part2 = substr($txnRef, $half);

    fetch(`http://127.0.0.1:8000/api/order/confirmPayment/{{ $part1  }}/{{ $part2 }}`, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        console.log('Đã xác nhận thanh toán:', data);
    })
    .catch(error => {
        console.error('Lỗi khi xác nhận thanh toán:', error);
    });
</script>

</body>
</html>
