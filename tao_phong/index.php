<?php require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo phòng</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="b1.php" method="post">
        <div class="container">
            <div class="header">
                <h1>Tạo phòng</h1>
            </div>


            <div class="content-settings">
                <h2>Chọn chủ đề</h2>

                <div class="course-type">

                    <?php
                    $sql = "SELECT * FROM bai_hoc";
                    $result = mysqli_query($conn, $sql);

                    // Kiểm tra nếu có kết quả
                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="course-type">';
                        echo '<label>Tích chọn chủ đề:</label>';
                        echo '<div class="course-buttons">';

                        // Duyệt qua các kết quả và tạo checkbox cho mỗi chủ đề
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['trang_thai'] == 1) {
                                echo '<div>';
                                echo '<input type="checkbox" name="bai_hoc[]" value="' . $row["id_bai_hoc"] . '">';
                                echo '<label>' . $row["ten_bai_hoc"] . '</label>';
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

                <div>
                    <h2>Tên phòng</h2>
                    <input required type="text" name="ten_phong" placeholder="Tên phòng" id="">
                </div>
                <div>
                    <h2>Kiểu chơi</h2>
                    <select name="loai_phong" id="">
                        <option value="1">Chơi độc lập</option>
                        <option value="2">Chơi đối kháng</option>
                        <option value="3">Chơi cộng tác</option>
                    </select>

                </div>
                <div class="buttons">
                    <input class="create-room" type="submit" name="btn" value="Tiếp theo">
                    <a href="../trang_chu/">Thoát</a>
                </div>
            </div>
        </div>
    </form>
</body>

</html>