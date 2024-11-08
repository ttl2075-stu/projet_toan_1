<?php
include "../db_connect.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $id_phong = $_POST['id_phong'];
    $score = $_POST['score'];
    $sql = "SELECT * FROM `nguoi_choi_tung_phong` WHERE `id_user`=$id_user AND `id_phong` = '$id_phong'";
    $kq = mysqli_query($conn, $sql);
    $diem_cu = mysqli_fetch_array($kq);
    $diem_cu_v2 = $diem_cu['tong_diem_thuong'];
    $diem_moi = $score + $diem_cu_v2;
    $sql = "UPDATE nguoi_choi_tung_phong SET tong_diem_thuong='$diem_moi' WHERE id_user ='$id_user'";
    mysqli_query($conn, $sql);
}
