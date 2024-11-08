<?php
require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <title>Đăng nhập</title>
    <!-- Thêm FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form action="" method="POST">
            <!-- <label for="username">Tên đăng nhập:</label> -->
            <input type="text" id="username" name="username" placeholder="Tên đăng nhập" required><br>

            <!-- <label for="password">Mật khẩu:</label> -->
            <input type="password" id="password" name="password" placeholder="Mật khẩu" required><br>

            <input type="submit" class="btn btn-primary btn-block" name="dang_nhap" value="Đăng nhập">
            <a class="a-register text-decoration-none text-center text-nounderline text-primary" href="../dang_ky/">Đăng ký nếu chưa có tài khoản</a>
        </form>

        <!-- Thông báo lỗi với biểu tượng FontAwesome -->
        <div class="error-message" id="errorMessage">
            <i class="fas fa-exclamation-circle error-icon"></i>
            Sai tài khoản hoặc mật khẩu
        </div>

        <div class="footer">
            <p>&copy; 2024 FIT-HNUE</p>
        </div>

        <?php
        if (isset($_POST['dang_nhap'])) {
            $tk = $_POST['username'];
            $mk = $_POST['password'];

            $sql = "SELECT * FROM `users` WHERE `username`='$tk' and `password`='$mk'";
            $kq = mysqli_query($conn, $sql);
            if (mysqli_num_rows($kq) > 0) {
                $row = mysqli_fetch_array($kq);

                $_SESSION['username'] = $tk;
                $_SESSION['role'] = $row['role'];
                $_SESSION['id_user'] = $row['id'];
                header("Location: ../trang_chu/");
            } else {
                echo "<script>document.getElementById('errorMessage').classList.add('active');</script>";
            }
        }
        ?>
    </div>

    <script>
        // Nếu cần xử lý thêm JS cho hiệu ứng lỗi, có thể thêm ở đây.
    </script>
</body>

</html>