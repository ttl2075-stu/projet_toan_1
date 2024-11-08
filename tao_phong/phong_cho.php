<?php
// session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
require_once '../db_connect.php';
include "../ham.php";

if (!isset($_SESSION['username'])) {
    header("location: ../dang_nhap");
}
$id_phong = $_GET['id_phong'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phòng chờ</title>
</head>

<body>
    <a href="../trang_chu/">Trở về</a>
    <form action="" method="post">
        <input type="hidden" name="id_phong" value="<?php echo $id_phong; ?>">
        <!-- <a href="./vao_phong.php?id_phong=<?php echo $id_phong; ?>">Bắt đầu</a> -->
        <input type="submit" name="btn_bat_dau" value="Bắt đầu">
    </form>
    <?php
    if (isset($_POST['btn_bat_dau'])) {
        echo "oke";
        $id_phong = $_POST['id_phong'];
        $id_user = $_SESSION['id_user'];
        echo "id_phong:" . $id_phong;
        echo "id_user: " . $_SESSION['id_user'];
        $tg_bat_dau = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `luyen_tap`( `id_phong`, `id_user`, `thoi_gian_bat_dau`) VALUES ('$id_phong','$id_user','$tg_bat_dau')";
        mysqli_query($conn, $sql);
        $last_id = mysqli_insert_id($conn);
        echo "id_vừa_chèn" . $last_id;
        $ds_id_bai_tap = get_bt_theo_phong($id_phong);
        foreach ($ds_id_bai_tap as $key => $value) {
            $sql = "INSERT INTO `de_luyen_tap`( `id_luyen_tap`, `id_bai_tap`) VALUES ('$last_id','$value')";
            mysqli_query($conn, $sql);
        }
        header("location: vao_phong_v2.php?id_phong=$id_phong&id_luyen_tap=$last_id");
    }
    ?>
    <?php
    $sql = "SELECT * FROM `nguoi_choi_tung_phong` WHERE `id_phong`='$id_phong' ORDER BY `nguoi_choi_tung_phong`.`tong_diem_thuong` DESC";
    $kq = mysqli_query($conn, $sql);


    ?>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Điểm</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $stt = 1;
            if (mysqli_num_rows($kq) > 0) {
                while ($row = mysqli_fetch_array($kq)) {
                    $ten = get_ten($row['id_user']);
                    echo "<tr>";
                    echo "<td>$stt</td>";
                    echo "<td>" . $ten['username'] . "</td>";
                    echo "<td>" . $row['tong_diem_thuong'] . "</td>";
                    echo "</tr>";
                    $stt++;
                }
            } else {
                echo "<tr><td colspan='3'>Không có người chới</td></tr>";
            }
            ?>

        </tbody>
    </table>
</body>

</html>