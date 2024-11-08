<?php
require_once '../db_connect.php';
include "../ham.php";
$id_phong = $_GET['id_phong'];
$id_luyen_tap = $_GET['id_luyen_tap'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vào phòng v2</title>
</head>

<body>
    <h1>Vào phòng v2</h1>
    <?php

    $ds_bai_tap = get_bt_theo_id_luyen_tap($id_luyen_tap);
    if ($ds_bai_tap != 0) {
        foreach ($ds_bai_tap as $key => $value) {
            // echo $value . "<br>";
            // print_r($value);
            echo "<br>";
            if (get_de_bai($value['id_bai_tap']) != 0) {
                $de_bai = get_de_bai($value['id_bai_tap']);
                // print_r($de_bai);

                if ($de_bai['id_loai_bt'] == 1) {
                    echo "<a href='../game/nhan_biet.php'>Nhận Biết Game ma trận</a>";
                } elseif ($de_bai['id_loai_bt'] == 2) {
                    echo "<a href='../game/chon_cap.php'>Chọn Cặp Game ma trận</a>";
                } elseif ($de_bai['id_loai_bt'] == 3) {
                    echo "<a href='../game/Pour_Water/nhanbiet/nhanbiet.php'>Nhận Biết Game đổ nước</a>";
                } elseif ($de_bai['id_loai_bt'] == 4) {
                    echo "<a href='../game/Pour_Water/congtru/phepcong.php'>Phép cộng game đổ nước</a>";
                } elseif ($de_bai['id_loai_bt'] == 5) {
                    echo "<a href='../game/Pour_Water/congtru/pheptru.php'>Phép trừ game đổ nước</a>";
                } elseif ($de_bai['id_loai_bt'] == 6) {
                    echo "<a href='../game/Pour_Water/sosanh/sosanh.php'>So sánh lớn</a>";
                } elseif ($de_bai['id_loai_bt'] == 7) {
                    echo "<a href='../game/Pour_Water/sosanh/sosanh.php'>So sánh bé</a>";
                }
            } else {
                echo "Không có bài tập";
            }
        }
    } else {
        echo "Không có bài tập";
    }


    ?>
</body>

</html>