<?php
// session_start();
require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng
require_once '../ham.php'; // Đảm bảo đường dẫn đúng
if (check_login() == 1) {
    header("location: ../dang_nhap");
    // echo "chưa đăng nhập";
}
$id_phong = $_GET['id_phong'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="../trang_chu/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Thêm người dùng vào phòng</title>
</head>
<style>
    .btn-them{
        border-radius: 0 5px 5px 0;
    }
    .slt-them{
        border-radius: 5px 0 0 5px;
        width: 100px;
        padding: 0 10px;
    }
    .them-nguoichoi {
        padding: 8px 10px;
    }
    .them-nguoichoi > option {
        padding: 10px;
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
        <section class="room-list">
            <h2>Danh sách người chơi được thêm trong phòng</h2>
        <form action="" method="get">
            <input type="hidden" name="id_phong" value="<?php echo $id_phong; ?>" readonly>
            <div class="input-group">
                <select name="nguoi_dung" id="" class="custom-select slt-them flex-grow-1 them-nguoichoi">
                    <option value="" selected hidden>Chọn học sinh</option>
                    <?php
                        $sql = "SELECT * FROM  `users` ";
                        $kq = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($kq)) {
                            // print_r($row);
                            // $ten = get_ten($row['id_user']);
                            // echo "<br>";

                            echo "<option value='{$row['id']}'>{$row['username']}</option>";
                        }
                    ?>
                </select>
                <div class="input-group-append">
                    <input type="submit" name="btn_them" class="btn btn-primary btn-them them-nguoichoi" value="Thêm">
                </div>
            </div>
        </form>
        <br />
        <table class="room-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ tên</th>
                    <th>Loại tài khoản</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `nguoi_choi_tung_phong` WHERE `id_phong` = '$id_phong'";
                    $kq = mysqli_query($conn, $sql);
                    $stt = 1;
                    while ($row = mysqli_fetch_array($kq)) {
                        // print_r($row);
                        $ten = get_ten($row['id_user']);
                        // echo "<br>";

                        echo "<tr><td class='text-center'>$stt</td><td>{$ten['username']}</td><td class='text-center'>{$ten['role']}</td><td class='text-center'><a class='btn btn-danger' href='../tuy_chinh_phong/xoa_thanh_vien.php?id_phong=$id_phong&id_user={$row['id_user']}'>Xóa thành viên</a></td></tr>";
                        $stt++;
                    }
                ?>
            </tbody>
        </table>
        <?php
        if (isset($_GET['btn_them'])) {
            $id_user = $_GET['nguoi_dung'];
            $id_phong = $_GET['id_phong'];
            // echo $id_user . "-" . $id_phong;
            if ($id_user == "") {
                echo "Vui lòng chọn người dùng";
            } else {
                $sql = "SELECT * FROM `nguoi_choi_tung_phong` WHERE `id_user`='$id_user' and `id_phong`='$id_phong'";
                $kq = mysqli_query($conn, $sql);
                if (mysqli_num_rows($kq) > 0) {
                    echo "<div class='alert alert-danger' role='alert'>Người dùng đã ở trong phòng này rồi</div>";
                } else {
                    $sql = "INSERT INTO `nguoi_choi_tung_phong`(`id_user`, `id_phong`) VALUES ('$id_user','$id_phong')";
                    if (mysqli_query($conn, $sql)) {
                        echo "<div class='alert alert-success' role='alert'>Thêm người dùng vào phòng thành công</div>";
                        header("location: ../tuy_chinh_phong/index.php?id_phong=$id_phong");
                    }
                }
            }
        }
        ?>
        <a class="btn btn-primary" href="../trang_chu/">Trở về </a>
        </section>
    </main>

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