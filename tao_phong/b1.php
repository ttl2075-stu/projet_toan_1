<?php require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng 
include "../ham.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="b1.css">
    <title>Tính số lượng câu dựa trên tỷ lệ %</title>
    <link rel="stylesheet" href="b1.css"> <!-- Liên kết đến tệp CSS -->
    <style>
        .content {
            display: none;
        }
    </style>
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

    <div class="container">
        <h1>Nhập giải giá trị tham số</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kiểm tra nếu người dùng đã chọn ít nhất một checkbox
            if (isset($_POST['bai_hoc'])) {
                $selected_bai_hoc = $_POST['bai_hoc']; // Mảng chứa các id bài học đã chọn
                $ten_phong  = $_POST['ten_phong'];
        ?>
        <form action="" method="post">
            <input type="hidden" name="loai_phong" value="<?php echo $_POST['loai_phong']; ?>">
            <input type="hidden" name="ten_phong" value="<?php echo $_POST['ten_phong']; ?>">
            
            <?php
            // $ten_phong  = $_POST['ten_phong'];
            echo "<p>Các chủ đề vừa chọn:</p>";
            foreach ($selected_bai_hoc as $index => $bai_hoc_id) {

                echo "<div class='lesson-container'>";
                echo "
                    <div class='d-flex justify-content-between'>
                        <p class='fw-bold'>Chủ đề: " . get_ten_bai_hoc($bai_hoc_id) . "</p>
                        <span class='toggle-button btn btn-secondary' onclick='toggleContent($index)'>Mở rộng</span>
                    </div>
                ";
                echo "<input type='hidden' name='id_bai_hoc[]' value='$bai_hoc_id'>";
                // Nút để mở rộng/thu gọn
                //echo "<span class='toggle-button btn btn-secondary' onclick='toggleContent($index)'>Mở rộng</span>";
                echo "<div id='content-$index' class='content'>"; // ID cho nội dung mở rộng
                echo "
                    <script>
                        var content = document.getElementById('content-' + $index);
                        content.style.display = 'none';
                    </script>
                ";
                // Ô nhập cho các giá trị cần nhập và tính toán
                // Group SL câu hỏi, SL ly nước
                echo '<div class="input-group">';
                echo "<label for='question_count_$index' class='input-group-text fw-bold col-2'>Số lượng câu hỏi:</label>";
                echo "<input class='form-control' type='number' value='5' min='1' max ='20' name='question_count[]' id='question_count_$index' required><br>";
                echo "<div class='thin'></div><div class='thin'></div><div class='thin'></div>";
                echo "<label for='sl_coc$index' class='input-group-text fw-bold col-2'>Số lượng cốc:</label>";
                echo "<input class='form-control' type='number'  value ='3' min='1' max ='10'  name='sl_coc' id='sl_coc_value_$index' required><br>";
                echo "</div>";
                
                // Group số lượng cột, hàng
                echo '<div class="input-group">';
                echo "<label for='sl_cot_$index' class='input-group-text fw-bold col-2'>Số lượng cột:</label>";
                echo "<input class='form-control' type='number'  value ='3' min='1' max ='10' name='sl_cot[]' id='sl_cot_$index' required><br>";
                echo "<div class='thin'></div><div class='thin'></div><div class='thin'></div>";
                echo "<label for='sl_hang_$index' class='input-group-text fw-bold col-2'>Số lượng hàng:</label>";
                echo "<input class='form-control' type='number'  value ='3' min='1' max ='10' name='sl_hang[]' id='sl_hang_$index' required><br>";
                echo "</div>";

                // Group giá trị min, max
                echo '<div class="input-group">';
                echo "<label for='min_value_$index' class='input-group-text fw-bold col-2'>Số nhỏ nhất:</label>";
                echo "<input class='form-control' type='number' value ='1' min='1' max ='10' name='min_value[]' id='min_value_$index' required><br>";
                echo "<div class='thin'></div><div class='thin'></div><div class='thin'></div>";
                echo "<label for='max_value_$index' class='input-group-text fw-bold col-2'>Số lớn nhất:</label>";
                echo "<input class='form-control' type='number'  value ='10' min='1' max ='10' name='max_value[]' id='max_value_$index' required><br>";
                echo "</div>";
                
                // Group giá trị cần chọn, tổng, hiệu
                echo '<div class="input-group">';
                echo "<label for='selected_value_$index' class='input-group-text fw-bold col-2'>Số cần chọn:</label>";
                echo "<input class='form-control' type='number'  value ='3' min='1' max ='10' name='selected_value[]' id='selected_value_$index' required><br>";
                echo "<div class='thin'></div><div class='thin'></div><div class='thin'></div>";
                echo "<label for='sum_value_$index' class='input-group-text fw-bold col-1'>Tổng:</label>";
                echo "<input class='form-control' type='number'  value ='3' min='1' max ='10' name='sum_value[]' id='sum_value_$index' required><br>";
                echo "<div class='thin'></div><div class='thin'></div><div class='thin'></div>";
                echo "<label for='difference_value_$index' class='input-group-text fw-bold col-1'>Hiệu:</label>";
                echo "<input class='form-control' type='number'  value ='3' min='1' max ='10' name='difference_value[]' id='difference_value_$index' required><br>";
                echo "</div>";


                echo "</div>"; // Kết thúc nội dung mở rộng
                echo "</div>"; // Kết thúc lesson-container
            }
            ?>
            <input type="submit" name="btn_xac_nhan" value="Xác nhận" class="btn-confirm">
        </form>

        <?php
            } else if (isset($_POST['btn_xac_nhan'])) {
                // Xử lý khi người dùng nhấn nút xác nhận
                $id_bai_hoc = $_POST['id_bai_hoc'];
                print_r($id_bai_hoc);
                // Lấy tổng số lượng câu hỏi
                // $totalQuestions = $_POST['totalQuestions'];

                // Lấy dữ liệu từ các trường nhập
                $ten_phong = $_POST['ten_phong'];
                $questionCount = $_POST['question_count'];
                $minValue = $_POST['min_value'];
                $maxValue = $_POST['max_value'];
                $selectedValue = $_POST['selected_value'];
                $sumValue = $_POST['sum_value'];
                $differenceValue = $_POST['difference_value'];
                $sl_cot = $_POST['sl_cot'];
                $sl_hang = $_POST['sl_hang'];
                $sl_coc = $_POST['sl_coc'];
                // $loai_cau = [1, 2, 3];
                $loai_phong = $_POST['loai_phong'];
                // print_r($questionCount);
                // echo "Tên phòng" . $ten_phong;
                // Hiển thị dữ liệu người dùng nhập
                // echo "Tổng số lượng câu hỏi: $totalQuestions <br><br>";
                $sql = "INSERT INTO `phong`(`ten_phong`,`loai_phong`) VALUES ('$ten_phong','$loai_phong')";
                mysqli_query($conn, $sql);
                $last_id = mysqli_insert_id($conn);
                foreach ($questionCount as $index => $value) {
                    echo "Bài học $index: <br>";;
                    echo $id_bai_hoc[$index];
                    $loai_cau = get_bt_theo_chu_de($id_bai_hoc[$index]);
                    echo "loại câu";

                    $so_chon = $selectedValue[$index];
                    $tong = $sumValue[$index];
                    $hieu = $differenceValue[$index];
                    for ($i = 0; $i < $value; $i++) {

                        $resultArray = create2DArray($sl_hang[$index], $sl_cot[$index], $minValue[$index], $maxValue[$index]);
                        $taoMang_coc = json_encode(taoMang($sl_coc, $minValue[$index], $maxValue[$index]));
                        $resultArrayJson = json_encode($resultArray);
                        $random_key = array_rand($loai_cau);  // Lấy chỉ mục ngẫu nhiên
                        $random_value = $loai_cau[$random_key];

                        if ($random_value == 1) {
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$resultArrayJson','$so_chon','$tong','$hieu','1','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 2) {
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$resultArrayJson','$so_chon','$tong','$hieu','2','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 3) {
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$taoMang_coc','$so_chon','$tong','$hieu','3','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 4) {
                            $a = json_encode(generate2DArray($minValue[$index], $maxValue[$index], 10));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','4','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 5) {
                            $a = json_encode(hieu($minValue[$index], $maxValue[$index], 10));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','5','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 6) {
                            $a = json_encode(tạo_mang_1_chieu($minValue[$index], $maxValue[$index], rand(1, 10)));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','6','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 7) {
                            $a = json_encode(tạo_mang_1_chieu($minValue[$index], $maxValue[$index], rand(1, 10)));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','7','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        }
                    }


                    header("location: ../trang_chu");
                    echo "Số lượng câu hỏi: $value <br>";
                    echo "Số nhỏ nhất: {$minValue[$index]} <br>";
                    echo "Số lớn nhất: {$maxValue[$index]} <br>";
                    echo "Số lượng cột: {$sl_cot[$index]} <br>";
                    echo "Số lượng hàng: {$sl_hang[$index]} <br>";
                    echo "Số cần chọn: {$selectedValue[$index]} <br>";
                    echo "Tổng: {$sumValue[$index]} <br>";
                    echo "Hiệu: {$differenceValue[$index]} <br><br>";
                }
            }
        }
        ?>
    </div>
    <?php

    function create2DArray($rows, $cols, $minValue, $maxValue)
    {
        $array = [];

        for ($i = 0; $i < $rows; $i++) {
            $array[$i] = []; // Tạo một hàng mới
            for ($j = 0; $j < $cols; $j++) {
                // Tạo một giá trị ngẫu nhiên trong khoảng từ minValue đến maxValue
                $array[$i][$j] = rand($minValue, $maxValue);
            }
        }

        return $array;
    }
    function taoMang($so_luong_phan_tu, $so_nho_nhat, $so_lon_nhat)
    {
        $mang = [];

        if ($so_luong_phan_tu > 0 && $so_nho_nhat <= $so_lon_nhat) {
            for ($i = 0; $i < $so_luong_phan_tu; $i++) {
                $mang[] = rand($so_nho_nhat, $so_lon_nhat);
            }
        }

        return $mang;
    }
    ?>
    <script>
        function toggleContent(index) {
            var content = document.getElementById('content-' + index);
            var button = content.previousElementSibling; // Lấy nút mở rộng

            if (content.style.display === "none") {
                content.style.display = "block"; // Hiển thị nội dung
                button.textContent = "Thu gọn"; // Thay đổi nội dung nút
            } else {
                content.style.display = "none"; // Ẩn nội dung
                button.textContent = "Mở rộng"; // Thay đổi nội dung nút
            }
        }
    </script>

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