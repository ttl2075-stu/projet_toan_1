<?php
// session_start();
require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng
require_once '../ham.php'; // Đảm bảo đường dẫn đúng
if (check_login() == 1) {
    header("location: ../dang_nhap");
    // echo "chưa đăng nhập";
}
$id_phong = $_GET['id_phong'];
$sql1 = "DELETE FROM `phong` WHERE `id_phong` = '$id_phong'";
$sql2 = "DELETE FROM `bai_tap` WHERE `id_phong`='$id_phong'";
if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {

    header("location: ../trang_chu");
}
