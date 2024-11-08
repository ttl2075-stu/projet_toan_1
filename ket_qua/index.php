<?php
include "../ham.php";
unset($_SESSION['ds_id_bai_tap']);
$id_luyen_tap = $_GET['id_luyen_tap'];
// print_r($id_luyen_tap);
$diem = diem_luyen_tap($id_luyen_tap);
cap_nhat_thoi_gian_luyen_tap($id_luyen_tap);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả luyện tập</title>

    <!-- Link Bootstrap CSS từ CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tùy chỉnh CSS -->
    <style>
        body {
            background-color: #ffebcd;
            /* Màu nền nhẹ nhàng, dễ nhìn */
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .result-card {
            max-width: 600px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #ffcc00;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            background-color: #fff;
            padding: 30px;
            border-radius: 0 0 15px 15px;
        }

        .alert {
            font-size: 18px;
            padding: 15px;
            border-radius: 10px;
        }

        .alert-success {
            background-color: #c8e6c9;
            color: #388e3c;
            font-weight: bold;
        }

        .alert-danger {
            background-color: #ffcdd2;
            color: #d32f2f;
            font-weight: bold;
        }

        table {
            font-size: 18px;
            margin-top: 20px;
            width: 100%;
            border-radius: 10px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .btn {
            background-color: #ff4081;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 18px;
        }

        .btn:hover {
            background-color: #f50057;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="result-card card">
            <div class="card-header">
                Kết quả luyện tập
            </div>
            <div class="card-body">
                <!-- Alert hiển thị kết quả -->
                <div class="alert alert-success" role="alert">
                    <strong>Chúc mừng!</strong> Bạn đã hoàn thành bài luyện tập với điểm số là <strong><?php echo $diem; ?>/100</strong>.
                </div>



                <div class="footer">
                    <p>Hãy tiếp tục luyện tập nhé! Bạn đang làm rất tốt!</p>
                    <a href="../trang_chu/" class="btn">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS và Popper.js từ CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>