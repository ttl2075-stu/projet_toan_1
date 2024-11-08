<?php
// Thông tin kết nối CSDL
$servername = "nvme.h2cloud.vn"; // Đổi thành tên server của bạn nếu khác
$username = "longitco_game"; // Tên người dùng CSDL
$password = "Long@2005"; // Mật khẩu của CSDL
$dbname = "longitco_thi_dau_v3"; // Tên CSDL của bạn

// Kết nối tới MySQL sử dụng kiểu thủ tục
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
} else {
    // In ra thông báo khi kết nối thành công (chỉ để kiểm tra)
    // Bạn có thể bỏ qua nếu không cần
    // echo "Kết nối thành công!";
}
