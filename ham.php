<?php
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
$duong_dan = "http://localhost/NCKH/Game/v3/game/";
require_once 'db_connect.php'; // Đảm bảo đường dẫn đúng
function check_login()
{
    // Kiểm tra xem session 'user_id' có tồn tại hay không
    if (!isset($_SESSION['username'])) {
        return 1;
    }
    return 0;
}

function get_ten($id_user)
{
    global $conn;
    $sql = "SELECT * FROM `users` WHERE `id`='$id_user'";
    $kq = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($kq);
    return $row;
}

function get_bt_theo_chu_de($id_bai_hoc)
{
    global $conn;
    $ds = [];
    $sql = "SELECT * FROM `bt_theo_chu_de` WHERE `id_chu_de`='$id_bai_hoc'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {
        while ($row = mysqli_fetch_array($kq)) {
            $ds[] = $row['id_loai_bt'];
        }
        return $ds;
    } else {
        return 0;
    }
}

function generate2DArray($x, $y, $k)
{
    $a = [];

    for ($i = 0; $i < $k; $i++) {
        do {
            // Tạo hai số ngẫu nhiên
            $num1 = rand(1, $y - 1);
            $num2 = rand(1, $y - 1);
            $sum = $num1 + $num2;
        } while ($sum <= $x || $sum >= $y); // Kiểm tra tổng phải lớn hơn $x và nhỏ hơn $y

        // Thêm cặp số vào mảng 2 chiều
        $a[] = [$num1, $num2];
    }

    return $a;
}

function hieu($x, $y, $k)
{
    $a = [];

    for ($i = 0; $i < $k; $i++) {
        do {
            // Tạo hai số ngẫu nhiên
            $num1 = rand($x + 1, $y + $x); // Đảm bảo num1 lớn hơn num2
            $num2 = rand(1, $num1 - 1);    // num2 luôn nhỏ hơn num1
            $diff = $num1 - $num2;
        } while ($diff <= $x || $diff >= $y); // Kiểm tra hiệu phải lớn hơn $x và nhỏ hơn $y

        // Thêm cặp số vào mảng 2 chiều
        $a[] = [$num1, $num2];
    }

    return $a;
}
function tạo_mang_1_chieu($x, $y, $length)
{
    $array = [];

    for ($i = 0; $i < $length; $i++) {
        // Tạo số ngẫu nhiên trong khoảng từ $x đến $y và thêm vào mảng
        $array[] = rand($x, $y);
    }

    return $array;
}
function get_ten_bai_hoc($id_bai_hoc)
{
    global $conn;
    $sql = "SELECT * FROM `bai_hoc` WHERE `id_bai_hoc`='$id_bai_hoc'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {
        $row = mysqli_fetch_array($kq);
        return $row['ten_bai_hoc'];
    } else {
        return 0;
    }
}

function get_bt_theo_phong($id_phong)
{
    global $conn;
    $ds_id_bt = [];
    $sql = "SELECT * FROM `bai_tap` WHERE `id_phong`='$id_phong'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {

        while ($row = mysqli_fetch_array($kq)) {
            $ds_id_bt[] = $row['id_bai_tap'];
        }
        return $ds_id_bt;
    } else {
        return 0;
    }
}
function get_bt_theo_id_luyen_tap($id_luyen_tap)
{
    global $conn;
    $ds_bt = [];
    $sql = "SELECT * FROM `de_luyen_tap` WHERE `id_luyen_tap`='$id_luyen_tap'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {

        while ($row = mysqli_fetch_array($kq)) {
            $ds_bt[] = $row;
        }
        return $ds_bt;
    } else {
        return 0;
    }
}

function get_de_bai($id_bai_tap)
{
    global $conn;
    $ds_id_bt = [];
    $sql = "SELECT * FROM `bai_tap` WHERE `id_bai_tap`='$id_bai_tap'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {

        while ($row = mysqli_fetch_array($kq)) {
            $ds_id_bt = $row;
        }
        return $ds_id_bt;
    } else {
        return 0;
    }
}
function get_loai_bt($id_bai_tap)
{
    global $conn;
    $sql = "SELECT `id_loai_bt` FROM `bai_tap` WHERE `id_bai_tap`='$id_bai_tap'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {

        $row = mysqli_fetch_array($kq);
        return $row['id_loai_bt'];
    } else {
        return 0;
    }
}
function kt_hoan_thanh_bai_tap($id_bai_tap, $id_luyen_tap)
{
    global $conn;
    $sql = "SELECT * FROM `de_luyen_tap` WHERE `id_luyen_tap` ='$id_luyen_tap' and `id_bai_tap`='$id_bai_tap'";
    $kq = mysqli_query($conn, $sql);
    if (mysqli_num_rows($kq) > 0) {

        $row = mysqli_fetch_array($kq);
        return $row['trang_thai'];
    } else {
        return 0;
    }
}

function diem_luyen_tap($id_luyen_tap)
{
    global $conn;

    // Truy vấn số câu trả lời đúng (trang_thai = 2)
    $sql = "SELECT COUNT(*) FROM `de_luyen_tap` WHERE `id_luyen_tap` = '$id_luyen_tap' AND `trang_thai` = 2";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_row();
        $so_cau_dung = $row[0];  // Số câu trả lời đúng
    } else {
        $so_cau_dung = 0;  // Nếu truy vấn lỗi, mặc định là 0 câu trả lời đúng
    }

    // Truy vấn tổng số câu hỏi
    $sql1 = "SELECT COUNT(*) FROM `de_luyen_tap` WHERE `id_luyen_tap` = '$id_luyen_tap'";
    $result1 = $conn->query($sql1);
    if ($result1) {
        $row1 = $result1->fetch_row();
        $tong_so_cau = $row1[0];  // Tổng số câu hỏi
    } else {
        $tong_so_cau = 0;  // Nếu truy vấn lỗi, mặc định là 0 câu hỏi
    }

    // Tính toán điểm (số câu đúng trên tổng số câu)
    if ($tong_so_cau > 0) {
        $diem = ($so_cau_dung / $tong_so_cau) * 100;  // Điểm = (số câu đúng / tổng số câu) * 10
    } else {
        $diem = 0;  // Nếu không có câu nào, điểm bằng 0
    }

    // Trả về kết quả
    return number_format($diem, 1);
}
function cap_nhat_thoi_gian_luyen_tap($id_luyen_tap)
{
    global $conn;
    $tg_ket_thuc = date("Y-m-d H:i:s");
    $sql = "UPDATE `luyen_tap` SET `thoi_gian_ket_thuc`='$tg_ket_thuc' WHERE `id_luyen_tap`='$id_luyen_tap'";
    mysqli_query($conn, $sql);
}
