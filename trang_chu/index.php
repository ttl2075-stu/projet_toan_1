<?php
// session_start();
require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng
require_once '../ham.php'; // Đảm bảo đường dẫn đúng
// print_r($_SESSION);
if (check_login() == 1) {
    header("location: ../dang_nhap");
    // echo "chưa đăng nhập";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Trang chủ</title>
</head>

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
            <h2>Danh sách phòng thi đấu</h2>
            <div class="tabs">
                <!-- <button class="tab active">Đấu Trường</button> -->
                <!-- <button class="tab">Cuộc thi OLM</button> -->
                <!-- <button class="tab">Chủ đề HOT</button> -->
            </div>
            <table class="room-table">
                <!-- <tr> -->
                <?php
                if ($_SESSION['role'] == 'gv') {
                ?>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên phòng</th>
                            <th>Vào phòng</th>
                            <th>Thao tác</th>
                            <!-- <th>Lớp</th>
                    <th>Chủ đề</th>
                    <th>Player</th> -->
                            <!-- <th>Vào</th> -->
                        </tr>
                    </thead>
                    <?php
                    $sql = "SELECT * FROM `phong` WHERE 1";
                    $kq = mysqli_query($conn, $sql);
                    $stt = 1;
                    echo '<tbody>';
                    if (mysqli_num_rows($kq) > 0) {
                        while ($row = mysqli_fetch_array($kq)) {
                            echo "<tr>";
                            echo "<td class='text-center'>$stt</td>";
                            echo "<td>{$row['ten_phong']}</td>";
                            echo "<td class='text-center'><a class='btn btn-primary' href='../tao_phong/phong_cho.php?id_phong={$row['id_phong']}'>Vào phòng</a></td>";
                            echo "<td class='text-center'><a class='btn btn-primary' href='../tuy_chinh_phong/index.php?id_phong={$row['id_phong']}'>Tùy chỉnh phòng</a><span class='thin'></span><a class='btn btn-danger' ref='../tao_phong/xoa_phong.php?id_phong={$row['id_phong']}'>Xóa phòng</a></td>";
                            echo "</tr>";
                            $stt++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>Không có phòng nào</td></tr>";
                    }
                    echo '</tbody>';
                } else {
                    ?>
                    <thead>
                        <tr class="text-center">
                            <th>STT</th>
                            <th>Tên phòng</th>
                            <th>Vào phòng</th>
                            <!-- <th>Thao tác</th> -->
                            <!-- <th>Lớp</th>
                    <th>Chủ đề</th>
                    <th>Player</th> -->
                            <!-- <th>Vào</th> -->
                        </tr>
                    </thead>
                <?php
                    $sql = "SELECT * FROM `nguoi_choi_tung_phong` INNER JOIN `phong` WHERE `id_user`='{$_SESSION['id_user']}'";
                    $kq = mysqli_query($conn, $sql);
                    $stt = 1;
                    echo '<tbody>';
                    if (mysqli_num_rows($kq) > 0) {
                        while ($row = mysqli_fetch_array($kq)) {
                            echo "<tr>";
                            echo "<td class='text-center'>$stt</td>";
                            echo "<td>{$row['ten_phong']}</td>";
                            echo "<td class='text-center'><a class='btn btn-primary' href='../tao_phong/phong_cho.php?id_phong={$row['id_phong']}'>Vào phòng</a></td>";
                            // echo "<td><a href='../tao_phong/xoa_phong.php?id_phong={$row['id_phong']}'>Xóa phòng</a><a href='../tuy_chinh_phong/index.php?id_phong={$row['id_phong']}'>Tùy chỉnh phòng</a></td>";
                            echo "</tr>";
                            $stt++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>Không có phòng nào</td></tr>";
                    }
                    echo "</tbody>";
                }

                ?>

                <!-- </tr> -->
                <!-- Thêm các hàng khác tương tự -->
            </table>
            <?php
                if ($_SESSION['role'] == "gv") {
            ?>
            <button onclick="chuyen_huong()" class="create-room">+ Tạo phòng</button><?php
            }
                                                                                        ?>

            <!-- Form tạo phòng ẩn -->

        </section>


    </main>
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

        function chuyen_huong() {
            window.location.href = "../tao_phong/"; // Điều hướng sang trang tao_phong.php
        }
    </script>

</body>

</html>