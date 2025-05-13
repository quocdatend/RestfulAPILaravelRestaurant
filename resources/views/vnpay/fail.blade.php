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
    <div class="status-icon status-fail">❌</div>
    <h2>Thanh toán thất bại!</h2>

    <div class="info">
        <p><strong>Mã đơn hàng:</strong> {{ $data['vnp_TxnRef'] ?? 'Không rõ' }}</p>
        <p><strong>Lý do:</strong> Mã phản hồi: {{ $data['vnp_ResponseCode'] ?? 'Không rõ' }}</p>
        <p><strong>Trạng thái:</strong> {{ $data['vnp_TransactionStatus'] ?? 'Không rõ' }}</p>
    </div>
</div>

</body>
</html>
