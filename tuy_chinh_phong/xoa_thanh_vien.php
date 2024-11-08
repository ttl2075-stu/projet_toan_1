<?php
// session_start();
require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng
require_once '../ham.php'; // Đảm bảo đường dẫn đúng
if (check_login() == 1) {
    header("location: ../dang_nhap");
    // echo "chưa đăng nhập";
}
$id_phong = $_GET['id_phong'];
$id_user = $_GET['id_user'];
$sql1 = "DELETE FROM `nguoi_choi_tung_phong` WHERE `id_user`= '$id_user ' and `id_phong`='$id_phong'";

if (mysqli_query($conn, $sql1)) {

    header("location: ../tuy_chinh_phong/index.php?id_phong=$id_phong");
}
