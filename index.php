<?php
session_start();
require_once './db_connect.php'; // Đảm bảo đường dẫn đúng
require_once './ham.php'; // Đảm bảo đường dẫn đúng
if (check_login() == 1) {
    header("Location: trang_chu/");
} else {
    header("Location: dang_nhap/");
}
