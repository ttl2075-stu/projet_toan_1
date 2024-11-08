<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../dang_nhap/style.css">
    <title>Đăng ký tài khoản</title>

</head>
<body>
    <div class="register-container">
        <h2>Đăng ký tài khoản</h2>
        <form action="" method="POST">
            <!-- <label for="username">Tên đăng nhập:</label> -->
            <input type="text" id="username" name="username" placeholder="Tên đăng nhập" required><br>

            <!-- <label for="password">Mật khẩu:</label> -->
            <input type="password" id="password" name="password" placeholder="Mật khẩu" required><br>

            <input type="submit" value="Đăng ký">
            <a class="a-login text-decoration-none text-center text-nounderline text-primary" href="../dang_nhap/">Quay về trang đăng nhập</a>
        </form>

        <div class="message">
            <?php
            // Import file kết nối CSDL
            require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng

            // Kiểm tra nếu dữ liệu được gửi qua phương thức POST
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Nhận dữ liệu từ form đăng ký
                $username = $_POST['username'];
                $password = $_POST['password'];
                $sql = "SELECT * FROM `users` WHERE `username`='$username'";
                $kq = mysqli_query($conn, $sql);
                if (mysqli_num_rows($kq) > 0) {
                    echo "Tài khoản đã có, vui lòng đăng ký tài khoản khác";
                } else {
                    $sql = "INSERT INTO `users`(`username`, `password`) VALUES ('$username','$password')";
                    if (mysqli_query($conn, $sql)) {
                        echo "Đăng ký tài khoản thành công";
                    } else {
                        echo "Đăng ký tài khoản thất bại";
                    }
                }
                mysqli_close($conn);
            }
            ?>
        </div>
    </div>
</body>

</html>