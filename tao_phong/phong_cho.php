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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../trang_chu/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Phòng chờ</title>
</head>
<style>
  .block {
    display: block;
    width: 100%;
    margin: 10px 0;
  }
  /* Định dạng table */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }

  table th,
  table td {
    padding: 12px;
    border: 1px solid #ccc;
    text-align: left;
  }

  table th {
    background-color: #0f47ad;
    text-align: center;
    color: white;
  }

  table td {
    background-color: #f9f9f9;
  }
</style>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <a href="./" class="logo-img"></a>
                <span>Toán 1</span>
            </div>

            <nav>
                <ul>
                    <li><a href="#">Tìm phòng đấu</a></li>
                    <li><a href="#">Bảng xếp hạng</a></li>
                    <li><a href="#">Phần thưởng</a></li>
                    <li><a href="#">Thông báo</a></li>
                </ul>
            </nav>

            <div class="user-info">
                <!-- <img src="user-avatar.png" alt="User Avatar" class="user-avatar" id="userAvatar"> -->
                <span id="userName"><?php echo $_SESSION['username'] ?></span>
                <div class="dropdown-menu dropdown-menu-right" id="dropdownMenu">
                    <ul>
                        <li><a href="#">Trang cá nhân</a></li>
                        <li><a href="../dang_xuat/">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <main>
        <h1 class="text-center">Phòng chờ</h1>
        <form action="" method="post">
            <input type="hidden" name="id_phong" readonly value="<?php echo $id_phong; ?>">
            <!-- <a href="./vao_phong.php?id_phong=<?php echo $id_phong; ?>">Bắt đầu</a> -->
            <input type="submit" class="btn btn-primary block" name="btn_bat_dau" value="Bắt đầu">
        </form>
        <a class="btn btn-secondary block" href="../trang_chu/">Trở về</a>
        <br />
        <h2>Danh sách thành viên:</h2>
        <table style="text-align: center;">
            <?php
                $sql = "SELECT * FROM `nguoi_choi_tung_phong` WHERE `id_phong`='$id_phong' ORDER BY `nguoi_choi_tung_phong`.`tong_diem_thuong` DESC";
                $kq = mysqli_query($conn, $sql);
            ?>
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

    </main>

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
</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const userName = document.getElementById("userName");
        const dropdownMenu = document.getElementById("dropdownMenu");

        // Khi nhấn vào tên người dùng, hiển thị hoặc ẩn menu
        userName.addEventListener("click", function() {
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
        });

        // Khi nhấn ra ngoài menu thì ẩn menu
        document.addEventListener("click", function(event) {
            if (!userName.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.style.display = "none";
            }
        });
    });
</script>