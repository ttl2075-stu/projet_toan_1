<?php require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Tạo phòng</title>
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
        <form action="b1.php" method="post">
            <div class="container">
                <div class="header">
                    <h1 class="text-center">Tạo phòng</h1>
                </div>
    
                <div class="content-settings ">
                    <div class="infoPhong row">
                            <h2>Thông tin phòng:</h2>
                            <div class="input-group">
                                <span class="input-group-text fw-bold" id="addon-wrapping">Tên phòng</span>
                                <input required class="form-control" type="text" name="ten_phong" placeholder="Tên phòng" id="" aria-describedby="addon-wrapping">

                                <div class="thin"></div><div class="thin"></div><div class="thin"></div>

                                <label class="input-group-text fw-bold" for="loai_phong">Kiểu chơi</label>
                                <select class="form-select" name="loai_phong" id="loai_phong">
                                    <option value="1">Chơi độc lập</option>
                                    <option value="2">Chơi đối kháng</option>
                                    <option value="3">Chơi cộng tác</option>
                                </select>

                            </div>
                    </div>
                    <br />
                    <div class="chonChuDe">
                        <h2>Chọn chủ đề:</h2>
                        <div class="course-type">
        
                            <?php
                            $sql = "SELECT * FROM bai_hoc";
                            $result = mysqli_query($conn, $sql);
        
                            // Kiểm tra nếu có kết quả
                            if (mysqli_num_rows($result) > 0) {
                                echo '<div class="course-type">';
                                echo '<p class="mb-0 fw-bold">Tích chọn chủ đề:</p>';
                                echo '<div class="course-buttons d-flex justify-content-between flex-wrap">';
        
                                // Duyệt qua các kết quả và tạo checkbox cho mỗi chủ đề
                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['trang_thai'] == 1) {
                                        echo '<div class="form-check form-check-inline">';
                                        echo '<input type="checkbox" class="form-check-input" name="bai_hoc[]" value="' . $row["id_bai_hoc"] . '" id="' . $row["id_bai_hoc"] . '">';
                                        echo '<label class="form-check-label" for="' . $row["id_bai_hoc"] . '">' . $row["ten_bai_hoc"] . '</label>';
                                        echo '</div>';
                                    }
                                }
        
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo "Không có chủ đề nào.";
                            }
                            ?>
                        </div>
                    </div>
                    <br />
                    <div class="buttons">
                        <input class="create-room btn btn-primary" type="submit" name="btn" value="Tiếp theo">
                        <a class="btn btn-danger" href="../trang_chu/">Thoát</a>
                    </div>
                </div>
            </div>
        </form>
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